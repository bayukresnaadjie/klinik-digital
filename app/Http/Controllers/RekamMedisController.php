<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisController extends Controller
{
    public function create(Kunjungan $kunjungan)
    {
        if ($kunjungan->rekamMedis) {
            return redirect()->route('rekam-medis.show', $kunjungan)
                ->with('info', 'Rekam medis sudah ada.');
        }
        $kunjungan->load(['pasien', 'dokter', 'poli']);
        return view('rekam-medis.create', compact('kunjungan'));
    }

    public function store(Request $request, Kunjungan $kunjungan)
    {
        $validated = $request->validate([
            'tekanan_darah'    => 'nullable|string|max:20',
            'suhu'             => 'nullable|numeric|between:30,45',
            'nadi'             => 'nullable|integer|between:30,200',
            'respirasi'        => 'nullable|integer|between:5,60',
            'berat_badan'      => 'nullable|numeric|between:1,300',
            'tinggi_badan'     => 'nullable|numeric|between:30,250',
            'keluhan'          => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'riwayat_alergi'   => 'nullable|string',
            'pemeriksaan_fisik'=> 'nullable|string',
            'diagnosa'         => 'required|string',
            'kode_icd'         => 'nullable|string|max:20',
            'tindakan'         => 'nullable|string',
            'catatan_dokter'   => 'nullable|string',
            'anjuran'          => 'required|in:rawat_jalan,rawat_inap,rujuk,kontrol',
            'tanggal_kontrol'  => 'nullable|date|after:today',
        ]);

        RekamMedis::create(array_merge($validated, [
            'kunjungan_id' => $kunjungan->id,
            'dokter_id'    => $kunjungan->dokter_id,
        ]));

        $kunjungan->update(['status' => 'diperiksa']);

        return redirect()->route('resep.create', $kunjungan)
            ->with('success', 'Rekam medis berhasil disimpan. Silakan buat resep.');
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'dokter', 'poli', 'rekamMedis', 'resep.details.obat', 'billing']);
        return view('rekam-medis.show', compact('kunjungan'));
    }

    public function riwayat(Pasien $pasien)
    {
        $pasien->load(['kunjungan.poli', 'kunjungan.dokter', 'kunjungan.rekamMedis']);
        $kunjungan = $pasien->kunjungan()->with(['poli', 'dokter', 'rekamMedis'])
            ->orderByDesc('tanggal')->get();
        return view('rekam-medis.riwayat', compact('pasien', 'kunjungan'));
    }

    public function suratSakit(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pasien', 'dokter', 'rekamMedis']);

        if (!$kunjungan->rekamMedis) {
            return back()->with('error', 'Rekam medis belum ada.');
        }

        $pdf = Pdf::loadView('surat.sakit', compact('kunjungan'))->setPaper('a4');
        return $pdf->stream("surat-sakit-{$kunjungan->pasien->nomor_rm}.pdf");
    }
}
