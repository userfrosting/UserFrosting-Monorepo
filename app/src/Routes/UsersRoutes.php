<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Admin\Controller\User\UserActivitySprunje;
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreateAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreateModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserDeleteAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserDeleteModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserEditAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserEditModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserEditRolesModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserPageAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserPasswordAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserPasswordModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserPermissionSprunje;
use UserFrosting\Sprinkle\Admin\Controller\User\UserRoleSprunje;
use UserFrosting\Sprinkle\Admin\Controller\User\UsersPageAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserUpdateFieldAction;
use UserFrosting\Sprinkle\Admin\Middlewares\UserInjector;
use UserFrosting\Sprinkle\Core\Middlewares\NoCache;

/*
 * Routes for administrative user management.
 */
class UsersRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/users', function (RouteCollectorProxy $group) {
            $group->get('', UsersPageAction::class)
                  ->setName('uri_users');
            $group->get('/u/{user_name}', UserPageAction::class)
                  ->add(UserInjector::class)
                  ->setName('page.user');
        })->add(AuthGuard::class)->add(NoCache::class);

        $app->group('/api/users', function (RouteCollectorProxy $group) {
            $group->get('', [UsersPageAction::class, 'sprunje'])
                  ->setName('api_users');
            $group->delete('/u/{user_name}', UserDeleteAction::class)
                  ->add(UserInjector::class)
                  ->setName('api.users.delete');
            $group->get('/u/{user_name}/activities', UserActivitySprunje::class)
                  ->add(UserInjector::class);
            $group->get('/u/{user_name}/roles', UserRoleSprunje::class)
                  ->add(UserInjector::class);
            $group->get('/u/{user_name}/permissions', UserPermissionSprunje::class)
                  ->add(UserInjector::class);
            $group->post('', UserCreateAction::class)
                  ->setName('api.users.create');
            $group->post('/u/{user_name}/password-reset', UserPasswordAction::class)
                  ->add(UserInjector::class)
                  ->setName('api.users.password-reset');
            $group->put('/u/{user_name}', UserEditAction::class)
                  ->add(UserInjector::class)
                  ->setName('api.users.edit');
            $group->put('/u/{user_name}/{field}', UserUpdateFieldAction::class)
                  ->add(UserInjector::class)
                  ->setName('api.users.update-field');
        })->add(AuthGuard::class)->add(NoCache::class);

        $app->group('/modals/users', function (RouteCollectorProxy $group) {
            $group->get('/confirm-delete', UserDeleteModal::class)
                  ->add(UserInjector::class)
                  ->setName('modal.users.delete');
            $group->get('/create', UserCreateModal::class)
                  ->setName('modal.users.create');
            $group->get('/edit', UserEditModal::class)
                  ->add(UserInjector::class)
                  ->setName('modal.users.edit');
            $group->get('/password', UserPasswordModal::class)
                  ->add(UserInjector::class)
                  ->setName('modal.users.password');
            $group->get('/roles', UserEditRolesModal::class)
                  ->add(UserInjector::class)
                  ->setName('modal.users.roles');
        })->add(AuthGuard::class)->add(NoCache::class);
    }
}
