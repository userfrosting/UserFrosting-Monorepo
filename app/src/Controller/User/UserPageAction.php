<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/**
 * Renders a page displaying a user's information, in read-only mode.
 *
 * This checks that the currently logged-in user has permission to view the requested user's info.
 * It checks each field individually, showing only those that you have permission to view.
 * This will also try to show buttons for activating, disabling/enabling, deleting, and editing the user.
 *
 * This page requires authentication.
 * Request type: GET
 */
class UserPageAction
{
    /** @var string Page template */
    protected string $template = 'pages/user.html.twig';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected SiteLocaleInterface $siteLocale,
        protected RouteParserInterface $routeParser,
        protected Twig $view,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param UserInterface $user     The user to display, injected by the middleware.
     * @param Response      $response
     */
    public function __invoke(UserInterface $user, Response $response): Response
    {
        $payload = $this->handle($user);

        // TODO : Turn into JSON API endpoint
        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @param UserInterface $user
     *
     * @return mixed[]
     */
    protected function handle(UserInterface $user): array
    {
        // Access-controlled page
        if (!$this->authenticator->checkAccess('uri_user', [
            'user' => $user,
        ])) {
            throw new ForbiddenException();
        }

        // Determine fields that currentUser is authorized to view
        $fieldNames = ['user_name', 'name', 'email', 'locale', 'group', 'roles'];

        // Fields to hide based on user's access.
        $fields = [
            'hidden' => [],
        ];

        // Determine which fields should be hidden
        foreach ($fieldNames as $field) {
            if (!$this->authenticator->checkAccess('view_user_field', [
                'user'     => $user,
                'property' => $field,
            ])) {
                $fields['hidden'][] = $field;
            }
        }

        // Hide the locale field if there is only 1 locale available
        $locales = $this->siteLocale->getAvailableIdentifiers();
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        // Determine buttons to display
        $editButtons = [
            'hidden' => [],
        ];

        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['name', 'email', 'locale'],
        ])) {
            $editButtons['hidden'][] = 'edit';
        }

        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['flag_enabled'],
        ])) {
            $editButtons['hidden'][] = 'enable';
        }

        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['flag_verified'],
        ])) {
            $editButtons['hidden'][] = 'activate';
        }

        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['password'],
        ])) {
            $editButtons['hidden'][] = 'password';
        }

        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['roles'],
        ])) {
            $editButtons['hidden'][] = 'roles';
        }

        if (!$this->authenticator->checkAccess('delete_user', [
            'user' => $user,
        ])) {
            $editButtons['hidden'][] = 'delete';
        }

        // Determine widgets to display
        $widgets = [
            'hidden' => [],
        ];

        if (!$this->authenticator->checkAccess('view_user_field', [
            'user'     => $user,
            'property' => 'permissions',
        ])) {
            $widgets['hidden'][] = 'permissions';
        }

        if (!$this->authenticator->checkAccess('view_user_field', [
            'user'     => $user,
            'property' => 'activities',
        ])) {
            $widgets['hidden'][] = 'activities';
        }

        return [
            'user'            => $user,
            'locales'         => $locales,
            'fields'          => $fields,
            'tools'           => $editButtons,
            'widgets'         => $widgets,
            'delete_redirect' => $this->routeParser->urlFor('uri_users'),
        ];
    }
}
