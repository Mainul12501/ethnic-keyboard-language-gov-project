<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->tinyInteger('gender')->comment('0=Male, 1=Female');
            $table->string('email')->nullable();
            $table->string('image');
            $table->string('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('education')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('district_id')->nullable()->constrained('districts');
            $table->foreignId('upazila_id')->nullable()->constrained('upazilas');
            $table->foreignId('union_id')->nullable()->constrained('unions');
            $table->foreignId('village_id')->nullable()->constrained('villages');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('speakers');
    }
}
