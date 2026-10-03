<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->unique()->constrained('kunjungan')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->restrictOnDelete();
            // Vital sign
            $table->string('tekanan_darah', 20)->nullable();
            $table->decimal('suhu', 4, 1)->nullable();
            $table->integer('nadi')->nullable();
            $table->integer('respirasi')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            // Anamnesa
            $table->text('keluhan')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->text('riwayat_alergi')->nullable();
            // Pemeriksaan
            $table->text('pemeriksaan_fisik')->nullable();
            $table->text('diagnosa')->nullable();
            $table->string('kode_icd', 20)->nullable();
            $table->text('tindakan')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->enum('anjuran', ['rawat_jalan','rawat_inap','rujuk','kontrol'])->default('rawat_jalan');
            $table->date('tanggal_kontrol')->nullable();
            $table->timestamps();
        });

        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama');
            $table->string('kategori')->nullable();
            $table->string('satuan', 20)->default('tablet');
            $table->decimal('harga', 12, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(10);
            $table->text('keterangan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('resep', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_resep', 20)->unique();
            $table->foreignId('kunjungan_id')->constrained('kunjungan')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->restrictOnDelete();
            $table->enum('status', ['menunggu','diproses','selesai'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_resep', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained('resep')->cascadeOnDelete();
            $table->foreignId('obat_id')->constrained('obat')->restrictOnDelete();
            $table->integer('jumlah');
            $table->string('aturan_pakai')->nullable()->comment('Contoh: 3x1 sesudah makan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_billing', 20)->unique();
            $table->foreignId('kunjungan_id')->unique()->constrained('kunjungan')->cascadeOnDelete();
            $table->decimal('biaya_konsultasi', 12, 2)->default(0);
            $table->decimal('biaya_obat', 12, 2)->default(0);
            $table->decimal('biaya_tindakan', 12, 2)->default(0);
            $table->decimal('diskon', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', ['belum_bayar','lunas','ditanggung'])->default('belum_bayar');
            $table->enum('metode_bayar', ['tunai','bpjs','transfer','kartu'])->nullable();
            $table->timestamp('bayar_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('billing');
        Schema::dropIfExists('detail_resep');
        Schema::dropIfExists('resep');
        Schema::dropIfExists('obat');
        Schema::dropIfExists('rekam_medis');
    }
};
