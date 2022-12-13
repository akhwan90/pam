<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPelanggansAddGolTarif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->unsignedBigInteger('golongan_tarif_id')->nullable();

            $table->index(['golongan_tarif_id']);
            $table->foreign('golongan_tarif_id')
            ->references('id')
            ->on('golongan_tarifs')
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
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropForeign(['golongan_tarif_id']);
            $table->dropIndex(['golongan_tarif_id']);
            $table->dropColumn('golongan_tarif_id');
        });
    }
}
