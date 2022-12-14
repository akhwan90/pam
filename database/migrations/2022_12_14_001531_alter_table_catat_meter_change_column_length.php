<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCatatMeterChangeColumnLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catat_meter', function (Blueprint $table) {
            $table->smallInteger('periode_tahun')->change();
            $table->smallInteger('status_bayar')->nullable()->change();
            $table->smallInteger('metode_bayar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
