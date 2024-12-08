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
 * Sprinkle Middleware definition Interface.
 */
interface MiddlewareRecipe
{
    /**
     * Returns a list of all Middlewares classes.
     *
     * @return class-string<\Psr\Http\Server\MiddlewareInterface>[]
     */
    public function getMiddlewares(): array;
}
