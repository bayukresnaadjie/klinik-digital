<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\Billing;
use App\Models\Obat;
use App\Models\Resep;
use App\Models\Dokter;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik hari ini
        $totalKunjunganHariIni = Kunjungan::whereDate('tanggal', today())->count();
        $menunggu   = Kunjungan::whereDate('tanggal', today())->where('status', 'menunggu')->count();
        $diperiksa  = Kunjungan::whereDate('tanggal', today())->whereIn('status', ['dipanggil','diperiksa'])->count();
        $selesai    = Kunjungan::whereDate('tanggal', today())->where('status', 'selesai')->count();

        // Pendapatan hari ini
        $pendapatanHariIni = Billing::whereDate('created_at', today())->where('status', 'lunas')->sum('total');

        // Total pasien terdaftar
        $totalPasien = Pasien::count();

        // Resep menunggu diproses
        $resepMenunggu = Resep::where('status', 'menunggu')->count();

        // Obat stok menipis
        $obatMenipis = Obat::where('aktif', true)->whereColumn('stok', '<=', 'stok_minimum')->count();

        // Antrian aktif hari ini
        $antrianAktif = Kunjungan::with(['pasien', 'poli', 'dokter'])
            ->whereDate('tanggal', today())
            ->whereIn('status', ['menunggu', 'dipanggil', 'diperiksa'])
            ->orderBy('nomor_antrian')
            ->get();

        // Kunjungan selesai terbaru
        $kunjunganSelesai = Kunjungan::with(['pasien', 'poli', 'dokter'])
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->orderByDesc('updated_at')
            ->limit(5)->get();

        // Grafik kunjungan 7 hari
        $grafikKunjungan = collect(range(6, 0))->map(function ($day) {
            $tgl = today()->subDays($day);
            return [
                'tanggal'    => $tgl->format('d M'),
                'kunjungan'  => Kunjungan::whereDate('tanggal', $tgl)->count(),
                'pendapatan' => (float) Billing::whereDate('created_at', $tgl)->where('status', 'lunas')->sum('total'),
            ];
        });

        // Dokter aktif hari ini
        $hariIni = strtolower(now()->translatedFormat('l'));
        $hariMap = ['sunday'=>'minggu','monday'=>'senin','tuesday'=>'selasa','wednesday'=>'rabu','thursday'=>'kamis','friday'=>'jumat','saturday'=>'sabtu'];
        $hariIni = $hariMap[$hariIni] ?? $hariIni;

        $dokterHariIni = Dokter::with(['poli', 'jadwal' => fn($q) => $q->where('hari', $hariIni)->where('aktif', true)])
            ->where('aktif', true)
            ->whereHas('jadwal', fn($q) => $q->where('hari', $hariIni)->where('aktif', true))
            ->get();

        return view('dashboard', compact(
            'totalKunjunganHariIni', 'menunggu', 'diperiksa', 'selesai',
            'pendapatanHariIni', 'totalPasien', 'resepMenunggu', 'obatMenipis',
            'antrianAktif', 'kunjunganSelesai', 'grafikKunjungan', 'dokterHariIni'
        ));
    }
}
