<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDCSpontaneousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_c_spontaneouses', function (Blueprint $table) {
            $table->id();
            $table->string('audio');
            $table->foreignId('data_collection_id')->constrained('data_collections');
            $table->foreignId('spontaneous_id')->constrained('spontaneouses');
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
        Schema::dropIfExists('d_c_spontaneouses');
    }
}
