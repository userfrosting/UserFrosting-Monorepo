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
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreateModal;
use UserFrosting\Sprinkle\Admin\Controller\User\UserCreationAction;
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

            //     $this->get('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:pageInfo');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/users', function (RouteCollectorProxy $group) {
            $group->get('', [UsersPageAction::class, 'sprunje'])->setName('api_users');

            //     $this->delete('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:delete');

            //     $this->get('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getInfo');

            //     $this->get('/u/{user_name}/activities', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getActivities');

            //     $this->get('/u/{user_name}/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getRoles');

            //     $this->get('/u/{user_name}/permissions', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getPermissions');

            $group->post('', UserCreationAction::class)->setName('api.user.create');

            //     $this->post('/u/{user_name}/password-reset', 'UserFrosting\Sprinkle\Admin\Controller\UserController:createPasswordReset');

        //     $this->put('/u/{user_name}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:updateInfo');

        //     $this->put('/u/{user_name}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\UserController:updateField');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/modals/users', function (RouteCollectorProxy $group) {
            //     $this->get('/confirm-delete', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalConfirmDelete');

            $group->get('/create', UserCreateModal::class)->setName('modal.user.create');

            //     $this->get('/edit', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEdit');

        //     $this->get('/password', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditPassword');

        //     $this->get('/roles', 'UserFrosting\Sprinkle\Admin\Controller\UserController:getModalEditRoles');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
