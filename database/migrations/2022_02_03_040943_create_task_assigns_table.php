<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('language_id')->constrained('languages');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('upazila_id')->constrained('upazilas');
            $table->foreignId('union_id')->constrained('unions');
            $table->foreignId('village_id')->constrained('villages');
            $table->string('total_sample');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_assigns');
    }
}
