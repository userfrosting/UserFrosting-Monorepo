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
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreateAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreateModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserDeleteAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserDeleteModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserEditAction;
use UserFrosting\Sprinkle\Admin\Controller\User\UserEditModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UsersPageAction;

/*
 * Routes for administrative user management.
 */
class UsersRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/users', function (RouteCollectorProxy $group) {
            $group->get('', UsersPageAction::class)->setName('uri_users');
            //     $group->get('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:pageInfo');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/users', function (RouteCollectorProxy $group) {
            $group->get('', [UsersPageAction::class, 'sprunje'])->setName('api_users');
            $group->delete('/u/{user_name}', UserDeleteAction::class)->setName('api.users.delete');
            //     $group->get('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getInfo');
            //     $group->get('/u/{user_name}/activities', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getActivities');
            //     $group->get('/u/{user_name}/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getRoles');
            //     $group->get('/u/{user_name}/permissions', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getPermissions');
            $group->post('', UserCreateAction::class)->setName('api.users.create');
            //     $group->post('/u/{user_name}/password-reset', 'UserFrosting\Sprinkle\Admin\Controller\UserController:createPasswordReset');
            $group->put('/u/{user_name}', UserEditAction::class)->setName('api.users.edit');
            //     $group->put('/u/{user_name}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:updateField');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/modals/users', function (RouteCollectorProxy $group) {
            $group->get('/confirm-delete', UserDeleteModal::class)->setName('modal.users.delete');
            $group->get('/create', UserCreateModal::class)->setName('modal.user.create');
            $group->get('/edit', UserEditModal::class)->setName('modal.user.edit');
            //     $group->get('/password', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditPassword');
            //     $group->get('/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditRoles');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
