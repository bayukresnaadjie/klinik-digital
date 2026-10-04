@extends('layouts.app')
@section('title','Laporan Kunjungan')
@section('content')
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-4 flex gap-3 items-end">
    <div><label class="block text-xs text-gray-500 mb-1">Dari</label><input type="date" name="dari" value="{{ $dari }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
    <div><label class="block text-xs text-gray-500 mb-1">Sampai</label><input type="date" name="sampai" value="{{ $sampai }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
    <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
</form>

<div class="grid grid-cols-4 gap-3 mb-4">
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-2xl font-bold text-blue-600">{{ $totalKunjungan }}</div>
        <div class="text-xs text-gray-500">Total Kunjungan</div>
    </div>
    @foreach($perStatus->take(3) as $status => $jml)
    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center">
        <div class="text-2xl font-bold text-gray-900">{{ $jml }}</div>
        <div class="text-xs text-gray-500 capitalize">{{ $status }}</div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Per Poli</h3>
        @foreach($perPoli as $nama => $jml)
        <div class="flex justify-between text-sm py-1 border-b border-gray-50">
            <span class="text-gray-600">{{ $nama }}</span>
            <span class="font-semibold text-blue-600">{{ $jml }}</span>
        </div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Per Dokter</h3>
        @foreach($perDokter as $nama => $jml)
        <div class="flex justify-between text-sm py-1 border-b border-gray-50">
            <span class="text-gray-600">{{ $nama }}</span>
            <span class="font-semibold text-blue-600">{{ $jml }}</span>
        </div>
        @endforeach
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">No. Kunjungan</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Pasien</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Poli / Dokter</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Tanggal</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Status</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($kunjungan as $k)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-blue-600">{{ $k->nomor_kunjungan }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $k->pasien->nama }}</td>
                <td class="px-5 py-3"><div class="text-xs text-gray-700">{{ $k->poli->nama }}</div><div class="text-xs text-gray-400">{{ $k->dokter->nama }}</div></td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ $k->tanggal->format('d M Y') }}</td>
                <td class="px-5 py-3 text-center"><span class="text-xs px-2 py-0.5 rounded {{ $k->status_badge['class'] }}">{{ $k->status_badge['label'] }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada data kunjungan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
