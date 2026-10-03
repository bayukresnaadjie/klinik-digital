<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::create('poli', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama');
            $table->string('lantai')->nullable();
            $table->string('nomor_ruang')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('poli_id')->constrained('poli')->restrictOnDelete();
            $table->string('nama');
            $table->string('spesialisasi');
            $table->string('sip', 50)->nullable()->comment('Surat Izin Praktek');
            $table->decimal('biaya_konsultasi', 12, 2)->default(50000);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu','minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_dokter');
        Schema::dropIfExists('dokter');
        Schema::dropIfExists('poli');
    }
};
