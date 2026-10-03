<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $table    = 'billing';
    protected $fillable = ['nomor_billing','kunjungan_id','biaya_konsultasi','biaya_obat','biaya_tindakan','diskon','total','status','metode_bayar','bayar_at'];
    protected $casts    = ['bayar_at' => 'datetime', 'total' => 'decimal:2'];

    public function kunjungan() { return $this->belongsTo(Kunjungan::class); }

    public function getTotalFormatAttribute(): string {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): array {
        return match($this->status) {
            'belum_bayar' => ['label' => 'Belum Bayar', 'class' => 'bg-red-100 text-red-600'],
            'lunas'       => ['label' => 'Lunas',       'class' => 'bg-green-100 text-green-600'],
            'ditanggung'  => ['label' => 'Ditanggung',  'class' => 'bg-blue-100 text-blue-600'],
            default       => ['label' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-600'],
        };
    }

    protected static function booted(): void {
        static::creating(function ($b) {
            $last = static::whereDate('created_at', today())->count() + 1;
            $b->nomor_billing = 'BIL-' . now()->format('Ymd') . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
        });
    }
}
