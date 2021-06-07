<?php namespace Codecycler\Passport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodecyclerPassportOneTimePasswords extends Migration
{
    public function up()
    {
        Schema::create('codecycler_passport_one_time_passwords', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('user_class')->nullable();
            $table->text('token')->nullable();
            $table->dateTime('expired_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codecycler_passport_one_time_passwords');
    }
}
