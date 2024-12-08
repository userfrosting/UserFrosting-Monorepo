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
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v420\AddingForeignKeys;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Groups table migration
 * Changes `group_id` column properties to allow user to be created without a group.
 * Version 4.3.0.
 */
class UpdateUsersTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        GroupsTable::class,
        UsersTable::class,
        AddingForeignKeys::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if ($this->schema->hasTable('users')) {
            $this->schema->table('users', function (Blueprint $table) {
                $table->unsignedInteger('group_id')->default(null)->comment('The id of the user group.')->nullable()->change();
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->unsignedInteger('group_id')->default(1)->comment('The id of the user group.')->change();
        });
    }
}
