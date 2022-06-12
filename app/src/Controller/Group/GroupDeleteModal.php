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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Controller\GroupHelper;
use UserFrosting\Sprinkle\Admin\Controller\Helpers\TranslateExceptionPart;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupException;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Get deletion confirmation modal.
 */
class GroupDeleteModal
{
    use TranslateExceptionPart;

    /** @var string Page template */
    protected string $template = 'modals/confirm-delete-group.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected AlertStream $alert,
        protected Authenticator $authenticator,
        protected Config $config,
        protected Translator $translator,
        protected Twig $view,
        protected GroupHelper $groupHelper,
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

        // Get user to delete.
        $group = $this->groupHelper->getGroup($params);

        // Access-controlled page based on the user.
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
