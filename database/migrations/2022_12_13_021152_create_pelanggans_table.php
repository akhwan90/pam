<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('id', 16);
            $table->string('nama', 100)->nullable();
            $table->string('alamat_kecamatan', 100)->nullable();
            $table->string('alamat_desa', 100)->nullable();
            $table->string('alamat_dusun', 100)->nullable();
            $table->tinyInteger('alamat_rt')->nullable();
            $table->tinyInteger('alamat_rw')->nullable();
            $table->string('nomor_hp', 30)->nullable();
            $table->timestamps();

            $table->unique('id');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelanggans');
    }
}
