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
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Admin\Controller\Dashboard\CacheApiAction;
use UserFrosting\Sprinkle\Admin\Controller\Dashboard\DashboardApi;
use UserFrosting\Sprinkle\Core\Middlewares\NoCache;

/*
 * Routes for dashboard page.
 */
class DashboardRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->get('/api/dashboard', DashboardApi::class)
            ->setName('dashboard')
            ->add(NoCache::class);

        $app->post('/api/dashboard/clear-cache', CacheApiAction::class)
            ->add(AuthGuard::class)->add(NoCache::class);
    }
}
