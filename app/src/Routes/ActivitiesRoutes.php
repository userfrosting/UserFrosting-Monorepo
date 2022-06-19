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
use UserFrosting\Sprinkle\Admin\Controller\Activity\ActivitiesPageAction;

/*
 * Routes for administrative activity monitoring.
 */
class ActivitiesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/activities', function (RouteCollectorProxy $group) {
            $group->get('', ActivitiesPageAction::class)
                  ->setName('uri_activities');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/activities', function (RouteCollectorProxy $group) {
            $group->get('', [ActivitiesPageAction::class, 'sprunje']);
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
