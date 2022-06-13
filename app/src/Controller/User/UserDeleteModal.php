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
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\AccountException;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Controller\UserHelper;
use UserFrosting\Sprinkle\Admin\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Renders the modal form to confirm user deletion.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
 * This page requires authentication.
 * Request type: GET
 *
 * @throws ValidationException
 * @throws AccountNotFoundException If user is not found
 * @throws ForbiddenException       If user is not authorized to access page
 * @throws AccountException         If trying to delete the master account
 */
class UserDeleteModal
{
    /** @var string Page template */
    protected string $template = 'modals/confirm-delete-user.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Config $config,
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
     * @return mixed[]
     */
    protected function handle(Request $request): array
    {
        // GET parameters
        $params = $request->getQueryParams();

        // Get user to delete.
        $user = $this->userHelper->getUser($params);

        // Access-controlled page based on the user.
        $this->validateAccess($user);

        // Check that we are not deleting the master account
        // Need to use loose comparison for now, because some DBs return `id` as a string
        if ($user->id === $this->config->getInt('reserved_user_ids.master')) {
            $e = new AccountException();
            $e->setTitle('DELETE_MASTER');

            throw $e;
        }

        return [
            'user' => $user,
            'form' => [
                'action' => "api/users/u/{$user->user_name}",
            ],
        ];
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(UserInterface $user): void
    {
        if (!$this->authenticator->checkAccess('delete_user', ['user' => $user])) {
            throw new ForbiddenException();
        }
    }
}
