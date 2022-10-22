<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDCSpontaneousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_c_spontaneouses', function (Blueprint $table) {
            $table->tinyInteger('status')->after('approved_by')->default(0)->comment('0=Pending, 1=Approved, 2=Correction');
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
            $table->dropColumn('status');
        });
    }
}
