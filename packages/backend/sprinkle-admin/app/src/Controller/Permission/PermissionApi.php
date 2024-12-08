<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Permission;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;

/**
 * Renders a page displaying a permission's information, in read-only mode.
 *
 * This checks that the currently logged-in user has permission to view permissions.
 * Note that permissions cannot be modified through the interface.  This is because
 * permissions are tightly coupled to the code and should only be modified by developers.
 * This page requires authentication.
 *
 * Request type: GET
 */
class PermissionApi
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param PermissionInterface $permission The permission, injected from the Middleware.
     * @param Response            $response
     */
    public function __invoke(PermissionInterface $permission, Response $response): Response
    {
        $this->validateAccess($permission);
        $permission = $this->handle($permission);
        $payload = json_encode($permission, JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Validate access to the api.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(PermissionInterface $permission): void
    {
        if (!$this->authenticator->checkAccess('uri_permissions')) {
            throw new ForbiddenException();
        }
    }

    /**
     * Add or remove fields from the permission object before returning it.
     * TIP : When extending this class, you can use this method to add your own fields.
     *
     * @param PermissionInterface $permission
     *
     * @return PermissionInterface
     */
    protected function handle(PermissionInterface $permission): PermissionInterface
    {
        return $permission;
    }
}
