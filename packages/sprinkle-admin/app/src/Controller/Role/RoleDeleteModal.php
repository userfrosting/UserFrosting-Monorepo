<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Role;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Display deletion confirmation modal.
 */
class RoleDeleteModal
{
    /** @var string Page template */
    protected string $template = 'modals/confirm-delete-role.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Config $config,
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
        // Access-controlled page based on the role.
        $this->validateAccess($role);

        // TODO : Default role should be defined in the DB instead of config.
        $defaultRoleSlugs = $this->config->get('site.registration.user_defaults.roles');
        $defaultRoleSlugs = array_map('trim', array_keys($defaultRoleSlugs, true, true)); // @phpstan-ignore-line False positive on array_map

        // Need to use loose comparison for now, because some DBs return `id` as a string
        if (in_array($role->slug, $defaultRoleSlugs, true)) {
            $e = new RoleException();
            $message = new UserMessage('ROLE.DELETE_DEFAULT', $role->toArray());
            $e->setDescription($message);

            throw $e;
        }

        // Check if there are any users in this group
        // @phpstan-ignore-next-line False negative from Laravel
        if ($role->users()->count() > 0) {
            $e = new RoleException();
            $message = new UserMessage('ROLE.HAS_USERS', $role->toArray());
            $e->setDescription($message);

            throw $e;
        }

        return [
            'role'  => $role,
            'form'  => [
                'action' => "api/roles/r/{$role->slug}",
            ],
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
        if (!$this->authenticator->checkAccess('delete_role', ['role' => $role])) {
            throw new ForbiddenException();
        }
    }
}
