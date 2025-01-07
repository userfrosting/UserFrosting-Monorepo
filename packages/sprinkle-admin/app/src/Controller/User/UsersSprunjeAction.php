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
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\Admin\Sprunje\UserSprunje;

/**
 * Renders the user listing page.
 *
 * This page renders a table of users, with dropdown menus for admin actions for each user.
 * Actions typically include: edit user details, activate user, enable/disable user, delete user.
 *
 * This page requires authentication.
 * Request type: GET
 */
class UsersSprunjeAction
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected UserSprunje $sprunje,
    ) {
    }

    /**
     * Sprunje / api handler tied to this page.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->validateAccess();

        // GET parameters and pass to Sprunje
        $params = $request->getQueryParams();
        $this->sprunje->setOptions($params);

        // Be careful how you consume this data - it has not been escaped and contains untrusted user-supplied content.
        // For example, if you plan to insert it into an HTML DOM, you must escape it on the client side (or use client-side templating).
        return $this->sprunje->toResponse($response);
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('uri_users')) {
            throw new ForbiddenException();
        }
    }
}
