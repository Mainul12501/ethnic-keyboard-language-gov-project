<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersChangeUserType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn(['user_type']);
        // });
        Schema::table('users', function (Blueprint $table) {

            $table->tinyInteger('user_type')->default(null)->comment('1=Manager, 2=Supervisor, 3=Guide, 4=Data Collector , 5=Linguist, 6=Validator')->nullable()->after('email');
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

        });
    }
}
