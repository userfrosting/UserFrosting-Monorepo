<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Bakery;

use Symfony\Component\Console\Application;
use UserFrosting\Cupcake;
use UserFrosting\Event\BakeryInitiatedEvent;
use UserFrosting\Event\EventDispatcher;

/**
 * Base class for UserFrosting Bakery CLI tools.
 */
final class Bakery extends Cupcake
{
    /**
     * @var Application The Slim application instance.
     */
    protected Application $app;

    /**
     * Return the underlying Slim App instance, if available.
     *
     * @return Application
     */
    public function getApp(): Application
    {
        return $this->app;
    }

    /**
     * Create Symfony Console App.
     */
    protected function initiateApp(): void
    {
        /** @var Application */
        $app = $this->ci->get(Application::class);

        // Dispatch BakeryInitiatedEvent
        /** @var EventDispatcher */
        $eventDispatcher = $this->ci->get(EventDispatcher::class);
        $eventDispatcher->dispatch(new BakeryInitiatedEvent());

        $this->app = $app;
    }

    /**
     * Run application.
     *
     * @codeCoverageIgnore
     */
    public function run(): void
    {
        $this->app->run();
    }
}
