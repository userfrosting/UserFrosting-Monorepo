<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\ServicesProvider;

use DI\Bridge\Slim\Bridge;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App as SlimApp;
use Slim\Factory\ServerRequestCreatorFactory;
use Symfony\Component\Console\Application as ConsoleApp;
use UserFrosting\Bakery\SprinkleCommandsRepository;
use UserFrosting\Event\EventDispatcher;
use UserFrosting\Event\SprinkleListenerProvider;
use UserFrosting\Routes\SprinkleRoutesRepository;
use UserFrosting\Sprinkle\SprinkleMiddlewareRepository;

/**
 * Register framework base services.
 */
final class FrameworkService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            // Slim App
            SlimApp::class => function (
                ContainerInterface $ci,
                SprinkleMiddlewareRepository $middlewareRepository,
                SprinkleRoutesRepository $routesRepository,
            ) {
                $app = Bridge::create($ci);

                // Register Routes & Middlewares
                $this->registerRoutes($app, $routesRepository);
                $this->registerMiddlewares($app, $middlewareRepository);

                return $app;
            },

            // Symfony Console Application
            ConsoleApp::class => function (SprinkleCommandsRepository $commandsRepository) {
                $version = (string) \Composer\InstalledVersions::getPrettyVersion('userfrosting/framework');
                $app = new ConsoleApp('UserFrosting Bakery', $version);

                // Register commands
                $this->loadCommands($app, $commandsRepository);

                return $app;
            },

            // Request
            ServerRequestInterface::class => function () {
                $serverRequestCreator = ServerRequestCreatorFactory::create();
                $request = $serverRequestCreator->createServerRequestFromGlobals();

                return $request;
            },

            // Events
            EventDispatcherInterface::class  => \DI\autowire(EventDispatcher::class),
            ListenerProviderInterface::class => \DI\autowire(SprinkleListenerProvider::class),
        ];
    }

    /**
     * Load and register all routes.
     *
     * @param SlimApp<\DI\Container>   $app
     * @param SprinkleRoutesRepository $routesRepository
     */
    protected function registerRoutes(SlimApp $app, SprinkleRoutesRepository $routesRepository): void
    {
        foreach ($routesRepository as $routeClass) {
            $routeClass->register($app);
        }
    }

    /**
     * Load and register all middlewares.
     * Last registered middleware is executed first.
     *
     * @param SlimApp<\DI\Container>       $app
     * @param SprinkleMiddlewareRepository $middlewareRepository
     */
    protected function registerMiddlewares(SlimApp $app, SprinkleMiddlewareRepository $middlewareRepository): void
    {
        // Routing middleware can be executed last.
        // It should be executed after any error handling middleware.
        $app->addRoutingMiddleware();

        // Add the registered Middlewares
        foreach ($middlewareRepository as $middleware) {
            $app->addMiddleware($middleware);
        }

        // Body parsing middleware should be executed first, so other middleware
        // can access the parsed body.
        $app->addBodyParsingMiddleware();
    }

    /**
     * Load and register all defined bakery commands.
     *
     * @param ConsoleApp                 $app
     * @param SprinkleCommandsRepository $commandsRepository
     */
    protected function loadCommands(ConsoleApp $app, SprinkleCommandsRepository $commandsRepository): void
    {
        foreach ($commandsRepository as $command) {
            $app->add($command);
        }
    }
}
