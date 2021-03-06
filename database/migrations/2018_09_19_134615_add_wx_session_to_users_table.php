<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWxSessionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('weapp_openid')->nullable()->unique()->after('email_verified');
            $table->string('weixin_session_key')->nullable()->after('weapp_openid');
	    $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('weapp_openid');
            $table->dropColumn('weixin_session_key');
	    $table->string('password')->nullable(false)->change();
        });
    }
}
