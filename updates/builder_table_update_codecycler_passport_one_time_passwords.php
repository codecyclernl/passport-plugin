<?php namespace Codecycler\Passport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodecyclerPassportOneTimePasswords extends Migration
{
    public function up()
    {
        Schema::table('codecycler_passport_one_time_passwords', function($table)
        {
            $table->string('ip_lock')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('codecycler_passport_one_time_passwords', function($table)
        {
            $table->dropColumn('ip_lock');
        });
    }
}
