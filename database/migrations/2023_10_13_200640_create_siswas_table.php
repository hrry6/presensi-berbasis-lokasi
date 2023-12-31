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
            $table->string('nama_siswa', 60);
            $table->string('nomer_hp', 20);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->enum('status_siswa', ['aktif', 'tinggal_kelas', 'lulus']);
            $table->enum('status_jabatan', ['sekretaris', 'ketua_kelas', 'wakil_kelas', 'bendahara', 'siswa'])->nullable(true);
            $table->integer('angkatan');
            $table->text('foto_siswa');
            $table->string('pembuat', 60);

            // Index
            $table->index('id_akun');
            $table->index('id_siswa');
            $table->index('nama_siswa');


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
