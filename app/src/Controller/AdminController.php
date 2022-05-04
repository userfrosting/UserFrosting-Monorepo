<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Support\Exception\ForbiddenException;

/**
 * AdminController Class.
 *
 * Controller class for /dashboard URL.  Handles admin-related activities
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class AdminController extends SimpleController
{
    /**
     * Clear the site cache.
     *
     * This route requires authentication.
     * Request type: POST
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    public function clearCache(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'clear_cache')) {
            throw new ForbiddenException();
        }

        // Flush cache
        $this->ci->cache->flush();

        /** @var \UserFrosting\Sprinkle\Core\Alert\AlertStream $ms */
        $ms = $this->ci->alerts;

        $ms->addMessageTranslated('success', 'CACHE.CLEARED');

        return $response->withJson([], 200);
    }

    /**
     * Renders the modal form to confirm cache deletion.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the modal, which can be embedded in other pages.
     * This page requires authentication.
     * Request type: GET
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     */
    public function getModalConfirmClearCache(Request $request, Response $response, $args)
    {
        /** @var \UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager */
        $authorizer = $this->ci->authorizer;

        /** @var \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface $currentUser */
        $currentUser = $this->ci->currentUser;

        // Access-controlled page
        if (!$authorizer->checkAccess($currentUser, 'clear_cache')) {
            throw new ForbiddenException();
        }

        return $this->ci->view->render($response, 'modals/confirm-clear-cache.html.twig', [
            'form' => [
                'action' => 'api/dashboard/clear-cache',
            ],
        ]);
    }
}
