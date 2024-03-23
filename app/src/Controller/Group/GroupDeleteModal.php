<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Group;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Get deletion confirmation modal.
 */
class GroupDeleteModal
{
    /** @var string Page template */
    protected string $template = 'modals/confirm-delete-group.html.twig';

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
     * @param GroupInterface $group
     * @param Response       $response
     */
    public function __invoke(GroupInterface $group, Response $response): Response
    {
        $payload = $this->handle($group);

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @param GroupInterface $group
     *
     * @return mixed[]
     */
    protected function handle(GroupInterface $group): array
    {
        // Access-controlled page based on the group.
        $this->validateAccess($group);

        // Check if there are any users in this group
        // @phpstan-ignore-next-line False negative from Laravel
        if ($group->users()->count() > 0) {
            $e = new GroupException();
            $message = new UserMessage('GROUP.NOT_EMPTY', $group->toArray());
            $e->setDescription($message);

            throw $e;
        }

        return [
            'group' => $group,
            'form'  => [
                'action' => "api/groups/g/{$group->slug}",
            ],
        ];
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(GroupInterface $group): void
    {
        if (!$this->authenticator->checkAccess('delete_group', ['group' => $group])) {
            throw new ForbiddenException();
        }
    }
}
