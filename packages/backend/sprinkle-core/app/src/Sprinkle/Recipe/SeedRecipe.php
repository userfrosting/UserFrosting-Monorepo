<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Sprinkle\Recipe;

/**
 * Sprinkle seeds definition Interface.
 */
interface SeedRecipe
{
    /**
     * Return an array of all registered seeds.
     *
     * @return class-string<\UserFrosting\Sprinkle\Core\Seeder\SeedInterface>[]
     */
    public function getSeeds(): array;
}
