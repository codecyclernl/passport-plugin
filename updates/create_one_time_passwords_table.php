<?php namespace Codecycler\Passport\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateOneTimePasswordsTable Migration
 */
class CreateOneTimePasswordsTable extends Migration
{
    public function up()
    {
        Schema::create('codecycler_passport_one_time_passwords', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('codecycler_passport_one_time_passwords');
    }
}
