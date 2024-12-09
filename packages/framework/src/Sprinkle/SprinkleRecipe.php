<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle;

/**
 * Sprinkle definition Interface.
 */
interface SprinkleRecipe
{
    /**
     * Return the Sprinkle name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return the Sprinkle dir path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Return dependent sprinkles.
     *
     * @return class-string<SprinkleRecipe>[]
     */
    public function getSprinkles(): array;

    /**
     * Returns a list of routes definition in PHP files.
     *
     * @return class-string<\UserFrosting\Routes\RouteDefinitionInterface>[]
     */
    public function getRoutes(): array;

    /**
     * Returns a list of all PHP-DI services/container definitions class.
     *
     * @return class-string<\UserFrosting\ServicesProvider\ServicesProviderInterface>[]
     */
    public function getServices(): array;
}
