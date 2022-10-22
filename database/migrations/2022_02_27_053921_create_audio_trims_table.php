<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioTrimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_trims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('d_c_directed_sentences_id')->nullable()->constrained('d_c_directed_sentences');
            $table->foreignId('d_c_spontaneouses_id')->nullable()->constrained('d_c_spontaneouses');
            $table->string('audio');
            $table->string('bangla');
            $table->string('english')->nullable();
            $table->string('transcription')->nullable();
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
        Schema::dropIfExists('audio_trims');
    }
}
