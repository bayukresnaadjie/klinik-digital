<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Resep;
use App\Models\DetailResep;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    public function index()
    {
        $resep = Resep::with(['kunjungan.pasien', 'dokter'])
            ->orderByDesc('created_at')->paginate(15);
        return view('resep.index', compact('resep'));
    }

    public function create(Kunjungan $kunjungan)
    {
        if ($kunjungan->resep) {
            return redirect()->route('resep.show', $kunjungan->resep)
                ->with('info', 'Resep sudah ada untuk kunjungan ini.');
        }
        $kunjungan->load(['pasien', 'dokter', 'rekamMedis']);
        $obat = Obat::where('aktif', true)->where('stok', '>', 0)->orderBy('nama')->get();
        return view('resep.create', compact('kunjungan', 'obat'));
    }

    public function store(Request $request, Kunjungan $kunjungan)
    {
        $validated = $request->validate([
            'catatan'              => 'nullable|string',
            'items'                => 'required|array|min:1',
            'items.*.obat_id'      => 'required|exists:obat,id',
            'items.*.jumlah'       => 'required|integer|min:1',
            'items.*.aturan_pakai' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated, $kunjungan) {
            $resep = Resep::create([
                'kunjungan_id' => $kunjungan->id,
                'dokter_id'    => $kunjungan->dokter_id,
                'status'       => 'menunggu',
                'catatan'      => $validated['catatan'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $obat = Obat::findOrFail($item['obat_id']);
                if ($obat->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$obat->nama} tidak mencukupi.");
                }

                DetailResep::create([
                    'resep_id'    => $resep->id,
                    'obat_id'     => $item['obat_id'],
                    'jumlah'      => $item['jumlah'],
                    'aturan_pakai'=> $item['aturan_pakai'] ?? null,
                ]);
            }
        });

        return redirect()->route('antrian.show', $kunjungan)
            ->with('success', 'Resep berhasil dibuat dan dikirim ke apotek.');
    }

    public function show(Resep $resep)
    {
        $resep->load(['kunjungan.pasien', 'dokter', 'details.obat']);
        return view('resep.show', compact('resep'));
    }

    public function proses(Request $request, Resep $resep)
    {
        $request->validate(['status' => 'required|in:diproses,selesai']);

        DB::transaction(function () use ($request, $resep) {
            if ($request->status === 'selesai') {
                // Kurangi stok obat
                foreach ($resep->details as $d) {
                    $d->obat->decrement('stok', $d->jumlah);
                }
            }
            $resep->update(['status' => $request->status]);
        });

        return back()->with('success', 'Status resep diperbarui.');
    }
}
