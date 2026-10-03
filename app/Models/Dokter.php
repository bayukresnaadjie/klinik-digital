<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table    = 'dokter';
    protected $fillable = ['user_id','poli_id','nama','spesialisasi','sip','biaya_konsultasi','aktif'];
    protected $casts    = ['aktif' => 'boolean', 'biaya_konsultasi' => 'decimal:2'];

    public function user()       { return $this->belongsTo(User::class); }
    public function poli()       { return $this->belongsTo(Poli::class); }
    public function jadwal()     { return $this->hasMany(JadwalDokter::class); }
    public function kunjungan()  { return $this->hasMany(Kunjungan::class); }
    public function rekamMedis() { return $this->hasMany(RekamMedis::class); }

    public function getBiayaFormatAttribute(): string {
        return 'Rp ' . number_format($this->biaya_konsultasi, 0, ',', '.');
    }
}
