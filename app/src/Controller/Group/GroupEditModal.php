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
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

/**
 * Renders the modal form for editing an existing group.
 *
 * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
 * This page requires authentication.
 *
 * Request type: GET
 */
class GroupEditModal
{
    /** @var string Page template */
    protected string $template = 'modals/group.html.twig';

    // Request schema for client side form validation
    protected string $schema = 'schema://requests/group/edit-info.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected GroupInterface $groupModel,
        protected SiteLocaleInterface $siteLocale,
        protected Translator $translator,
        protected Twig $view,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param GroupInterface $group    The group to edit, injected by the middleware.
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
        // Access-controlled resource - check that currentUser has permission
        // to edit basic fields "name", "slug", "icon", "description" for this group
        $fieldNames = ['name', 'slug', 'icon', 'description'];
        if (!$this->authenticator->checkAccess('update_group_field', [
            'group'  => $group,
            'fields' => $fieldNames,
        ])) {
            throw new ForbiddenException();
        }

        // Generate form
        $fields = [
            'hidden'   => [],
            'disabled' => [],
        ];

        // Load validation rules
        $schema = $this->getSchema();
        $validator = new JqueryValidationAdapter($schema, $this->translator);

        return [
            'group'   => $group,
            'form'    => [
                'action'      => "api/groups/g/{$group->slug}",
                'method'      => 'PUT',
                'fields'      => $fields,
                'submit_text' => $this->translator->translate('UPDATE'),
            ],
            'page'    => [
                'validators' => $validator->rules(),
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
