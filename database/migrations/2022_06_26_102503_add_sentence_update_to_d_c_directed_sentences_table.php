<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentenceUpdateToDCDirectedSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->text('bangla')->after('audio_blob')->nullable();
            $table->text('english')->after('bangla')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->dropColumn('bangla');
            $table->dropColumn('english');
        });
    }
}
