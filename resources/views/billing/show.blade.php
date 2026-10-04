@extends('layouts.app')
@section('title','Detail Pembayaran')
@section('subtitle', $billing->nomor_billing)
@section('header-action')
<a href="{{ route('billing.kwitansi', $billing) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    Cetak Kwitansi
</a>
@endsection
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex justify-between items-center mb-3">
            <span class="font-mono text-sm text-blue-600 font-bold">{{ $billing->nomor_billing }}</span>
            <span class="text-xs px-2 py-0.5 rounded {{ $billing->status_badge['class'] }}">{{ $billing->status_badge['label'] }}</span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div><span class="text-xs text-gray-400 block">Pasien</span><span class="font-semibold">{{ $billing->kunjungan->pasien->nama }}</span></div>
            <div><span class="text-xs text-gray-400 block">Dokter</span><span>{{ $billing->kunjungan->dokter->nama }}</span></div>
            <div><span class="text-xs text-gray-400 block">Metode Bayar</span><span class="uppercase font-medium">{{ $billing->metode_bayar }}</span></div>
            <div><span class="text-xs text-gray-400 block">Waktu Bayar</span><span>{{ $billing->bayar_at ? $billing->bayar_at->format('d M Y H:i') : '-' }}</span></div>
        </div>
    </div>
    <div class="px-6 py-4 space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-gray-500">Biaya Konsultasi</span><span>Rp {{ number_format($billing->biaya_konsultasi, 0, ',', '.') }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Biaya Obat</span><span>Rp {{ number_format($billing->biaya_obat, 0, ',', '.') }}</span></div>
        @if($billing->biaya_tindakan > 0)
        <div class="flex justify-between"><span class="text-gray-500">Biaya Tindakan</span><span>Rp {{ number_format($billing->biaya_tindakan, 0, ',', '.') }}</span></div>
        @endif
        @if($billing->diskon > 0)
        <div class="flex justify-between"><span class="text-gray-500">Diskon</span><span class="text-red-500">- Rp {{ number_format($billing->diskon, 0, ',', '.') }}</span></div>
        @endif
        <div class="flex justify-between font-bold text-base border-t pt-2"><span>Total</span><span class="text-blue-600">{{ $billing->total_format }}</span></div>
    </div>
</div>
<div class="mt-4"><a href="{{ route('billing.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a></div>
</div>
@endsection
