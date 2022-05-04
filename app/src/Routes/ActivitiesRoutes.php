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
 * Routes for administrative activity monitoring.
 */
class ActivitiesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        // $app->group('/activities', function () {
        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\ActivityController:pageList')
        //         ->setName('uri_activities');
        // })->add('authGuard')->add(new NoCache());

        // $app->group('/api/activities', function () {
        //     $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\ActivityController:getList');
        // })->add('authGuard')->add(new NoCache());
    }
}
