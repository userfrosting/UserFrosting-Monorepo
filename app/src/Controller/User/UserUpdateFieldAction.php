<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\User;

use Illuminate\Database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\AccountException;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Admin\Controller\Helpers\TranslateExceptionPart;
use UserFrosting\Sprinkle\Admin\Exceptions\MissingRequiredParamException;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Processes the request to update a specific field for an existing user.
 *
 * Supports editing all user fields, including password, enabled/disabled status and verification status.
 * Processes the request from the user update form, checking that:
 * 1. The logged-in user has the necessary permissions to update the putted field(s);
 * 2. We're not trying to disable the master account;
 * 3. The submitted data is valid.
 *
 * This route requires authentication.
 * Request type: PUT
 */
class UserUpdateFieldAction
{
    use TranslateExceptionPart;

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/user/edit-field.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected Config $config,
        protected Connection $db,
        protected Translator $translator,
        protected UserActivityLogger $userActivityLogger,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param UserInterface $user     The user, injected by the middleware.
     * @param string        $field    The field to update.
     * @param Request       $request
     * @param Response      $response
     */
    public function __invoke(
        UserInterface $user,
        string $field,
        Request $request,
        Response $response
    ): Response {
        try {
            $this->handle($user, $field, $request);
        } catch (UserMessageException $e) {
            $title = $this->translateExceptionPart($e->getTitle());
            $description = $this->translateExceptionPart($e->getDescription());
            $this->alert->addMessage('danger', "$title: $description");

            throw $e;
        }

        $payload = json_encode([], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request.
     *
     * @param UserInterface $user
     * @param string        $fieldName
     * @param Request       $request
     */
    protected function handle(
        UserInterface $user,
        string $fieldName,
        Request $request
    ): void {
        // Access-controlled resource - check that current User has permission
        // to edit the specified field for this user
        $this->validateAccess($user, $fieldName);

        // Get current user. Won't be null, as AuthGuard prevent it
        /** @var UserInterface */
        $currentUser = $this->authenticator->user();

        // Only the master account can edit the master account!
        if (
            ($user->id === $this->config->get('reserved_user_ids.master')) &&
            ($currentUser->id !== $this->config->get('reserved_user_ids.master'))
        ) {
            throw new ForbiddenException();
        }

        // Get PUT parameters: value
        $put = (array) $request->getParsedBody();

        // Make sure data is part of $_PUT data.
        // Except for roles, which we allows to be empty.
        if (isset($put[$fieldName])) {
            $fieldData = $put[$fieldName];
        } elseif ($fieldName === 'roles') {
            $fieldData = [];
        } else {
            $e = new MissingRequiredParamException();
            $e->setParam($fieldName);

            throw $e;
        }

        // Create and validate key -> value pair
        $params = [
            $fieldName => $fieldData,
        ];

        // Add password confirmation if needed
        if ($fieldName === 'password') {
            $params['passwordc'] = $put['passwordc'];
        }

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate request data
        $this->validateData($schema, $data);

        // Get validated and transformed value
        $fieldValue = $data[$fieldName];

        // Special checks and transformations for certain fields
        if ($fieldName === 'flag_enabled') {
            // Check that we are not disabling the master account
            if (
                $user->id == $this->config->get('reserved_user_ids.master') &&
                $fieldValue === '0'
            ) {
                $e = new AccountException();
                $e->setTitle('DISABLE_MASTER');

                throw $e;
            }

            // Check that we are not disabling the current user
            if ($user->id === $currentUser->id && $fieldValue === '0') {
                $e = new AccountException();
                $e->setTitle('DISABLE_SELF');

                throw $e;
            }
        }

        // Begin transaction - DB will be rolled back if an exception occurs
        $this->db->transaction(function () use ($fieldName, $fieldValue, $user, $currentUser) {
            if ($fieldName === 'roles') {
                $newRoles = collect($fieldValue)->pluck('role_id')->all();
                $user->roles()->sync($newRoles);
            } else {
                $user->$fieldName = $fieldValue; // @phpstan-ignore-line Variable property is ok here.
                $user->save();
            }

            // Create activity record
            $this->userActivityLogger->info("User {$currentUser->user_name} updated property '$fieldName' for user {$user->user_name}.", [
                'type'    => 'account_update_field',
                'user_id' => $user->id,
            ]);
        });

        // Add success messages
        if ($fieldName === 'flag_enabled' && $fieldValue === '1') {
            $this->alert->addMessageTranslated('success', 'ENABLE_SUCCESSFUL', [
                'user_name' => $user->user_name,
            ]);
        } elseif ($fieldName === 'flag_enabled') {
            $this->alert->addMessageTranslated('success', 'DISABLE_SUCCESSFUL', [
                'user_name' => $user->user_name,
            ]);
        } elseif ($fieldName == 'flag_verified') {
            $this->alert->addMessageTranslated('success', 'MANUALLY_ACTIVATED', [
                'user_name' => $user->user_name,
            ]);
        } else {
            $this->alert->addMessageTranslated('success', 'DETAILS_UPDATED', [
                'user_name' => $user->user_name,
            ]);
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
        $schema->set('password.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('password.validators.length.max', $this->config->get('site.password.length.max'));
        $schema->set('passwordc.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('passwordc.validators.length.max', $this->config->get('site.password.length.max'));

        return $schema;
    }

    /**
     * Validate request POST data.
     *
     * @param RequestSchemaInterface $schema
     * @param mixed[]                $data
     */
    protected function validateData(RequestSchemaInterface $schema, array $data): void
    {
        $validator = new ServerSideValidator($schema, $this->translator);
        if ($validator->validate($data) === false && is_array($validator->errors())) {
            $e = new ValidationException();
            $e->addErrors($validator->errors());

            throw $e;
        }
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(UserInterface $user, string $fieldName): void
    {
        if (!$this->authenticator->checkAccess('update_user_field', [
            'user' => $user,
            'fields' => [$fieldName],
        ])) {
            throw new ForbiddenException();
        }
    }
}
