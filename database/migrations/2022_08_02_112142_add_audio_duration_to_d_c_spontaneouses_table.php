<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAudioDurationToDCSpontaneousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_spontaneouses', function (Blueprint $table) {
            $table->string('audio_duration')->after('audio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_c_spontaneouses', function (Blueprint $table) {
            $table->dropColumn('audio_duration');
        });
    }
}
