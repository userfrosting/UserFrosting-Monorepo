<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Slim\App;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Util\RouteParser;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/*
* Slim's routing related services with the UF router.
*/
final class RoutingService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            /**
             * Implement our own RouteParser to allow fallback routes.
             *
             * @see https://www.slimframework.com/docs/v4/objects/routing.html#route-names
             */
            RouteParserInterface::class => function (App $app) {
                $slimRouteCollector = $app->getRouteCollector();

                return new RouteParser($slimRouteCollector);
            },
        ];
    }
}
