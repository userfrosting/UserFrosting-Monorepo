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
use UserFrosting\Sprinkle\Admin\Controller\RoleHelper;

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
        protected RoleHelper $roleHelper,
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
        $payload = $this->handle($request);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return mixed[]
     */
    protected function handle(Request $request): array
    {
        // Get user to edit
        $params = $request->getQueryParams();
        $role = ($this->roleHelper)($params);

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
            'role' => $role,
            'fields' => ['permissions'],
        ])) {
            throw new ForbiddenException();
        }
    }
}
