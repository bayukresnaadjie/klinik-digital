<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    protected $table    = 'detail_resep';
    protected $fillable = ['resep_id','obat_id','jumlah','aturan_pakai','catatan'];

    public function resep() { return $this->belongsTo(Resep::class); }
    public function obat()  { return $this->belongsTo(Obat::class); }

    public function getSubtotalAttribute(): float {
        return (float) ($this->jumlah * $this->obat->harga);
    }
}
