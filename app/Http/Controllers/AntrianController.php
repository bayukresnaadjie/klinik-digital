<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\Billing;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', today()->format('Y-m-d'));
        $poliId  = $request->get('poli_id');

        $query = Kunjungan::with(['pasien', 'poli', 'dokter', 'rekamMedis', 'billing'])
            ->whereDate('tanggal', $tanggal);

        if ($poliId) $query->where('poli_id', $poliId);

        $kunjungan = $query->orderBy('nomor_antrian')->get();
        $poli      = Poli::where('aktif', true)->get();

        $stats = [
            'menunggu'  => $kunjungan->whereIn('status', ['menunggu'])->count(),
            'diproses'  => $kunjungan->whereIn('status', ['dipanggil','diperiksa'])->count(),
            'selesai'   => $kunjungan->where('status', 'selesai')->count(),
            'batal'     => $kunjungan->where('status', 'batal')->count(),
        ];

        return view('antrian.index', compact('kunjungan', 'poli', 'tanggal', 'poliId', 'stats'));
    }

    public function daftar()
    {
        $pasien = Pasien::orderBy('nama')->get();
        $poli   = Poli::where('aktif', true)->get();
        $dokter = Dokter::with('poli')->where('aktif', true)->get();
        return view('antrian.daftar', compact('pasien', 'poli', 'dokter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id'       => 'required|exists:pasien,id',
            'poli_id'         => 'required|exists:poli,id',
            'dokter_id'       => 'required|exists:dokter,id',
            'jenis_kunjungan' => 'required|in:baru,lama,kontrol',
            'keluhan_utama'   => 'nullable|string|max:500',
        ]);

        $kunjungan = Kunjungan::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'tanggal' => today(),
            'status'  => 'menunggu',
        ]));

        return redirect()->route('antrian.index')
            ->with('success', "Antrian #{$kunjungan->nomor_antrian} berhasil didaftarkan untuk {$kunjungan->pasien->nama}. No: {$kunjungan->nomor_kunjungan}");
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'poli', 'dokter', 'rekamMedis', 'resep.details.obat', 'billing']);
        return view('antrian.show', compact('kunjungan'));
    }

    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate(['status' => 'required|in:menunggu,dipanggil,diperiksa,selesai,batal']);

        $kunjungan->update(['status' => $request->status]);

        // Auto buat billing saat status selesai
        if ($request->status === 'selesai' && !$kunjungan->billing) {
            $biayaObat = 0;
            if ($kunjungan->resep) {
                $biayaObat = $kunjungan->resep->details->sum(fn($d) => $d->jumlah * $d->obat->harga);
            }

            Billing::create([
                'kunjungan_id'     => $kunjungan->id,
                'biaya_konsultasi' => $kunjungan->dokter->biaya_konsultasi,
                'biaya_obat'       => $biayaObat,
                'biaya_tindakan'   => 0,
                'diskon'           => 0,
                'total'            => $kunjungan->dokter->biaya_konsultasi + $biayaObat,
                'status'           => 'belum_bayar',
            ]);
        }

        return back()->with('success', "Status kunjungan diubah ke: " . ucfirst($request->status));
    }
}
