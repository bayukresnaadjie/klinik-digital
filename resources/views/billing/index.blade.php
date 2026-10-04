@extends('layouts.app')
@section('title','Kasir & Billing')
@section('subtitle','Daftar pembayaran pasien')
@section('content')

<div class="grid grid-cols-2 gap-4 mb-4">
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
        <div class="text-xs text-emerald-600 font-medium">Pendapatan Hari Ini</div>
        <div class="text-2xl font-bold text-emerald-700">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</div>
    </div>
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
        <div class="text-xs text-amber-600 font-medium">Menunggu Pembayaran</div>
        <div class="text-2xl font-bold text-amber-700">{{ $belumBayar }} pasien</div>
    </div>
</div>

{{-- Pasien yang perlu bayar --}}
@php
    $perluBayar = \App\Models\Kunjungan::with(['pasien','dokter','billing'])
        ->where('status','selesai')
        ->whereDoesntHave('billing', fn($q) => $q->where('status','lunas'))
        ->whereDate('tanggal', today())
        ->get();
@endphp

@if($perluBayar->count() > 0)
<div class="bg-white rounded-xl border border-amber-200 mb-4">
    <div class="px-5 py-3 border-b border-amber-100 bg-amber-50">
        <h2 class="text-sm font-semibold text-amber-800">Menunggu Pembayaran ({{ $perluBayar->count() }})</h2>
    </div>
    <div class="divide-y divide-gray-50">
        @foreach($perluBayar as $k)
        <div class="px-5 py-3 flex items-center justify-between">
            <div>
                <div class="font-medium text-gray-900 text-sm">{{ $k->pasien->nama }}</div>
                <div class="text-xs text-gray-400">{{ $k->nomor_kunjungan }} · {{ $k->dokter->nama }}</div>
            </div>
            <a href="{{ route('billing.create', $k) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">Proses Bayar</a>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100"><h2 class="text-sm font-semibold text-gray-900">Riwayat Pembayaran Hari Ini</h2></div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Nomor</th>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Pasien</th>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Metode</th>
            <th class="text-right px-5 py-2.5 text-xs font-semibold text-gray-400">Total</th>
            <th class="text-right px-5 py-2.5 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($billing as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-blue-600">{{ $b->nomor_billing }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $b->kunjungan->pasien->nama ?? '-' }}</td>
                <td class="px-5 py-3 text-gray-500 uppercase text-xs">{{ $b->metode_bayar }}</td>
                <td class="px-5 py-3 text-right font-semibold text-emerald-600">{{ $b->total_format }}</td>
                <td class="px-5 py-3 text-right">
                    <a href="{{ route('billing.kwitansi', $b) }}" target="_blank" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Kwitansi</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-gray-400">Belum ada pembayaran hari ini</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
