<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database;

use Illuminate\Database\Schema\Builder;

/**
 * Abstract Migration class.
 */
abstract class Migration implements MigrationInterface
{
    /**
     * List of dependencies for this migration.
     * Should return an array of class required to be run before this migration.
     *
     * @var string[]
     */
    public static $dependencies = [];

    /**
     * Create a new migration instance.
     *
     * @param Builder $schema
     */
    public function __construct(protected Builder $schema)
    {
    }
}
