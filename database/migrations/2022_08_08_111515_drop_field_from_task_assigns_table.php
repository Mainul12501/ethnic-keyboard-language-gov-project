<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFieldFromTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
        //    $table->dropForeign(['upazila_id', 'union_id']);
        //     $table->dropColumn(['upazila_id', 'union_id']);
            $table->foreignId('upazila_id')->nullable()->change()/* ->constrained('upazilas')->onDelete('cascade') */;
            $table->foreignId('union_id')->nullable()->change()/* ->constrained('unions')->onDelete('cascade') */;
            $table->integer('total_sample')->nullable()->change();
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
            //
        });
    }
}
