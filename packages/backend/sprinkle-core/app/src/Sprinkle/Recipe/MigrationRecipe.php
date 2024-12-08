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
 * Sprinkle Migration definition Interface.
 */
interface MigrationRecipe
{
    /**
     * Return an array of all registered Migrations.
     *
     * @return class-string<\UserFrosting\Sprinkle\Core\Database\MigrationInterface>[]
     */
    public function getMigrations(): array;
}
