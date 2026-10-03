<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table    = 'poli';
    protected $fillable = ['kode','nama','lantai','nomor_ruang','aktif'];
    protected $casts    = ['aktif' => 'boolean'];

    public function dokter()    { return $this->hasMany(Dokter::class); }
    public function kunjungan() { return $this->hasMany(Kunjungan::class); }

    public function getAntrianHariIniAttribute(): int {
        return $this->kunjungan()->whereDate('tanggal', today())->count();
    }
}
