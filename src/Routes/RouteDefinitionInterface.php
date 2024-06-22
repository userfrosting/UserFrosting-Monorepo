<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Routes;

use Slim\App;

interface RouteDefinitionInterface
{
    /**
     * Register routes to the Slim App.
     *
     * @param App<\DI\Container> $app
     */
    public function register(App $app): void;
}
