<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Listeners;

use Slim\App;
use UserFrosting\Config\Config;
use UserFrosting\Event\AppInitiatedEvent;
use UserFrosting\Event\BakeryInitiatedEvent;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Event Listener for AppInitiatedEvent & BakeryInitiatedEvent events.
 * Set route caching on the Slim App.
 *
 * @see https://www.slimframework.com/docs/v4/objects/routing.html#route-expressions-caching
 */
class SetRouteCaching
{
    /**
     * Inject dependencies.
     *
     * @param Config                   $config
     * @param ResourceLocatorInterface $locator
     * @param App<\DI\Container>       $app
     */
    public function __construct(
        protected Config $config,
        protected ResourceLocatorInterface $locator,
        protected App $app,
    ) {
    }

    /**
     * @param AppInitiatedEvent|BakeryInitiatedEvent $event
     */
    public function __invoke(AppInitiatedEvent|BakeryInitiatedEvent $event): void
    {
        if ($this->config->getBool('cache.route', false)) {
            $filename = $this->config->getString('cache.routerFile');
            $routerCacheFile = $this->locator->findResource("cache://$filename", true, true);
            // Make sure the file is found
            if (is_string($routerCacheFile)) {
                $this->app->getRouteCollector()->setCacheFile($routerCacheFile);
            }
        }
    }
}
