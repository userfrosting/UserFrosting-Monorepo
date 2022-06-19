<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Role;

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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Processes the request to update an existing role's details.
 *
 * Processes the request from the role update form, checking that:
 * 1. The role name/slug are not already in use;
 * 2. The user has the necessary permissions to update the posted field(s);
 * 3. The submitted data is valid.
 * This route requires authentication (and should generally be limited to admins or the root user).
 *
 * Request type: PUT
 */
class RoleEditAction
{
    // Request schema for client side form validation
    protected string $schema = 'schema://requests/role/edit-info.yaml';

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
        protected RoleInterface $roleModel,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param RoleInterface $role     The role to update, injected from middleware.
     * @param Request       $request
     * @param Response      $response
     */
    public function __invoke(RoleInterface $role, Request $request, Response $response): Response
    {
        $this->handle($role, $request);
        $payload = json_encode([], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request.
     *
     * @param RoleInterface $role
     * @param Request       $request
     */
    protected function handle(RoleInterface $role, Request $request): void
    {
        // Get PUT parameters
        $params = (array) $request->getParsedBody();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate request data
        $this->validateData($schema, $data);
        if ($data['name'] !== $role->name) {
            $this->validateName($data['name']);
        }
        if ($data['slug'] !== $role->slug) {
            $this->validateSlug($data['slug']);
        }

        // Determine targeted fields
        $fieldNames = [];
        foreach ($data as $name => $value) {
            $fieldNames[] = $name;
        }

        // Access-controlled resource - check that currentUser has permission to edit submitted fields for this user
        if (!$this->authenticator->checkAccess('update_role_field', [
            'role' => $role,
            'fields' => array_values(array_unique($fieldNames)),
        ])) {
            throw new ForbiddenException();
        }

        // Get current user. Won't be null, as AuthGuard prevent it
        /** @var UserInterface */
        $currentUser = $this->authenticator->user();

        // Begin transaction - DB will be rolled back if an exception occurs
        $this->db->transaction(function () use ($data, $role, $currentUser) {
            // Update the user and generate success messages
            foreach ($data as $name => $value) {
                $role->setAttribute($name, $value);
            }

            $role->save();

            // Create activity record
            $this->userActivityLogger->info("User {$currentUser->user_name} updated details for role {$role->name}.", [
                'type'    => 'role_update_info',
                'user_id' => $currentUser->id,
            ]);
        });

        $this->alert->addMessageTranslated('success', 'ROLE.UPDATED', [
            'name' => $role->name,
        ]);
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
     * Validate name is not already in use.
     *
     * @param string $name
     */
    protected function validateName(string $name): void
    {
        $group = $this->roleModel->where('name', $name)->first();
        if ($group !== null) {
            $e = new RoleException();
            $message = new UserMessage('ROLE.NAME_IN_USE', ['name' => $name]);
            $e->setDescription($message);

            throw $e;
        }
    }

    /**
     * Validate slug is not already in use.
     *
     * @param string $slug
     */
    protected function validateSlug(string $slug): void
    {
        $group = $this->roleModel->where('slug', $slug)->first();
        if ($group !== null) {
            $e = new RoleException();
            $message = new UserMessage('SLUG_IN_USE', ['slug' => $slug]);
            $e->setDescription($message);

            throw $e;
        }
    }
}
