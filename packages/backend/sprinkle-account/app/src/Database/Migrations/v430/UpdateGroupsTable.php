<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v430;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\GroupsTable;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Groups table migration
 * Changes the `icon` column property of `default` to NULL to align with new Font Awesome 5 tag convention.
 * Version 4.3.0.
 */
class UpdateGroupsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        GroupsTable::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if ($this->schema->hasTable('groups')) {
            $this->schema->table('groups', function (Blueprint $table) {
                $table->string('icon', 100)->nullable()->change();
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->table('groups', function (Blueprint $table) {
            $table->string('icon', 100)->default('fa fa-user')->nullable(false)->change();
        });
    }
}
