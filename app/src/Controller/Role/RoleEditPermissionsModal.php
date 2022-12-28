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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;

/**
 * Renders the modal form for editing a role's permissions.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
 * This page requires authentication.
 *
 * Request type: GET
 */
class RoleEditPermissionsModal
{
    /** @var string Page template */
    protected string $template = 'modals/role-manage-permissions.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Twig $view,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param RoleInterface $role
     * @param Response      $response
     */
    public function __invoke(RoleInterface $role, Response $response): Response
    {
        $payload = $this->handle($role);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @param RoleInterface $role
     *
     * @return mixed[]
     */
    protected function handle(RoleInterface $role): array
    {
        // Access-controlled resource - check that currentUser has permission
        $this->validateAccess($role);

        return [
            'role' => $role,
        ];
    }

    /**
     * Validate access to the page.
     *
     * @param RoleInterface $role
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(RoleInterface $role): void
    {
        if (!$this->authenticator->checkAccess('update_role_field', [
            'role'   => $role,
            'fields' => ['permissions'],
        ])) {
            throw new ForbiddenException();
        }
    }
}
