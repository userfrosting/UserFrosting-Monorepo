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

/**
 * Migration Interfaces class.
 */
interface MigrationInterface
{
    /**
     * Method to apply changes to the database.
     */
    public function up(): void;

    /**
     * Method to revert changes applied by the `up` method.
     */
    public function down(): void;
}
