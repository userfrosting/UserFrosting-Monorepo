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
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleDeleteAction;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleDeleteModal;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleEditAction;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleEditModal;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleEditPermissionsModal;
use UserFrosting\Sprinkle\Admin\Controller\Role\RolePageAction;
use UserFrosting\Sprinkle\Admin\Controller\Role\RolePermissionsSprunje;
use UserFrosting\Sprinkle\Admin\Controller\Role\RolesPageAction;
use UserFrosting\Sprinkle\Admin\Controller\Role\RoleUsersSprunje;
use UserFrosting\Sprinkle\Admin\Middlewares\RoleInjector;
use UserFrosting\Sprinkle\Admin\Middlewares\UserMessageExceptionHandler;

/*
 * Routes for administrative role management.
 */
class RolesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/roles', function (RouteCollectorProxy $group) {
            $group->get('', RolesPageAction::class)
                  ->setName('uri_roles');
            $group->get('/r/{slug}', RolePageAction::class)
                  ->add(RoleInjector::class);
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/roles', function (RouteCollectorProxy $group) {
            $group->delete('/r/{slug}', RoleDeleteAction::class)
                  ->add(UserMessageExceptionHandler::class)
                  ->add(RoleInjector::class);
            $group->get('', [RolesPageAction::class, 'sprunje']);
            $group->get('/r/{slug}/permissions', RolePermissionsSprunje::class)
                  ->add(RoleInjector::class);
            $group->get('/r/{slug}/users', RoleUsersSprunje::class)
                  ->add(RoleInjector::class);
            $group->post('', RoleCreateAction::class)
                  ->add(UserMessageExceptionHandler::class);
            $group->put('/r/{slug}', RoleEditAction::class)
                  ->add(UserMessageExceptionHandler::class)
                  ->add(RoleInjector::class);
            // $group->put('/r/{slug}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:updateField');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/modals/roles', function (RouteCollectorProxy $group) {
            $group->get('/confirm-delete', RoleDeleteModal::class)
                  ->add(UserMessageExceptionHandler::class)
                  ->add(RoleInjector::class)
                  ->setName('modal.roles.delete');
            $group->get('/create', RoleCreateModal::class)
                  ->setName('modal.roles.create');
            $group->get('/edit', RoleEditModal::class)
                  ->add(RoleInjector::class)
                  ->setName('modal.roles.edit');
            $group->get('/permissions', RoleEditPermissionsModal::class)
                  ->add(RoleInjector::class)
                  ->setName('modal.roles.permissions');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
