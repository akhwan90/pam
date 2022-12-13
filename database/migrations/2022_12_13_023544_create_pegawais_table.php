<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('nomor_hp', 30)->nullable();
            $table->timestamps();

            $table->unique('nip');

            $table->index(['user_id']);
            $table->foreign('user_id')
            ->references('id')
                ->on('users')
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
        Schema::dropIfExists('pegawais');
    }
}
