<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubLanguageIdFromTaskAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
            $table->bigInteger('sub_language_id')->unsigned()->after('language_id')->nullable();
            $table->foreign('sub_language_id')->references('id')->on('sub_languages')->onDelete('cascade');//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_assigns', function (Blueprint $table) {
            $table->dropForeign(['sub_language_id']);
            $table->dropColumn('sub_language_id');
        });
    }
}
