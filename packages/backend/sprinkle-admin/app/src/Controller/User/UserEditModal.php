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
use UserFrosting\Fortress\Adapter\JqueryValidationArrayAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

/**
 * Renders the modal form for editing an existing user.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
 * This page requires authentication.
 *
 * Request type: GET
 *
 * @throws AccountNotFoundException If user is not found
 * @throws ForbiddenException       If user is not authorized to access page
 */
class UserEditModal
{
    /** @var string Page template */
    protected string $template = 'modals/user.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/user/edit-info.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected GroupInterface $groupModel,
        protected SiteLocaleInterface $siteLocale,
        protected Translator $translator,
        protected Twig $view,
        protected JqueryValidationArrayAdapter $adapter,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param UserInterface $user     The user, injected by the middleware.
     * @param Response      $response
     */
    public function __invoke(UserInterface $user, Response $response): Response
    {
        $payload = $this->handle($user);

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
        // Access-controlled resource - check that currentUser has permission
        // to edit basic fields "name", "email", "locale" for this user
        $fieldNames = ['name', 'email', 'locale'];
        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => $fieldNames,
        ])) {
            throw new ForbiddenException();
        }

        // Get a list of all groups
        $groups = $this->groupModel::all();

        // Get a list of all locales
        $locales = $this->siteLocale->getAvailableIdentifiers();

        // Generate form
        $fields = [
            'hidden'   => ['password'],
            'disabled' => ['user_name'],
        ];

        // Disable group field if currentUser doesn't have permission to modify group
        if (!$this->authenticator->checkAccess('update_user_field', [
            'user'   => $user,
            'fields' => ['group'],
        ])) {
            $fields['disabled'][] = 'group';
        }

        // Hide the locale field if there is only 1 locale available
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        // Load validation rules
        $schema = $this->getSchema();

        return [
            'user'    => $user,
            'groups'  => $groups,
            'locales' => $locales,
            'form'    => [
                'action'      => "api/users/u/{$user->user_name}",
                'method'      => 'PUT',
                'fields'      => $fields,
                'submit_text' => $this->translator->translate('UPDATE'),
            ],
            'page'    => [
                'validators' => $this->adapter->rules($schema),
            ],
        ];
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->schema);

        return $schema;
    }
}
