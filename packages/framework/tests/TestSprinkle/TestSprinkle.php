<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\TestSprinkle;

use UserFrosting\Sprinkle\BakeryRecipe;
use UserFrosting\Sprinkle\MiddlewareRecipe;
use UserFrosting\Sprinkle\SprinkleRecipe;

class TestSprinkle implements SprinkleRecipe, MiddlewareRecipe, BakeryRecipe
{
    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'Test Sprinkle';
    }

    /**
     * {@inheritDoc}
     */
    public function getPath(): string
    {
        return __DIR__ . '/data';
    }

    /**
     * {@inheritDoc}
     */
    public function getBakeryCommands(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getSprinkles(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return [
            TestRoutesDefinitions::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return [
            TestServicesProviders::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddlewares(): array
    {
        return [
            TestMiddleware::class,
        ];
    }
}
