<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Billing;
use App\Models\Pasien;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function kunjungan(Request $request)
    {
        $dari   = $request->get('dari',   now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', now()->endOfMonth()->format('Y-m-d'));

        $kunjungan = Kunjungan::with(['pasien', 'poli', 'dokter', 'billing'])
            ->whereDate('tanggal', '>=', $dari)
            ->whereDate('tanggal', '<=', $sampai)
            ->orderByDesc('tanggal')->get();

        $totalKunjungan = $kunjungan->count();
        $perStatus = $kunjungan->groupBy('status')->map->count();
        $perPoli   = $kunjungan->groupBy('poli.nama')->map->count()->sortDesc();
        $perDokter = $kunjungan->groupBy('dokter.nama')->map->count()->sortDesc();

        return view('laporan.kunjungan', compact('kunjungan', 'totalKunjungan', 'perStatus', 'perPoli', 'perDokter', 'dari', 'sampai'));
    }

    public function pendapatan(Request $request)
    {
        $dari   = $request->get('dari',   now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', now()->endOfMonth()->format('Y-m-d'));

        $billing = Billing::with(['kunjungan.pasien', 'kunjungan.dokter'])
            ->where('status', 'lunas')
            ->whereDate('created_at', '>=', $dari)
            ->whereDate('created_at', '<=', $sampai)
            ->orderByDesc('created_at')->get();

        $totalPendapatan    = $billing->sum('total');
        $totalKonsultasi    = $billing->sum('biaya_konsultasi');
        $totalObat          = $billing->sum('biaya_obat');
        $perMetode          = $billing->groupBy('metode_bayar')->map->sum('total');

        $harianData = $billing->groupBy(fn($b) => $b->created_at->format('Y-m-d'))
            ->map->sum('total')->sortKeys();

        return view('laporan.pendapatan', compact(
            'billing', 'totalPendapatan', 'totalKonsultasi', 'totalObat',
            'perMetode', 'harianData', 'dari', 'sampai'
        ));
    }
}
