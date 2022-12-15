<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBayarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_bayar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catat_meter_id');
            $table->decimal('jumlah_bayar', 20, 2)->nullable()->default(0);
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->timestamps();

            $table->index(['catat_meter_id']);
            $table->foreign('catat_meter_id')
            ->references('id')
            ->on('catat_meter')
            ->constrained()
            ->onUpdate('restrict')
            ->onDelete('restrict');

            $table->index(['admin_id']);
            $table->foreign('admin_id')
            ->references('id')
            ->on('users')
            ->constrained()
            ->onUpdate('restrict')
            ->onDelete('restrict');

            $table->index(['pegawai_id']);
            $table->foreign('pegawai_id')
            ->references('id')
            ->on('pegawais')
            ->constrained()
            ->onUpdate('restrict')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_bayar');
    }
}
