<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationToAudioTrimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_trims', function (Blueprint $table) {
            $table->bigInteger('validator_id')->unsigned()->after('transcription')->nullable();
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('validation_status')->after('status')->nullable()->comment('0=Not Agree,1=Agree');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audio_trims', function (Blueprint $table) {
            $table->dropForeign(['validator_id']);
            $table->dropColumn('validator_id');
            $table->dropColumn('validation_status');
        });
    }
}
