<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationStatusToDCSpontaneousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_spontaneouses', function (Blueprint $table) {
            $table->tinyInteger('validation_status')->after('status')->default(0)->comment('0=Not Agree, 1=Partial Agree, 2=Agree');

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
            $table->dropColumn('validation_status');
        });
    }
}
