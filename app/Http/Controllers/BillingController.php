<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Billing::with(['kunjungan.pasien', 'kunjungan.dokter']);

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('dari'))   $query->whereDate('created_at', '>=', $request->dari);
        if ($request->filled('sampai')) $query->whereDate('created_at', '<=', $request->sampai);

        $billing          = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $totalBelumBayar  = Billing::where('status', 'belum_bayar')->sum('total');
        $totalHariIni     = Billing::whereDate('created_at', today())->where('status', 'lunas')->sum('total');

        return view('billing.index', compact('billing', 'totalBelumBayar', 'totalHariIni'));
    }

    public function create(Kunjungan $kunjungan)
    {
        if ($kunjungan->billing && $kunjungan->billing->status === 'lunas') {
            return redirect()->route('billing.show', $kunjungan->billing)
                ->with('info', 'Billing sudah lunas.');
        }

        $kunjungan->load(['pasien', 'dokter', 'resep.details.obat', 'rekamMedis']);
        $biayaObat = 0;
        if ($kunjungan->resep) {
            $biayaObat = $kunjungan->resep->details->sum(fn($d) => $d->jumlah * $d->obat->harga);
        }

        return view('billing.create', compact('kunjungan', 'biayaObat'));
    }

    public function store(Request $request, Kunjungan $kunjungan)
    {
        $validated = $request->validate([
            'biaya_konsultasi' => 'required|numeric|min:0',
            'biaya_obat'       => 'required|numeric|min:0',
            'biaya_tindakan'   => 'nullable|numeric|min:0',
            'diskon'           => 'nullable|numeric|min:0',
            'metode_bayar'     => 'required|in:tunai,bpjs,transfer,kartu',
        ]);

        $total = ($validated['biaya_konsultasi'] + $validated['biaya_obat'] + ($validated['biaya_tindakan'] ?? 0)) - ($validated['diskon'] ?? 0);

        if ($kunjungan->billing) {
            $kunjungan->billing->update([
                ...$validated,
                'total'    => $total,
                'status'   => 'lunas',
                'bayar_at' => now(),
            ]);
            $billing = $kunjungan->billing;
        } else {
            $billing = Billing::create([
                'kunjungan_id'     => $kunjungan->id,
                'biaya_konsultasi' => $validated['biaya_konsultasi'],
                'biaya_obat'       => $validated['biaya_obat'],
                'biaya_tindakan'   => $validated['biaya_tindakan'] ?? 0,
                'diskon'           => $validated['diskon'] ?? 0,
                'total'            => $total,
                'metode_bayar'     => $validated['metode_bayar'],
                'status'           => 'lunas',
                'bayar_at'         => now(),
            ]);
        }

        $kunjungan->update(['status' => 'selesai']);

        return redirect()->route('billing.show', $billing)
            ->with('success', 'Pembayaran berhasil! Kunjungan selesai.');
    }

    public function show(Billing $billing)
    {
        $billing->load(['kunjungan.pasien', 'kunjungan.dokter', 'kunjungan.poli', 'kunjungan.resep.details.obat']);
        return view('billing.show', compact('billing'));
    }

    public function kwitansi(Billing $billing)
    {
        $billing->load(['kunjungan.pasien', 'kunjungan.dokter', 'kunjungan.poli', 'kunjungan.resep.details.obat']);
        $pdf = Pdf::loadView('billing.kwitansi', compact('billing'))->setPaper('a5');
        return $pdf->stream("kwitansi-{$billing->nomor_billing}.pdf");
    }
}
