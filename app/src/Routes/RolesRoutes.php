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
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleCreateAction;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleCreateModal;
use UserFrosting\Sprinkle\Admin\Controller\Role\RolesPageAction;

/*
 * Routes for administrative role management.
 */
class RolesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/roles', function (RouteCollectorProxy $group) {
            $group->get('', RolesPageAction::class)->setName('uri_roles');
            // $group->get('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:pageInfo');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/roles', function (RouteCollectorProxy $group) {
            // $group->delete('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:delete');
            $group->get('', [RolesPageAction::class, 'sprunje']);
            // $group->get('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getInfo');
            // $group->get('/r/{slug}/permissions', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getPermissions');
            // $group->get('/r/{slug}/users', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getUsers');
            $group->post('', RoleCreateAction::class);
            // $group->put('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:updateInfo');
            // $group->put('/r/{slug}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:updateField');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/modals/roles', function (RouteCollectorProxy $group) {
            // $group->get('/confirm-delete', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalConfirmDelete');
            $group->get('/create', RoleCreateModal::class)->setName('modal.roles.create');
            // $group->get('/edit', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalEdit');
            // $group->get('/permissions', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalEditPermissions');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
