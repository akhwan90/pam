<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatMeterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catat_meter', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('periode_tahun');
            $table->tinyInteger('periode_bulan');
            $table->string('pelanggan_id', 16);
            $table->decimal('posisi_meter', 16, 2)->nullable()->default(0);
            $table->decimal('penggunaan', 16, 2)->nullable()->default(0)->comment('Selisih penggunaan periode lalu dengan sekarang');
            $table->decimal('penggunaan_tarif', 20, 2)->nullable()->default(0);
            $table->tinyInteger('status_bayar')->default(0)->comment('0: draft, 1: dibayar');
            $table->dateTime('tgl_bayar')->nullable();
            $table->tinyInteger('metode_bayar')->default(1)->comment('1: tunai,  2: bank transfer, 3: ewallet');
            $table->unsignedBigInteger('pegawai_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catat_meter');
    }
}
