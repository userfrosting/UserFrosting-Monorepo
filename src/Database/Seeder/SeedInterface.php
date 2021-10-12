<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Seeder;

/**
 * All seeds must implement this interface.
 *
 * @author Louis Charette
 */
interface SeedInterface
{
    /**
     * Run the seed.
     */
    public function run();
}
