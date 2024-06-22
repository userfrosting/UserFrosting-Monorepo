<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting;

use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use UserFrosting\Event\AppInitiatedEvent;
use UserFrosting\Event\EventDispatcher;

/**
 * UserFrosting Main Class.
 */
final class UserFrosting extends Cupcake
{
    /**
     * @var App<\DI\Container> The Slim application instance.
     */
    protected App $app;

    /**
     * Return the underlying Slim App instance, if available.
     *
     * @return App<\DI\Container>
     */
    public function getApp(): App
    {
        return $this->app;
    }

    /**
     * Instantiate the Slim application.
     */
    protected function initiateApp(): void
    {
        /** @var App<\DI\Container> */
        $app = $this->ci->get(App::class);

        // Dispatch AppInitiatedEvent
        /** @var EventDispatcher */
        $eventDispatcher = $this->ci->get(EventDispatcher::class);
        $eventDispatcher->dispatch(new AppInitiatedEvent());

        $this->app = $app;
    }

    /**
     * Run application.
     *
     * @codeCoverageIgnore
     */
    public function run(): void
    {
        /** @var ServerRequestInterface $request */
        $request = $this->ci->get(ServerRequestInterface::class);

        $this->app->run($request);
    }
}
