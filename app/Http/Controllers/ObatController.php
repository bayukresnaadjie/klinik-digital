<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kode', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->stok === 'menipis') {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $obat      = $query->orderBy('nama')->paginate(15)->withQueryString();
        $kategori  = Obat::distinct()->pluck('kategori')->filter()->sort()->values();
        $menipis   = Obat::where('aktif', true)->whereColumn('stok', '<=', 'stok_minimum')->count();

        return view('obat.index', compact('obat', 'kategori', 'menipis'));
    }

    public function create()
    {
        $kategori = Obat::distinct()->pluck('kategori')->filter()->sort()->values();
        return view('obat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'         => 'nullable|string|max:20|unique:obat',
            'nama'         => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'satuan'       => 'required|string|max:20',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'keterangan'   => 'nullable|string',
            'aktif'        => 'sometimes|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    public function edit(Obat $obat)
    {
        $kategori = Obat::distinct()->pluck('kategori')->filter()->sort()->values();
        return view('obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'kode'         => 'nullable|string|max:20|unique:obat,kode,' . $obat->id,
            'nama'         => 'required|string|max:255',
            'kategori'     => 'nullable|string|max:100',
            'satuan'       => 'required|string|max:20',
            'harga'        => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'keterangan'   => 'nullable|string',
            'aktif'        => 'sometimes|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $obat->update($validated);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus.');
    }
}
