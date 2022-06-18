<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Permission;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\Twig;
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
class PermissionPageAction
{
    /** @var string Page template */
    protected string $template = 'pages/permission.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected RouteParserInterface $routeParser,
        protected Twig $view,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param PermissionInterface $permission The permission, injected from the Middleware.
     * @param Request             $request
     * @param Response            $response
     */
    public function __invoke(PermissionInterface $permission, Request $request, Response $response): Response
    {
        $payload = $this->handle($permission, $request);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @param PermissionInterface $permission
     * @param Request             $request
     *
     * @return mixed[]
     */
    protected function handle(PermissionInterface $permission, Request $request): array
    {
        // Access-controlled page
        if (!$this->authenticator->checkAccess('uri_permissions')) {
            throw new ForbiddenException();
        }

        return [
            'permission' => $permission,
        ];
    }
}
