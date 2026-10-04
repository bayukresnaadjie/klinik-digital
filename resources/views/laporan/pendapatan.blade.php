@extends('layouts.app')
@section('title','Laporan Pendapatan')
@section('content')
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-4 flex gap-3 items-end">
    <div><label class="block text-xs text-gray-500 mb-1">Dari</label><input type="date" name="dari" value="{{ $dari }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
    <div><label class="block text-xs text-gray-500 mb-1">Sampai</label><input type="date" name="sampai" value="{{ $sampai }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
    <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
</form>

<div class="grid grid-cols-3 gap-4 mb-4">
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
        <div class="text-xs text-emerald-600 mb-1">Total Pendapatan</div>
        <div class="text-xl font-bold text-emerald-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="text-xs text-blue-600 mb-1">Dari Konsultasi</div>
        <div class="text-xl font-bold text-blue-700">Rp {{ number_format($totalKonsultasi, 0, ',', '.') }}</div>
    </div>
    <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
        <div class="text-xs text-purple-600 mb-1">Dari Obat</div>
        <div class="text-xl font-bold text-purple-700">Rp {{ number_format($totalObat, 0, ',', '.') }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nomor</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Pasien</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Metode</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Waktu Bayar</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Total</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($billing as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-blue-600">{{ $b->nomor_billing }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $b->kunjungan->pasien->nama ?? '-' }}</td>
                <td class="px-5 py-3 uppercase text-xs text-gray-500">{{ $b->metode_bayar }}</td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ $b->bayar_at ? $b->bayar_at->format('d M Y H:i') : '-' }}</td>
                <td class="px-5 py-3 text-right font-semibold text-emerald-600">{{ $b->total_format }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada data pembayaran</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
