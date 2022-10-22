<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidatorTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validator_task_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('language_id')->constrained('languages');
            $table->foreignId('sub_language_id')->nullable()->constrained('sub_languages');
            $table->foreignId('district_id')->nullable()->constrained('districts');
            $table->foreignId('upazila_id')->nullable()->constrained('upazilas');
            $table->foreignId('union_id')->nullable()->constrained('unions');
            $table->string('address')->nullable();
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
        Schema::dropIfExists('validator_task_assigns');
    }
}
