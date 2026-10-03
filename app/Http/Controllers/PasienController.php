<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('nama', 'like', "%$s%")
                ->orWhere('nomor_rm', 'like', "%$s%")
                ->orWhere('nik', 'like', "%$s%")
                ->orWhere('telepon', 'like', "%$s%")
            );
        }

        if ($request->filled('jenis_bayar')) {
            $query->where('jenis_bayar', $request->jenis_bayar);
        }

        $pasien = $query->orderBy('nama')->paginate(15)->withQueryString();
        return view('pasien.index', compact('pasien'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'              => 'nullable|string|size:16|unique:pasien',
            'nama'             => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_lahir'    => 'required|date|before:today',
            'golongan_darah'   => 'nullable|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alamat'           => 'nullable|string',
            'telepon'          => 'nullable|string|max:20',
            'email'            => 'nullable|email',
            'pekerjaan'        => 'nullable|string|max:100',
            'nama_keluarga'    => 'nullable|string|max:255',
            'telepon_keluarga' => 'nullable|string|max:20',
            'jenis_bayar'      => 'required|in:umum,bpjs,asuransi',
            'no_bpjs'          => 'nullable|string|max:20',
            'alergi'           => 'nullable|string',
        ]);

        $pasien = Pasien::create($validated);
        return redirect()->route('pasien.show', $pasien)->with('success', "Pasien {$pasien->nama} berhasil didaftarkan. Nomor RM: {$pasien->nomor_rm}");
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['kunjungan.poli', 'kunjungan.dokter', 'kunjungan.rekamMedis', 'kunjungan.billing']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nik'              => 'nullable|string|size:16|unique:pasien,nik,' . $pasien->id,
            'nama'             => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:L,P',
            'tanggal_lahir'    => 'required|date|before:today',
            'golongan_darah'   => 'nullable|string|max:5',
            'alamat'           => 'nullable|string',
            'telepon'          => 'nullable|string|max:20',
            'email'            => 'nullable|email',
            'pekerjaan'        => 'nullable|string|max:100',
            'nama_keluarga'    => 'nullable|string|max:255',
            'telepon_keluarga' => 'nullable|string|max:20',
            'jenis_bayar'      => 'required|in:umum,bpjs,asuransi',
            'no_bpjs'          => 'nullable|string|max:20',
            'alergi'           => 'nullable|string',
        ]);

        $pasien->update($validated);
        return redirect()->route('pasien.show', $pasien)->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }
}
