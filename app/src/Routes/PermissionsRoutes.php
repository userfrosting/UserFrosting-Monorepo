<?php

declare(strict_types=1);

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
use UserFrosting\Sprinkle\Admin\Controller\Permission\PermissionPageAction;
use UserFrosting\Sprinkle\Admin\Controller\Permission\PermissionsPageAction;
use UserFrosting\Sprinkle\Admin\Controller\Permission\PermissionUserSprunje;
use UserFrosting\Sprinkle\Admin\Middlewares\PermissionInjector;
use UserFrosting\Sprinkle\Core\Middlewares\NoCache;

/*
 * Routes for administrative permission management.
 */
class PermissionsRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/permissions', function (RouteCollectorProxy $group) {
            $group->get('', PermissionsPageAction::class)
                  ->setName('uri_permissions');
            $group->get('/p/{id}', PermissionPageAction::class)
                  ->add(PermissionInjector::class);
        })->add(AuthGuard::class)->add(NoCache::class);

        $app->group('/api/permissions', function (RouteCollectorProxy $group) {
            $group->get('', [PermissionsPageAction::class, 'sprunje']);
            $group->get('/p/{id}/users', PermissionUserSprunje::class)
                  ->add(PermissionInjector::class);
        })->add(AuthGuard::class)->add(NoCache::class);
    }
}
