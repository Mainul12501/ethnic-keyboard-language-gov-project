<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyDistrict extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_collections', function (Blueprint $table) {
            $table->unsignedInteger('district_id')->after('language_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_collections', function (Blueprint $table) {
               // 1. Drop foreign key constraints
               $table->dropForeign(['district_id']);
               // 2. Drop the column
               $table->dropColumn('district_id');
        });
    }
}
