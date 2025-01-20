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
use UserFrosting\Config\Config;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\Transformer\RequestDataTransformer;
use UserFrosting\Fortress\Validator\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\EmailNotUniqueException;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Exceptions\PasswordInvalidException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLoggerInterface;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Processes a request to update a user's account information.
 *
 * Processes the request from the user account settings form, checking that:
 * 1. The user correctly input their current password;
 * 2. They have the necessary permissions to update the posted field(s);
 * 3. The submitted data is valid.
 * This route requires authentication.
 *
 * Middleware: AuthGuard
 * Route: /account/settings/email
 * Route Name: settings.email
 * Request type: POST
 */
class ProfileEmailEditAction
{
    // Request schema to use to validate data.
    protected string $schema = 'schema://requests/account-email.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected Authenticator $authenticator,
        protected Config $config,
        protected UserActivityLoggerInterface $logger,
        protected UserInterface $userModel,
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
        $this->handle($request);

        $payload = json_encode([
            'message' => $this->translator->translate('ACCOUNT.SETTINGS.UPDATED'),
        ], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     */
    protected function handle(Request $request): void
    {
        // Access control for entire resource - check that the current user has permission to modify themselves
        // See recipe "per-field access control" for dynamic fine-grained control over which properties a user can modify.
        if (!$this->authenticator->checkAccess('update_account_settings')) {
            throw new ForbiddenException();
        }

        // Get POST parameters
        $params = (array) $request->getParsedBody();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $data = $this->transformer->transform($schema, $params);

        // Get current user. Won't be null, as AuthGuard prevent it.
        /** @var UserInterface */
        $currentUser = $this->authenticator->user();

        // Validate request data
        $this->validateData($schema, $data);

        // Confirm current password
        if ($currentUser->comparePassword($data['passwordcheck']) === false) {
            throw new PasswordInvalidException();
        }

        // Remove password check from object data after validation
        unset($data['passwordcheck']);

        // If new email was submitted, check that the email address is not in use
        if ($data['email'] !== $currentUser->email && $this->userModel::findUnique($data['email'], 'email') !== null) {
            throw new EmailNotUniqueException();
        }

        // Looks good, let's update with new values!
        // Note that only fields listed in `account-email.yaml` will be
        // permitted in $data, so this prevents the user from updating all columns in the DB
        $currentUser->fill($data);
        $currentUser->save();

        // Create activity record
        $this->logger->info("User {$currentUser->user_name} updated their account settings.", [
            'type'    => 'update_account_settings',
            'user_id' => $currentUser->id,
        ]);
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
}
