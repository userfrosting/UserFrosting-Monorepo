<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\TestSprinkle;

use Slim\App;
use UserFrosting\Routes\RouteDefinitionInterface;

class TestRoutesDefinitions implements RouteDefinitionInterface
{
    /**
     * @param App<\DI\Container> $app
     */
    public function register(App $app): void
    {
        $app->get('/foo', [TestController::class, 'index']);
    }
}
