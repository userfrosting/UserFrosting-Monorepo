<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\Account\Model\Migrations\v400;

use UserFrosting\System\Bakery\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Persistences table migration
 * Many-to-many mapping between roles and users.
 * Version 4.0.0
 *
 * See https://laravel.com/docs/5.4/migrations#tables
 * @extends Migration
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class PersistencesTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('persistences')) {
            $this->schema->create('persistences', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('token', 40);
                $table->string('persistent_token', 40);
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                //$table->foreign('user_id')->references('id')->on('users');
                $table->index('user_id');
                $table->index('token');
                $table->index('persistent_token');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('persistences');
    }
}