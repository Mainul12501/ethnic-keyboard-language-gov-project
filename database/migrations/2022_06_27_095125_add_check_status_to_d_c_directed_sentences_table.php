<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckStatusToDCDirectedSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->tinyInteger('status')->after('validator_id')->nullable()->comment('0=Pending, 1=Approved, 2=Correction');
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
        Schema::table('d_c_directed_sentences', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('validation_status');
        });
    }
}
