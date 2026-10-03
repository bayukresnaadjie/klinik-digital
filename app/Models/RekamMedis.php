<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table    = 'rekam_medis';
    protected $fillable = ['kunjungan_id','dokter_id','tekanan_darah','suhu','nadi','respirasi','berat_badan','tinggi_badan','keluhan','riwayat_penyakit','riwayat_alergi','pemeriksaan_fisik','diagnosa','kode_icd','tindakan','catatan_dokter','anjuran','tanggal_kontrol'];
    protected $casts    = ['tanggal_kontrol' => 'date'];

    public function kunjungan() { return $this->belongsTo(Kunjungan::class); }
    public function dokter()    { return $this->belongsTo(Dokter::class); }

    public function getImtAttribute(): ?float {
        if (!$this->berat_badan || !$this->tinggi_badan) return null;
        $tinggiM = $this->tinggi_badan / 100;
        return round($this->berat_badan / ($tinggiM * $tinggiM), 1);
    }
}
