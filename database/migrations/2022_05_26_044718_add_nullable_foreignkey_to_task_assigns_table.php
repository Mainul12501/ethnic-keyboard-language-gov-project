<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableForeignkeyToTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_assigns', function (Blueprint $table) {

            // $table->Integer('upazila_id')->unsigned()->nullable();
            // $table->foreign('upazila_id')->references('id')->on('upazilas')->onDelete('cascade');
            // $table->Integer('union_id')->unsigned()->nullable();
            // $table->foreign('union_id')->references('id')->on('unions')->onDelete('cascade');
            $table->date('total_sample')->nullable()->change();
        });
        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
            // $table->dropForeign(['upazila_id']);
            // $table->dropForeign(['union_id']);
            $table->dropColumn('total_sample');


        });
    }
}
