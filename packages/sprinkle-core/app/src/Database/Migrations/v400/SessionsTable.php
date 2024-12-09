<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Migrations\v400;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Sessions table migration
 * Version 4.0.0.
 *
 * See https://laravel.com/docs/10.x/migrations#tables
 */
class SessionsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if (!$this->schema->hasTable('sessions')) {
            $this->schema->create('sessions', function (Blueprint $table) {
                $table->string('id')->unique();
                $table->integer('user_id')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->text('payload');
                $table->integer('last_activity');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->drop('sessions');
    }
}
