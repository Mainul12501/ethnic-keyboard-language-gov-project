<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStatusValidationDirected extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_directed_sentences', function(Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('validation_status');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_c_directed_sentences', function(Blueprint $table) {
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('validation_status')->unsigned();
      });
    }
}
