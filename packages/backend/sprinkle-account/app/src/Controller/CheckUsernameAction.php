<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\Transformer\RequestDataTransformer;
use UserFrosting\Fortress\Validator\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Sprinkle\Core\Throttle\ThrottlerDelayException;

/**
 * Check a username for availability.
 *
 * This route is throttled by default, to discourage abusing it for account enumeration.
 * This route is "public access".
 *
 * Middleware: none
 * Route: /account/check-username
 * Route Name: account.check-username
 * Request type: GET
 */
class CheckUsernameAction
{
    // Request schema to use to validate data.
    protected string $schema = 'schema://requests/check-username.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Throttler $throttler,
        protected Translator $translator,
        protected UserInterface $userModel,
        protected RequestDataTransformer $transformer,
        protected ServerSideValidator $validator,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = $this->handle($request);
        $payload = json_encode($payload, JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return array<string, string|bool>
     */
    protected function handle(Request $request): array
    {
        // Throttle requests.
        $this->throttle();

        // GET parameters
        $params = $request->getQueryParams();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $data = $this->transformer->transform($schema, $params);

        // Validate request data
        $this->validateData($schema, $data);

        // Log throttle-able event
        $this->throttler->logEvent('check_username_request');

        if ($this->userModel::findUnique($data['user_name'], 'user_name') !== null) {
            $message = $this->translator->translate('USERNAME.NOT_AVAILABLE', $data);

            return [
                'available' => false,
                'message'   => $message,
            ];
        }

        return [
            'available' => true,
            'message'   => '',
        ];
    }

    /**
     * Throttle requests.
     */
    protected function throttle(): void
    {
        $delay = $this->throttler->getDelay('check_username_request');
        if ($delay > 0) {
            $e = new ThrottlerDelayException();
            $e->setDelay($delay);

            throw $e;
        }
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->schema);

        return $schema;
    }

    /**
     * Validate request data.
     *
     * @param RequestSchemaInterface $schema
     * @param mixed[]                $data
     */
    protected function validateData(RequestSchemaInterface $schema, array $data): void
    {
        $errors = $this->validator->validate($schema, $data);
        if (count($errors) !== 0) {
            $e = new ValidationException();
            $e->addErrors($errors);

            throw $e;
        }
    }
}
