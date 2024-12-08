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

use Illuminate\Database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\Transformer\RequestDataTransformer;
use UserFrosting\Fortress\Validator\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Mail\VerificationEmail;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Sprinkle\Core\Throttle\ThrottlerDelayException;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/**
 * Processes a request to resend the verification email for a new user account.
 *
 * Processes the request from the resend verification email form, checking that:
 * 1. The rate limit on this type of request is observed;
 * 2. The provided email is associated with an existing user account;
 * 3. The user account is not already verified;
 * 4. The submitted data is valid.
 * This route is "public access".
 *
 * Middleware: GuestGuard
 * Route: /account/resend-verification
 * Route Name: account.resendVerification
 * Request type: POST
 */
class ResendVerificationAction
{
    // Request schema to use to validate data.
    protected string $schema = 'schema://requests/resend-verification.yaml';

    // Throttler key slug
    protected string $throttlerSlug = 'verification_request';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected Config $config,
        protected Connection $db,
        protected RouteParserInterface $routeParser,
        protected Throttler $throttler,
        protected UserInterface $userModel,
        protected VerificationEmail $verificationEmail,
        protected RequestDataTransformer $transformer,
        protected ServerSideValidator $validator
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
        $message = $this->handle($request);
        $payload = json_encode([
            'message' => $message,
        ], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return string The message to be returned to the client.
     */
    protected function handle(Request $request): string
    {
        // Get POST parameters
        $params = (array) $request->getParsedBody();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $data = $this->transformer->transform($schema, $params);

        // Validate request data
        $this->validateData($schema, $data);

        // Throttle requests
        $this->throttle($data['email']);

        // All checks passed!  log events/activities, create user, and send verification email (if required)
        // Begin transaction - DB will be rolled back if an exception occurs
        $this->db->transaction(function () use ($data) {
            // Log throttle-able event
            $this->throttler->logEvent($this->throttlerSlug, [
                'email' => $data['email'],
            ]);

            // Load the user, by email address
            /** @var UserInterface|null */
            $user = $this->userModel->firstWhere('email', $data['email']);

            // Check that the user exists and is not already verified.
            // If there is no user with that email address, or the user exists and is already verified,
            // we pretend like we succeeded to prevent account enumeration
            if ($user !== null && $user->flag_verified === false) {
                $this->verificationEmail->send($user, 'mail/resend-verification.html.twig');
            }
        });

        return $this->translator->translate('ACCOUNT.VERIFICATION.NEW_LINK_SENT', ['email' => $data['email']]);
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        return new RequestSchema($this->schema);
    }

    /**
     * Validate request POST data.
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

    /**
     * Throttle requests.
     *
     * @param string $email
     */
    protected function throttle(string $email): void
    {
        $delay = $this->throttler->getDelay($this->throttlerSlug, [
            'email' => $email,
        ]);
        if ($delay > 0) {
            $e = new ThrottlerDelayException();
            $e->setDelay($delay);

            throw $e;
        }
    }
}
