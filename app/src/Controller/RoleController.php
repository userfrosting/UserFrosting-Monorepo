<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\BadRequestException;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Support\Exception\NotFoundException;

/**
 * Controller class for role-related requests, including listing roles, CRUD for roles, etc.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class RoleController extends SimpleController
{
    /**
     * Returns info for a single role, along with associated permissions.
     *
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws ForbiddenException If user is not authorized to access page
     * @throws NotFoundException  If role is not found
     */
    public function getInfo(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'uri_roles')) {
            throw new ForbiddenException();
        }

        $slug = $args['slug'];

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $role = $classMapper->getClassMapping('role')::where('slug', $slug)->first();

        // If the role doesn't exist, return 404
        if (!$role) {
            throw new NotFoundException();
        }

        // Get role
        $result = $role->load('permissions')->toArray();

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }

    /**
     * Renders the modal form for editing an existing role.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException  If role is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getModalEdit(Request $request, Response $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        $role = $this->getRoleFromParams($params);

        // If the role doesn't exist, return 404
        if (!$role) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        /** @var \UserFrosting\I18n\Translator $translator */
        $translator = $this->ci->translator;

        // Access-controlled resource - check that currentUser has permission to edit basic fields "name", "slug", "description" for this role
        $fieldNames = ['name', 'slug', 'description'];
        if (!$authorizer->checkAccess($currentUser, 'update_role_field', [
            'role' => $role,
            'fields' => $fieldNames,
        ])) {
            throw new ForbiddenException();
        }

        // Generate form
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];

        // Load validation rules
        $schema = new RequestSchema('schema://requests/role/edit-info.yaml');
        $validator = new JqueryValidationAdapter($schema, $translator);

        return $this->ci->view->render($response, 'modals/role.html.twig', [
            'role' => $role,
            'form' => [
                'action'      => "api/roles/r/{$role->slug}",
                'method'      => 'PUT',
                'fields'      => $fields,
                'submit_text' => $translator->translate('UPDATE'),
            ],
            'page' => [
                'validators' => $validator->rules('json', false),
            ],
        ]);
    }

    /**
     * Renders the modal form for editing a role's permissions.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException  If role is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getModalEditPermissions(Request $request, Response $response, $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        $role = $this->getRoleFromParams($params);

        // If the role doesn't exist, return 404
        if (!$role) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit "permissions" field for this role
        if (!$authorizer->checkAccess($currentUser, 'update_role_field', [
            'role' => $role,
            'fields' => ['permissions'],
        ])) {
            throw new ForbiddenException();
        }

        return $this->ci->view->render($response, 'modals/role-manage-permissions.html.twig', [
            'role' => $role,
        ]);
    }

    /**
     * Returns a list of Permissions for a specified Role.
     *
     * Generates a list of permissions, optionally paginated, sorted and/or filtered.
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException  If role is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getPermissions(Request $request, Response $response, $args)
    {
        $role = $this->getRoleFromParams($args);

        // If the role no longer exists, forward to main role listing page
        if (!$role) {
            throw new NotFoundException();
        }

        // GET parameters
        $params = $request->getQueryParams();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'view_role_field', [
            'role' => $role,
            'property' => 'permissions',
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = $classMapper->createInstance('permission_sprunje', $classMapper, $params);
        $sprunje->extendQuery(function ($query) use ($role) {
            return $query->forRole($role->id);
        });

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    /**
     * Returns users associated with a single role.
     *
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException  If role is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getUsers(Request $request, Response $response, $args)
    {
        $role = $this->getRoleFromParams($args);

        // If the role doesn't exist, return 404
        if (!$role) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        // GET parameters
        $params = $request->getQueryParams();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'view_role_field', [
            'role' => $role,
            'property' => 'users',
        ])) {
            throw new ForbiddenException();
        }

        $sprunje = $classMapper->createInstance('user_sprunje', $classMapper, $params);
        $sprunje->extendQuery(function ($query) use ($role) {
            return $query->forRole($role->id);
        });

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

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
     *
     * @see getModalRoleEdit
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException  If role is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function updateInfo(Request $request, Response $response, $args)
    {
        // Get the role based on slug in the URL
        $role = $this->getRoleFromParams($args);

        if (!$role) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // Get PUT parameters: (name, slug, description)
        $params = $request->getParsedBody();

        /** @var \UserFrosting\I18n\Translator $translator */
        $ms = $this->ci->alerts;

        // Load the request schema
        $schema = new RequestSchema('schema://requests/role/edit-info.yaml');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        $error = false;

        // Validate request data
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            $ms->addValidationErrors($validator);
            $error = true;
        }

        // Determine targeted fields
        $fieldNames = [];
        foreach ($data as $name => $value) {
            $fieldNames[] = $name;
        }

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit submitted fields for this role
        if (!$authorizer->checkAccess($currentUser, 'update_role_field', [
            'role' => $role,
            'fields' => array_values(array_unique($fieldNames)),
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        // Check if name or slug already exists
        if (
            isset($data['name']) &&
            $data['name'] != $role->name &&
            $classMapper->getClassMapping('role')::where('name', $data['name'])->first()
        ) {
            $ms->addMessageTranslated('danger', 'ROLE.NAME_IN_USE', $data);
            $error = true;
        }

        if (
            isset($data['slug']) &&
            $data['slug'] != $role->slug &&
            $classMapper->getClassMapping('role')::where('slug', $data['slug'])->first()
        ) {
            $ms->addMessageTranslated('danger', 'SLUG_IN_USE', $data);
            $error = true;
        }

        if ($error) {
            return $response->withJson([], 400);
        }

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($data, $role, $currentUser) {
            // Update the role and generate success messages
            foreach ($data as $name => $value) {
                if ($value != $role->$name) {
                    $role->$name = $value;
                }
            }

            $role->save();

            // Create activity record
            $this->ci->userActivityLogger->info("User {$currentUser->user_name} updated details for role {$role->name}.", [
                'type'    => 'role_update_info',
                'user_id' => $currentUser->id,
            ]);
        });

        $ms->addMessageTranslated('success', 'ROLE.UPDATED', [
            'name' => $role->name,
        ]);

        return $response->withJson([], 200);
    }

    /**
     * Processes the request to update a specific field for an existing role, including permissions.
     *
     * Processes the request from the role update form, checking that:
     * 1. The logged-in user has the necessary permissions to update the putted field(s);
     * 2. The submitted data is valid.
     * This route requires authentication.
     *
     * Request type: PUT
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @throws NotFoundException   If role is not found
     * @throws ForbiddenException  If user is not authorized to access page
     * @throws BadRequestException
     */
    public function updateField(Request $request, Response $response, $args)
    {
        // Get the username from the URL
        $role = $this->getRoleFromParams($args);

        if (!$role) {
            throw new NotFoundException();
        }

        // Get key->value pair from URL and request body
        $fieldName = $args['field'];

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit the specified field for this user
        if (!$authorizer->checkAccess($currentUser, 'update_role_field', [
            'role' => $role,
            'fields' => [$fieldName],
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // Get PUT parameters: value
        $put = $request->getParsedBody();

        if (!isset($put['value'])) {
            throw new BadRequestException();
        }

        $params = [
            $fieldName => $put['value'],
        ];

        // Validate key -> value pair

        // Load the request schema
        $schema = new RequestSchema('schema://requests/role/edit-field.yaml');
        $schema->set('password.validators.length.min', $config['site.password.length.min']);
        $schema->set('password.validators.length.max', $config['site.password.length.max']);

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate, and throw exception on validation errors.
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            // TODO: encapsulate the communication of error messages from ServerSideValidator to the BadRequestException
            $e = new BadRequestException();
            foreach ($validator->errors() as $idx => $field) {
                foreach ($field as $eidx => $error) {
                    $e->addUserMessage($error);
                }
            }

            throw $e;
        }

        // Get validated and transformed value
        $fieldValue = $data[$fieldName];

        /** @var \UserFrosting\I18n\Translator $translator */
        $ms = $this->ci->alerts;

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($fieldName, $fieldValue, $role, $currentUser) {
            if ($fieldName == 'permissions') {
                $newPermissions = collect($fieldValue)->pluck('permission_id')->all();
                $role->permissions()->sync($newPermissions);
            } else {
                $role->$fieldName = $fieldValue;
                $role->save();
            }

            // Create activity record
            $this->ci->userActivityLogger->info("User {$currentUser->user_name} updated property '$fieldName' for role {$role->name}.", [
                'type'    => 'role_update_field',
                'user_id' => $currentUser->id,
            ]);
        });

        // Add success messages
        if ($fieldName == 'permissions') {
            $ms->addMessageTranslated('success', 'ROLE.PERMISSIONS_UPDATED', [
                'name' => $role->name,
            ]);
        } else {
            $ms->addMessageTranslated('success', 'ROLE.UPDATED', [
                'name' => $role->name,
            ]);
        }

        return $response->withJson([], 200);
    }
}
