<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Permission;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Sprunje\PermissionUserSprunje as SprunjePermissionUserSprunje;

/**
 * Returns a list of Users for a specified Permission.
 *
 * Generates a list of users, optionally paginated, sorted and/or filtered.
 * This page requires authentication.
 *
 * Request type: GET
 */
class PermissionUserSprunje
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Translator $translator,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param PermissionInterface $permission
     * @param Request             $request
     * @param Response            $response
     */
    public function __invoke(PermissionInterface $permission, Request $request, Response $response): Response
    {
        // Access-controlled page based on the user.
        $this->validateAccess();

        // GET parameters and pass to Sprunje
        $params = $request->getQueryParams();
        $params['permission_id'] = $permission->id;
        $sprunje = new SprunjePermissionUserSprunje($permission, $this->translator);
        $sprunje->setOptions($params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $sprunje->toResponse($response);
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('uri_permissions')) {
            throw new ForbiddenException();
        }
    }
}
