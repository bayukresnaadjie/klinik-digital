<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table    = 'pasien';
    protected $fillable = ['nomor_rm','nik','nama','jenis_kelamin','tanggal_lahir','golongan_darah','alamat','telepon','email','pekerjaan','nama_keluarga','telepon_keluarga','jenis_bayar','no_bpjs','alergi'];
    protected $casts    = ['tanggal_lahir' => 'date'];

    public function kunjungan() { return $this->hasMany(Kunjungan::class); }

    public function getUmurAttribute(): int {
        return $this->tanggal_lahir->age;
    }

    public function getJenisKelaminLabelAttribute(): string {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    protected static function booted(): void {
        static::creating(function ($p) {
            $today = now()->format('Ymd');
            $last  = static::whereDate('created_at', today())->count() + 1;
            $p->nomor_rm = 'RM-' . $today . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        });
    }
}
