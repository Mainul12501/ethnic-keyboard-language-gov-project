<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAudioTrimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audio_trims', function (Blueprint $table) {
            $table->dateTime('approved_date')->after('transcription')->nullable();
            $table->integer('approved_by')->after('transcription')->nullable();
            $table->text('comment')->after('transcription')->nullable();
            $table->tinyInteger('status')->after('transcription')->default(0)->comment('0=Trimming, 1=Pending, 2=Revert, 3=Approved');
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
            $table->dropColumn('approved_date');
            $table->dropColumn('approved_by');
            $table->dropColumn('comment');
            $table->dropColumn('status');
        });
    }
}
