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
 * Throttles table migration
 * Version 4.0.0.
 */
class ThrottlesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        if (!$this->schema->hasTable('throttles')) {
            $this->schema->create('throttles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type');
                $table->string('ip')->nullable();
                $table->text('request_data')->nullable();
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->index('type');
                $table->index('ip');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->schema->drop('throttles');
    }
}
