<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Admin\Controller\Permission\PermissionsPageAction;

/*
 * Routes for administrative permission management.
 */
class PermissionsRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/permissions', function (RouteCollectorProxy $group) {
            $group->get('', PermissionsPageAction::class)->setName('uri_permissions');
            // $group->get('/p/{id}', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:pageInfo');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/permissions', function (RouteCollectorProxy $group) {
            $group->get('', [PermissionsPageAction::class, 'sprunje']);
            // $group->get('/p/{id}', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:getInfo');
            // $group->get('/p/{id}/users', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:getUsers');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
