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
use UserFrosting\Config\Config;
use UserFrosting\Fortress\Adapter\JqueryValidationArrayAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

/**
 * Renders the modal form for creating a new user.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
 * If the currently logged-in user has permission to modify user group membership, then the group toggle will be displayed.
 * Otherwise, the user will be added to the default group and receive the default roles automatically.
 *
 * This page requires authentication.
 * Request type: GET
 *
 * @throws ForbiddenException If user is not authorized to access page
 */
class UserCreateModal
{
    /** @var string Page template */
    protected string $template = 'modals/user.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/user/create.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Config $config,
        protected GroupInterface $groupModel,
        protected SiteLocaleInterface $siteLocale,
        protected Translator $translator,
        protected Twig $view,
        protected UserInterface $userModel,
        protected JqueryValidationArrayAdapter $adapter,
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
        $this->validateAccess();
        $payload = $this->handle();

        return $this->view->render($response, $this->template, $payload);
    }

    /**
     * Handle the request and return the payload.
     *
     * @return mixed[]
     */
    protected function handle(): array
    {
        // Load the request schema
        $schema = $this->getSchema();

        // Determine form fields to hide/disable
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];

        // Get a list of all locales
        // Hide the locale field if there is only 1 locale available
        $locales = $this->siteLocale->getAvailableOptions();
        if (count($locales) <= 1) {
            $fields['hidden'][] = 'locale';
        }

        // Determine if currentUser has permission to modify the group.  If so, show the 'group' dropdown.
        // Otherwise, set to the currentUser's group and disable the dropdown.
        if ($this->authenticator->checkAccess('create_user_field', [
            'fields' => ['group'],
        ])) {
            // Get a list of all groups
            $groups = $this->groupModel::all();
        } else {
            // Get the current user's group
            $groups = $this->authenticator->user()?->group()->get();
            $fields['disabled'][] = 'group';
        }

        // Create a dummy user to pre-populate fields
        $user = new $this->userModel([
            'locale'   => $this->config->get('site.registration.user_defaults.locale'),
        ]);

        return [
            'user'    => $user,
            'groups'  => $groups,
            'locales' => $locales,
            'form'    => [
                'action'      => 'api/users',
                'method'      => 'POST',
                'fields'      => $fields,
                'submit_text' => $this->translator->translate('CREATE'),
            ],
            'page'    => [
                'validators' => $this->adapter->rules($schema),
            ],
        ];
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('create_user')) {
            throw new ForbiddenException();
        }
    }

    /**
     * Load the request schema.
     *
     * @return RequestSchemaInterface
     */
    protected function getSchema(): RequestSchemaInterface
    {
        $schema = new RequestSchema($this->schema);
        $schema->set('password.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('password.validators.length.max', $this->config->get('site.password.length.max'));
        $schema->set('passwordc.validators.length.min', $this->config->get('site.password.length.min'));
        $schema->set('passwordc.validators.length.max', $this->config->get('site.password.length.max'));

        return $schema;
    }
}
