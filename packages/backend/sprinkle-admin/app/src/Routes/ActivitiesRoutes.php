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
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Admin\Controller\Activity\ActivitiesSprunje;
use UserFrosting\Sprinkle\Core\Middlewares\NoCache;

/*
 * Routes for administrative activity monitoring.
 */
class ActivitiesRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->get('/api/activities', ActivitiesSprunje::class)
            ->add(NoCache::class);
    }
}
