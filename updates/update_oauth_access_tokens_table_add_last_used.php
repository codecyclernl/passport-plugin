<?php
namespace Codecycler\Passport\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateOauthAccessTokensTableAddLastUsed extends Migration
{
    public function up()
    {
        Schema::table('oauth_access_tokens', function ($table) {
            $table->timestamp('last_used')->nullable();
        });
    }

    public function down()
    {
        Schema::table('oauth_access_tokens', function ($table) {
            $table->dropColumn('last_used');
        });
    }
}
