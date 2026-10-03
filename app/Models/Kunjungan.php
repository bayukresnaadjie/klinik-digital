<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table    = 'kunjungan';
    protected $fillable = ['nomor_kunjungan','pasien_id','poli_id','dokter_id','user_id','tanggal','nomor_antrian','status','jenis_kunjungan','keluhan_utama'];
    protected $casts    = ['tanggal' => 'date'];

    public function pasien()     { return $this->belongsTo(Pasien::class); }
    public function poli()       { return $this->belongsTo(Poli::class); }
    public function dokter()     { return $this->belongsTo(Dokter::class); }
    public function user()       { return $this->belongsTo(User::class); }
    public function rekamMedis() { return $this->hasOne(RekamMedis::class); }
    public function resep()      { return $this->hasOne(Resep::class); }
    public function billing()    { return $this->hasOne(Billing::class); }

    public function getStatusBadgeAttribute(): array {
        return match($this->status) {
            'menunggu'  => ['label' => 'Menunggu',  'class' => 'bg-yellow-100 text-yellow-700'],
            'dipanggil' => ['label' => 'Dipanggil', 'class' => 'bg-blue-100 text-blue-700'],
            'diperiksa' => ['label' => 'Diperiksa', 'class' => 'bg-purple-100 text-purple-700'],
            'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-700'],
            'batal'     => ['label' => 'Batal',     'class' => 'bg-red-100 text-red-600'],
            default     => ['label' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-600'],
        };
    }

    protected static function booted(): void {
        static::creating(function ($k) {
            $today  = now()->format('Ymd');
            $last   = static::whereDate('tanggal', today())->count() + 1;
            $k->nomor_kunjungan = 'KNJ-' . $today . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);

            // Nomor antrian per poli per hari
            $k->nomor_antrian = static::whereDate('tanggal', today())
                ->where('poli_id', $k->poli_id)->count() + 1;
        });
    }
}
