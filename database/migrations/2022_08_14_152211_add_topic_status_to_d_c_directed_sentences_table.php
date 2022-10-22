<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTopicStatusToDCDirectedSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->tinyInteger('topic_status')->after('status')->nullable()->comment('1=partial_collection,2=voice_collection,3=validated,4=approved,5=not_validate,6=reject');
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
            $table->dropColumn('topic_status');
        });
    }
}
