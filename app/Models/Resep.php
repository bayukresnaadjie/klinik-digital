<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table    = 'resep';
    protected $fillable = ['nomor_resep','kunjungan_id','dokter_id','status','catatan'];

    public function kunjungan() { return $this->belongsTo(Kunjungan::class); }
    public function dokter()    { return $this->belongsTo(Dokter::class); }
    public function details()   { return $this->hasMany(DetailResep::class); }

    public function getTotalHargaAttribute(): float {
        return (float) $this->details->sum(fn($d) => $d->jumlah * $d->obat->harga);
    }

    protected static function booted(): void {
        static::creating(function ($r) {
            $last = static::whereDate('created_at', today())->count() + 1;
            $r->nomor_resep = 'RES-' . now()->format('Ymd') . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        });
    }
}
