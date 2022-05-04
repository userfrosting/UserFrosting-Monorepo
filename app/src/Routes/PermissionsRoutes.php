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
 * Routes for administrative permission management.
 */
class PermissionsRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        // $app->group('/permissions', function () {
        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:pageList')
        //         ->setName('uri_permissions');

        //     $this->get('/p/{id}', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:pageInfo');
        // })->add('authGuard')->add(new NoCache());

        // $app->group('/api/permissions', function () {
        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:getList');

        //     $this->get('/p/{id}', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:getInfo');

        //     $this->get('/p/{id}/users', 'UserFrosting\Sprinkle\Admin\Controller\PermissionController:getUsers');
        // })->add('authGuard')->add(new NoCache());
    }
}
