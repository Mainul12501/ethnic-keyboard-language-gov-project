<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalTimeToTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
            // $table->string('total_time')->nullable();
            $table->dropColumn('total_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
            $table->dropColumn('total_time');
        });
    }
}
