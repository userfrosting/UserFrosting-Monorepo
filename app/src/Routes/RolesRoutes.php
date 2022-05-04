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
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;

/*
 * Routes for administrative role management.
 */
class RolesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        // $app->group('/roles', function () {
        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:pageList')
        //         ->setName('uri_roles');

        //     $this->get('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:pageInfo');
        // })->add('authGuard')->add(new NoCache());

        // $app->group('/api/roles', function () {
        //     $this->delete('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:delete');

        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getList');

        //     $this->get('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getInfo');

        //     $this->get('/r/{slug}/permissions', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getPermissions');

        //     $this->get('/r/{slug}/users', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getUsers');

        //     $this->post('', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:create');

        //     $this->put('/r/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:updateInfo');

        //     $this->put('/r/{slug}/{field}', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:updateField');
        // })->add('authGuard')->add(new NoCache());

        // $app->group('/modals/roles', function () {
        //     $this->get('/confirm-delete', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalConfirmDelete');

        //     $this->get('/create', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalCreate');

        //     $this->get('/edit', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalEdit');

        //     $this->get('/permissions', 'UserFrosting\Sprinkle\Admin\Controller\RoleController:getModalEditPermissions');
        // })->add('authGuard')->add(new NoCache());
    }
}
