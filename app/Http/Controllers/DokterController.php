<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\JadwalDokter;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::with(['poli', 'jadwal'])->orderBy('nama')->get();
        return view('dokter.index', compact('dokter'));
    }

    public function create()
    {
        $poli  = Poli::where('aktif', true)->get();
        $users = User::where('role', 'dokter')->get();
        return view('dokter.create', compact('poli', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'nullable|exists:users,id',
            'poli_id'          => 'required|exists:poli,id',
            'nama'             => 'required|string|max:255',
            'spesialisasi'     => 'required|string|max:100',
            'sip'              => 'nullable|string|max:50',
            'biaya_konsultasi' => 'required|numeric|min:0',
            'jadwal'           => 'nullable|array',
            'jadwal.*.hari'    => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'jadwal.*.jam_mulai'  => 'required|string',
            'jadwal.*.jam_selesai'=> 'required|string',
        ]);

        $dokter = Dokter::create([
            'user_id'          => $validated['user_id'] ?? null,
            'poli_id'          => $validated['poli_id'],
            'nama'             => $validated['nama'],
            'spesialisasi'     => $validated['spesialisasi'],
            'sip'              => $validated['sip'] ?? null,
            'biaya_konsultasi' => $validated['biaya_konsultasi'],
        ]);

        if (!empty($validated['jadwal'])) {
            foreach ($validated['jadwal'] as $j) {
                JadwalDokter::create([
                    'dokter_id'   => $dokter->id,
                    'hari'        => $j['hari'],
                    'jam_mulai'   => $j['jam_mulai'],
                    'jam_selesai' => $j['jam_selesai'],
                ]);
            }
        }

        return redirect()->route('dokter.index')->with('success', "Dokter {$dokter->nama} berhasil ditambahkan.");
    }

    public function edit(Dokter $dokter)
    {
        $dokter->load('jadwal');
        $poli  = Poli::where('aktif', true)->get();
        $users = User::where('role', 'dokter')->get();
        return view('dokter.edit', compact('dokter', 'poli', 'users'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'poli_id'          => 'required|exists:poli,id',
            'nama'             => 'required|string|max:255',
            'spesialisasi'     => 'required|string|max:100',
            'sip'              => 'nullable|string|max:50',
            'biaya_konsultasi' => 'required|numeric|min:0',
            'aktif'            => 'sometimes|boolean',
        ]);

        $validated['aktif'] = $request->boolean('aktif', true);
        $dokter->update($validated);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->update(['aktif' => false]);
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dinonaktifkan.');
    }
}
