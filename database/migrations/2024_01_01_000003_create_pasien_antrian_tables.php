<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rm', 20)->unique()->comment('Nomor Rekam Medis');
            $table->string('nik', 16)->nullable()->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('golongan_darah', 5)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nama_keluarga')->nullable()->comment('Nama keluarga/wali');
            $table->string('telepon_keluarga', 20)->nullable();
            $table->enum('jenis_bayar', ['umum', 'bpjs', 'asuransi'])->default('umum');
            $table->string('no_bpjs', 20)->nullable();
            $table->text('alergi')->nullable();
            $table->timestamps();
        });

        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kunjungan', 20)->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->restrictOnDelete();
            $table->foreignId('poli_id')->constrained('poli')->restrictOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->comment('Petugas yang mendaftarkan');
            $table->date('tanggal');
            $table->integer('nomor_antrian');
            $table->enum('status', ['menunggu','dipanggil','diperiksa','selesai','batal'])->default('menunggu');
            $table->enum('jenis_kunjungan', ['baru','lama','kontrol'])->default('baru');
            $table->text('keluhan_utama')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kunjungan');
        Schema::dropIfExists('pasien');
    }
};
