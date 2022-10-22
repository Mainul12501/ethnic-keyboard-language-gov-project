<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_collections', function (Blueprint $table) {
            $table->id();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->tinyInteger('type_id')->default(null)->comment('1=Directed, 2=Spontaneous')->nullable();
            $table->foreignId('language_id')->constrained('languages');
            $table->foreignId('collector_id')->constrained('users');
            $table->foreignId('speaker_id')->constrained('speakers');
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
        Schema::dropIfExists('data_collections');
    }
}
