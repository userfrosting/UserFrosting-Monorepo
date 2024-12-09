<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v400;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultPermissions;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Permissions table migration
 * Permissions now replace the 'authorize_group' and 'authorize_user' tables.
 * Also, they now map many-to-many to roles.
 * Version 4.0.0.
 */
class PermissionsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public static $dependencies = [
        RolesTable::class,
        PermissionRolesTable::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if (!$this->schema->hasTable('permissions')) {
            $this->schema->create('permissions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug')->comment('A code that references a specific action or URI that an assignee of this permission has access to.');
                $table->string('name');
                $table->text('conditions')->comment('The conditions under which members of this group have access to this hook.');
                $table->text('description')->nullable();
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }

        // Skip this if table is not empty
        // if (Permission::count() === 0) {
        // Add default permission via seed
        // (new DefaultPermissions())->run();
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->drop('permissions');
    }
}
