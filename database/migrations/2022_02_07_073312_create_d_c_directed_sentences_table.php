<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDCDirectedSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_c_directed_sentences', function (Blueprint $table) {
            $table->id();
            $table->string('audio');
            $table->foreignId('d_c_directed_id')->constrained('d_c_directeds');
            $table->foreignId('directed_id')->constrained('directeds');
            $table->dateTime('approved_date');
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('d_c_directed_sentences');
    }
}
