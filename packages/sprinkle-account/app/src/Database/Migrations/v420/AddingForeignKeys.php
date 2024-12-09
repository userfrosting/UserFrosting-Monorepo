<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\SQLiteConnection;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\ActivitiesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\GroupsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PasswordResetsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PersistencesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\RoleUsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\VerificationsTable;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Foreign Keys migration
 * Adds missing foreign keys from 4.0.0 migrations
 * Version 4.2.0.
 */
class AddingForeignKeys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        GroupsTable::class,
        UsersTable::class,
        VerificationsTable::class,
        ActivitiesTable::class,
        PasswordResetsTable::class,
        PermissionsTable::class, // which itself requires RolesTable and PermissionsRolesTable
        PersistencesTable::class,
        RoleUsersTable::class,
    ];

    /**
     * @var string[][][] List of operation to do
     */
    protected $tables = [
        'activities'       => [
            'user_id' => ['id', 'users'],
        ],
        'password_resets'  => [
            'user_id' => ['id', 'users'],
        ],
        'permission_roles' => [
            'permission_id' => ['id', 'permissions'],
            'role_id'       => ['id', 'roles'],
        ],
        'persistences'     => [
            'user_id' => ['id', 'users'],
        ],
        'role_users'       => [
            'user_id' => ['id', 'users'],
            'role_id' => ['id', 'roles'],
        ],
        'users'            => [
            'group_id'         => ['id', 'groups'],
            'last_activity_id' => ['id', 'activities'],
        ],
        'verifications'    => [
            'user_id' => ['id', 'users'],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName => $keys) {
            if ($this->schema->hasTable($tableName)) {
                $this->schema->table($tableName, function (Blueprint $table) use ($keys) {
                    foreach ($keys as $key => $data) {
                        $table->foreign($key)->references($data[0])->on($data[1]);
                    }
                });
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        /*
         * sqlite can't drop foreign key without dropping the entire table
         * since Laravel 5.7. Skip drop if an sqlite connection is detected
         * @see https://github.com/laravel/framework/issues/25475
         */
        if ($this->schema->getConnection() instanceof SQLiteConnection) {
            return;
        }

        foreach ($this->tables as $tableName => $keys) {
            if ($this->schema->hasTable($tableName)) {
                $this->schema->table($tableName, function (Blueprint $table) use ($keys) {
                    foreach ($keys as $key => $data) {
                        $table->dropForeign([$key]);
                    }
                });
            }
        }
    }
}
