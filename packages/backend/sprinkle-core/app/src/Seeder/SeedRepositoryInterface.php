<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Seeder;

use UserFrosting\Support\ClassRepositoryInterface;

/**
 * Find and returns all database seeds (classes) registered and available.
 *
 * @extends ClassRepositoryInterface<SeedInterface>
 */
interface SeedRepositoryInterface extends ClassRepositoryInterface
{
}
