<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $poli = Poli::withCount(['dokter', 'kunjungan' => fn($q) => $q->whereDate('tanggal', today())])
            ->orderBy('kode')->get();
        return view('poli.index', compact('poli'));
    }

    public function create()
    {
        return view('poli.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'        => 'required|string|max:10|unique:poli',
            'nama'        => 'required|string|max:255',
            'lantai'      => 'nullable|string|max:10',
            'nomor_ruang' => 'nullable|string|max:20',
        ]);

        Poli::create($validated);
        return redirect()->route('poli.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(Poli $poli)
    {
        return view('poli.edit', compact('poli'));
    }

    public function update(Request $request, Poli $poli)
    {
        $validated = $request->validate([
            'kode'        => 'required|string|max:10|unique:poli,kode,' . $poli->id,
            'nama'        => 'required|string|max:255',
            'lantai'      => 'nullable|string|max:10',
            'nomor_ruang' => 'nullable|string|max:20',
            'aktif'       => 'sometimes|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $poli->update($validated);

        return redirect()->route('poli.index')->with('success', 'Data poli berhasil diperbarui.');
    }

    public function destroy(Poli $poli)
    {
        $poli->update(['aktif' => false]);
        return redirect()->route('poli.index')->with('success', 'Poli berhasil dinonaktifkan.');
    }
}
