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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Controller\UserHelper;

/**
 * Renders the modal form for editing a user's roles.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
 * This page requires authentication.
 *
 * Request type: GET
 */
class UserEditRolesModal
{
    /** @var string Page template */
    protected string $template = 'modals/user-manage-roles.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Twig $view,
        protected UserHelper $userHelper,
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
        $user = $this->userHelper->getUser($params);

        // Access-controlled resource - check that currentUser has permission
        $this->validateAccess($user);

        return [
            'user' => $user,
        ];
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(UserInterface $user): void
    {
        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['roles'],
        ])) {
            throw new ForbiddenException();
        }
    }
}
