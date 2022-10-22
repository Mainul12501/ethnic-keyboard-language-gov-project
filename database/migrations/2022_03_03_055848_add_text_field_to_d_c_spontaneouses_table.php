<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextFieldToDCSpontaneousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_spontaneouses', function (Blueprint $table) {
            $table->longText('english')->after('audio')->nullable();
            $table->longText('bangla')->after('audio')->nullable();
            $table->longText('transcription')->after('audio')->nullable();
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
            $table->dropColumn('english');
            $table->dropColumn('bangla');
            $table->dropColumn('transcription');
        });
    }
}
