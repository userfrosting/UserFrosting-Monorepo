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
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultGroups;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Groups table migration
 * "Group" now replaces the notion of "primary group" in earlier versions of UF.  A user can belong to exactly one group.
 * Version 4.0.0.
 */
class GroupsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if (!$this->schema->hasTable('groups')) {
            $this->schema->create('groups', function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug');
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('icon', 100)->nullable(false)->default('fas fa-user')->comment('The icon representing users in this group.');
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->unique('slug');
                $table->index('slug');
            });

            // Add default groups via seed
            // (new DefaultGroups())->run();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->drop('groups');
    }
}
