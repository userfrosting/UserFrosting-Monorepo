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
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Controller\Helpers\TranslateExceptionPart;
use UserFrosting\Sprinkle\Admin\Controller\RoleHelper;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleException;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Display deletion confirmation modal.
 */
class RoleDeleteModal
{
    use TranslateExceptionPart;

    /** @var string Page template */
    protected string $template = 'modals/confirm-delete-role.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected Config $config,
        protected Twig $view,
        protected Translator $translator,
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
        try {
            $payload = $this->handle($request);
        } catch (UserMessageException $e) {
            $title = $this->translateExceptionPart($e->getTitle());
            $description = $this->translateExceptionPart($e->getDescription());
            $this->alert->addMessage('danger', "$title: $description");

            throw $e;
        }

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

        // Get role to delete.
        $role = ($this->roleHelper)($params);

        // Access-controlled page based on the user.
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
