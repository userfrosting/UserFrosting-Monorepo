<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Group;

use Illuminate\Database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Account\Log\UserActivityLogger;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Processes the request to create a new group.
 *
 * Processes the request from the group creation form, checking that:
 * 1. The group name and slug are not already in use;
 * 2. The user has permission to create a new group;
 * 3. The submitted data is valid.
 * This route requires authentication (and should generally be limited to admins or the root user).
 *
 * Request type: POST
 *
 * @see getModalCreateGroup
 */
class GroupCreateAction
{
    // Request schema for client side form validation
    protected string $schema = 'schema://requests/group/create.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected Connection $db,
        protected GroupInterface $groupModel,
        protected Translator $translator,
        protected UserActivityLogger $userActivityLogger,
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
        $this->validateAccess();
        $this->handle($request);
        $payload = json_encode([], JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request.
     *
     * @param Request $request
     */
    protected function handle(Request $request): void
    {
        // Get POST parameters.
        $params = (array) $request->getParsedBody();

        // Load the request schema
        $schema = $this->getSchema();

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate request data
        $this->validateData($schema, $data);
        $this->validateGroupName($data['name']);
        $this->validateGroupSlug($data['slug']);

        // Get current user. Won't be null, as AuthGuard prevent it
        /** @var UserInterface */
        $currentUser = $this->authenticator->user();

        // All checks passed!  log events/activities and create group
        // Begin transaction - DB will be rolled back if an exception occurs
        $this->db->transaction(function () use ($data, $currentUser) {

            // Create the group
            $group = new $this->groupModel($data);
            $group->save();

            // Create activity record
            $this->userActivityLogger->info("User {$currentUser->user_name} created group {$group->name}.", [
                'type'    => 'group_create',
                'user_id' => $currentUser->id,
            ]);

            $this->alert->addMessageTranslated('success', 'GROUP.CREATION_SUCCESSFUL', $data);
        });
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('create_group')) {
            throw new ForbiddenException();
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
     * Validate group name is not already in use.
     *
     * @param string $name
     */
    protected function validateGroupName(string $name): void
    {
        $group = $this->groupModel->where('name', $name)->first();
        if ($group !== null) {
            $e = new GroupException();
            $message = new UserMessage('GROUP.NAME_IN_USE', ['name' => $name]);
            $e->setDescription($message);

            throw $e;
        }
    }

    /**
     * Validate group name is not already in use.
     *
     * @param string $slug
     */
    protected function validateGroupSlug(string $slug): void
    {
        $group = $this->groupModel->where('slug', $slug)->first();
        if ($group !== null) {
            $e = new GroupException();
            $message = new UserMessage('SLUG_IN_USE', ['slug' => $slug]);
            $e->setDescription($message);

            throw $e;
        }
    }
}
