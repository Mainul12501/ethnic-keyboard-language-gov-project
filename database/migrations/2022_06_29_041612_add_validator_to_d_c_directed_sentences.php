<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidatorToDCDirectedSentences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->bigInteger('validator_id')->unsigned()->after('directed_id')->nullable();
            $table->foreign('validator_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropForeign(['validator_id']);
            $table->dropColumn('validator_id');
        });
    }
}
