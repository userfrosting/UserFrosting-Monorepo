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
