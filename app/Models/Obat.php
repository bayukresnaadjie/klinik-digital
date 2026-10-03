<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table    = 'obat';
    protected $fillable = ['kode','nama','kategori','satuan','harga','stok','stok_minimum','keterangan','aktif'];
    protected $casts    = ['harga' => 'decimal:2', 'aktif' => 'boolean'];

    public function detailResep() { return $this->hasMany(DetailResep::class); }

    public function isStokMinimum(): bool { return $this->stok <= $this->stok_minimum; }
    public function isStokHabis(): bool   { return $this->stok <= 0; }

    public function getHargaFormatAttribute(): string {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    protected static function booted(): void {
        static::creating(function ($o) {
            if (!$o->kode) {
                $last    = static::count() + 1;
                $o->kode = 'OBT-' . str_pad($last, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
