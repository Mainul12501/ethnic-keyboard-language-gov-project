<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_collections', function (Blueprint $table) {
            $table->unsignedInteger('task_assign_id')->after('type_id')->references('id')->on('task_assigns');
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
             $table->dropForeign(['task_assign_id']);
             // 2. Drop the column
             $table->dropColumn('task_assign_id');
        });
    }
}
