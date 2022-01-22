<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v500;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\SQLiteConnection;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Groups table migration
 * Changes `group_id` column properties to allow user to be created without a group.
 * Version 5.0.0.
 */
class UpdateUsersTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        UsersTable::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        // N.B.: SQLite doesn't support multiple calls to dropColumn / renameColumn in a single modification.
        if ($this->schema->hasTable('users')) {
            $this->schema->table('users', function (Blueprint $table) {
                $table->dropColumn('theme');
            });
            $this->schema->table('users', function (Blueprint $table) {
                
                /*
                * sqlite can't drop foreign key without dropping the entire table
                * since Laravel 5.7. Skip drop if an sqlite connection is detected
                * @see https://github.com/laravel/framework/issues/25475
                */
                if (!$this->schema->getConnection() instanceof SQLiteConnection) {
                    $table->dropForeign('user_id');
                }

                $table->dropColumn('last_activity_id');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->string('theme', 100)->nullable()->comment('The user theme.');
            $table->integer('last_activity_id')->unsigned()->nullable()->comment('The id of the last activity performed by this user.');
        });
    }
}
