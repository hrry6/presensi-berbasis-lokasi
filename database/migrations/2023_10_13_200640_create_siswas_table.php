<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->integer('id_siswa', true);
            $table->integer('id_akun');
            $table->integer('id_kelas');
            $table->integer('nis');
            $table->integer('nomer_hp');

            // Foreign Key

            $table->foreign('id_akun')->on('akun')
                ->references('id_akun')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('id_kelas')->on('kelas')
                ->references('id_kelas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
