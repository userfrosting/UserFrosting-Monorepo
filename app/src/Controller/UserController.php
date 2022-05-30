<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Facades\Password;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;
use UserFrosting\Support\Exception\BadRequestException;
use UserFrosting\Support\Exception\ForbiddenException;
use UserFrosting\Support\Exception\NotFoundException;

/**
 * Controller class for user-related requests, including listing users, CRUD for users, etc.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class UserController extends SimpleController
{
    /**
     * Processes the request to send a user a password reset email.
     *
     * Processes the request from the user update form, checking that:
     * 1. The target user's new email address, if specified, is not already in use;
     * 2. The logged-in user has the necessary permissions to update the posted field(s);
     * 3. We're not trying to disable the master account;
     * 4. The submitted data is valid.
     * This route requires authentication.
     *
     * Request type: POST
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function createPasswordReset(Request $request, Response $response, array $args)
    {
        // Get the username from the URL
        $user = $this->getUserFromParams($args);

        if (!$user) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit "password" for this user
        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
            'user' => $user,
            'fields' => ['password'],
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($user, $config) {

            // Create a password reset and shoot off an email
            $passwordReset = $this->ci->repoPasswordReset->create($user, $config['password_reset.timeouts.reset']);

            // Create and send welcome email with password set link
            $message = new TwigMailMessage($this->ci->view, 'mail/password-reset.html.twig');

            $message->from($config['address_book.admin'])
                    ->addEmailRecipient(new EmailRecipient($user->email, $user->full_name))
                    ->addParams([
                        'user'         => $user,
                        'token'        => $passwordReset->getToken(),
                        'request_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

            $this->ci->mailer->send($message);
        });

        $ms->addMessageTranslated('success', 'PASSWORD.FORGET.REQUEST_SENT', [
            'email' => $user->email,
        ]);

        return $response->withJson([], 200);
    }

    /**
     * Returns info for a single user.
     *
     * This page requires authentication.
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getInfo(Request $request, Response $response, array $args)
    {
        $user = $this->getUserFromParams($args);

        // If the user doesn't exist, return 404
        if (!$user) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        // Join user's most recent activity
        $user = $classMapper->createInstance('user')
                            ->where('user_name', $user->user_name)
                            ->joinLastActivity()
                            ->with('lastActivity', 'group')
                            ->first();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'uri_user', [
            'user' => $user,
        ])) {
            throw new ForbiddenException();
        }

        $result = $user->toArray();

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }

    /**
     * Renders the modal form for editing a user's password.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getModalEditPassword(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        $user = $this->getUserFromParams($params);

        // If the user doesn't exist, return 404
        if (!$user) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // Access-controlled resource - check that currentUser has permission to edit "password" field for this user
        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
            'user' => $user,
            'fields' => ['password'],
        ])) {
            throw new ForbiddenException();
        }

        // Load validation rules
        $schema = new RequestSchema('schema://requests/user/edit-password.yaml');
        $schema->set('password.validators.length.min', $config['site.password.length.min']);
        $schema->set('password.validators.length.max', $config['site.password.length.max']);
        $schema->set('passwordc.validators.length.min', $config['site.password.length.min']);
        $schema->set('passwordc.validators.length.max', $config['site.password.length.max']);
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        return $this->ci->view->render($response, 'modals/user-set-password.html.twig', [
            'user' => $user,
            'page' => [
                'validators' => $validator->rules('json', false),
            ],
        ]);
    }

    /**
     * Renders the modal form for editing a user's roles.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * This page requires authentication.
     *
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getModalEditRoles(Request $request, Response $response, array $args)
    {
        // GET parameters
        $params = $request->getQueryParams();

        $user = $this->getUserFromParams($params);

        // If the user doesn't exist, return 404
        if (!$user) {
            throw new NotFoundException();
        }

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit "roles" field for this user
        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
            'user' => $user,
            'fields' => ['roles'],
        ])) {
            throw new ForbiddenException();
        }

        return $this->ci->view->render($response, 'modals/user-manage-roles.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Returns a list of effective Permissions for a specified User.
     *
     * Generates a list of permissions, optionally paginated, sorted and/or filtered.
     * This page requires authentication.
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getPermissions(Request $request, Response $response, array $args)
    {
        $user = $this->getUserFromParams($args);

        // If the user doesn't exist, return 404
        if (!$user) {
            throw new NotFoundException();
        }

        // GET parameters
        $params = $request->getQueryParams();

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'view_user_field', [
            'user' => $user,
            'property' => 'permissions',
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $params['user_id'] = $user->id;
        $sprunje = $classMapper->createInstance('user_permission_sprunje', $classMapper, $params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    /**
     * Returns roles associated with a single user.
     *
     * This page requires authentication.
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException  If user is not found
     * @throws ForbiddenException If user is not authorized to access page
     */
    public function getRoles(Request $request, Response $response, array $args)
    {
        $user = $this->getUserFromParams($args);

        // If the user doesn't exist, return 404
        if (!$user) {
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
        if (!$authorizer->checkAccess($currentUser, 'view_user_field', [
            'user' => $user,
            'property' => 'roles',
        ])) {
            throw new ForbiddenException();
        }

        $sprunje = $classMapper->createInstance('role_sprunje', $classMapper, $params);
        $sprunje->extendQuery(function ($query) use ($user) {
            return $query->forUser($user->id);
        });

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

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
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     *
     * @throws NotFoundException   If user is not found
     * @throws ForbiddenException  If user is not authorized to access page
     * @throws BadRequestException
     */
    public function updateField(Request $request, Response $response, array $args)
    {
        // Get the username from the URL
        $user = $this->getUserFromParams($args);

        if (!$user) {
            throw new NotFoundException();
        }

        // Get key->value pair from URL and request body
        $fieldName = $args['field'];

        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager $authorizer */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled resource - check that currentUser has permission to edit the specified field for this user
        if (!$authorizer->checkAccess($currentUser, 'update_user_field', [
            'user' => $user,
            'fields' => [$fieldName],
        ])) {
            throw new ForbiddenException();
        }

        /** @var \UserFrosting\Support\Repository\Repository $config */
        $config = $this->ci->config;

        // Only the master account can edit the master account!
        if (
            ($user->id == $config['reserved_user_ids.master']) &&
            ($currentUser->id != $config['reserved_user_ids.master'])
        ) {
            throw new ForbiddenException();
        }

        // Get PUT parameters: value
        $put = $request->getParsedBody();

        // Make sure data is part of $_PUT data
        if (isset($put[$fieldName])) {
            $fieldData = $put[$fieldName];
        } else {
            throw new BadRequestException();
        }

        // Create and validate key -> value pair
        $params = [
            $fieldName => $fieldData,
        ];

        // Load the request schema
        $schema = new RequestSchema('schema://requests/user/edit-field.yaml');
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

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        // Special checks and transformations for certain fields
        if ($fieldName == 'flag_enabled') {
            // Check that we are not disabling the master account
            if (
                ($user->id == $config['reserved_user_ids.master']) &&
                ($fieldValue == '0')
            ) {
                $e = new BadRequestException();
                $e->addUserMessage('DISABLE_MASTER');

                throw $e;
            } elseif (
                ($user->id == $currentUser->id) &&
                ($fieldValue == '0')
            ) {
                $e = new BadRequestException();
                $e->addUserMessage('DISABLE_SELF');

                throw $e;
            }
        } elseif ($fieldName == 'password') {
            $fieldValue = Password::hash($fieldValue);
        }

        // Begin transaction - DB will be rolled back if an exception occurs
        Capsule::transaction(function () use ($fieldName, $fieldValue, $user, $currentUser) {
            if ($fieldName == 'roles') {
                $newRoles = collect($fieldValue)->pluck('role_id')->all();
                $user->roles()->sync($newRoles);
            } else {
                $user->$fieldName = $fieldValue;
                $user->save();
            }

            // Create activity record
            $this->ci->userActivityLogger->info("User {$currentUser->user_name} updated property '$fieldName' for user {$user->user_name}.", [
                'type'    => 'account_update_field',
                'user_id' => $currentUser->id,
            ]);
        });

        // Add success messages
        if ($fieldName == 'flag_enabled') {
            if ($fieldValue == '1') {
                $ms->addMessageTranslated('success', 'ENABLE_SUCCESSFUL', [
                    'user_name' => $user->user_name,
                ]);
            } else {
                $ms->addMessageTranslated('success', 'DISABLE_SUCCESSFUL', [
                    'user_name' => $user->user_name,
                ]);
            }
        } elseif ($fieldName == 'flag_verified') {
            $ms->addMessageTranslated('success', 'MANUALLY_ACTIVATED', [
                'user_name' => $user->user_name,
            ]);
        } else {
            $ms->addMessageTranslated('success', 'DETAILS_UPDATED', [
                'user_name' => $user->user_name,
            ]);
        }

        return $response->withJson([], 200);
    }
}
