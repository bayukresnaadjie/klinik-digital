@extends('layouts.app')
@section('title','Dashboard')
@section('subtitle','Ringkasan pelayanan ' . now()->translatedFormat('l, d F Y'))

@section('header-action')
<a href="{{ route('antrian.daftar') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Daftar Pasien
</a>
@endsection

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs text-gray-500">Kunjungan Hari Ini</span>
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold text-gray-900">{{ $totalKunjunganHariIni }}</div>
        <div class="flex gap-2 mt-1 text-xs">
            <span class="text-yellow-600">{{ $menunggu }} menunggu</span>
            <span class="text-gray-300">·</span>
            <span class="text-green-600">{{ $selesai }} selesai</span>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs text-gray-500">Pendapatan Hari Ini</span>
            <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
        </div>
        <div class="text-xl font-bold text-emerald-600">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-400 mt-1">dari pembayaran lunas</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs text-gray-500">Resep Menunggu</span>
            <div class="w-8 h-8 {{ $resepMenunggu > 0 ? 'bg-orange-50' : 'bg-gray-50' }} rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 {{ $resepMenunggu > 0 ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold {{ $resepMenunggu > 0 ? 'text-orange-600' : 'text-gray-900' }}">{{ $resepMenunggu }}</div>
        <div class="text-xs text-gray-400 mt-1">perlu diproses apotek</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs text-gray-500">Stok Obat Menipis</span>
            <div class="w-8 h-8 {{ $obatMenipis > 0 ? 'bg-red-50' : 'bg-gray-50' }} rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 {{ $obatMenipis > 0 ? 'text-red-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <div class="text-2xl font-bold {{ $obatMenipis > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $obatMenipis }}</div>
        <div class="text-xs text-gray-400 mt-1">{{ $obatMenipis > 0 ? 'segera restok' : 'stok aman ✓' }}</div>
    </div>
</div>

<div class="grid grid-cols-3 gap-4 mb-4">
    {{-- Antrian Aktif --}}
    <div class="col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-gray-900">Antrian Aktif Hari Ini</h2>
            <a href="{{ route('antrian.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($antrianAktif as $k)
            <div class="px-5 py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="font-bold text-blue-700 text-sm">{{ $k->nomor_antrian }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $k->pasien->nama }}</div>
                        <div class="text-xs text-gray-400">{{ $k->poli->nama }} · {{ $k->dokter->nama }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium px-2 py-0.5 rounded {{ $k->status_badge['class'] }}">{{ $k->status_badge['label'] }}</span>
                    <a href="{{ route('antrian.show', $k) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded-lg">Detail</a>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada antrian aktif saat ini</div>
            @endforelse
        </div>
    </div>

    {{-- Dokter Hari Ini + Grafik --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Dokter Praktek Hari Ini</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($dokterHariIni as $d)
                <div class="px-5 py-3">
                    <div class="text-sm font-medium text-gray-900">{{ $d->nama }}</div>
                    <div class="text-xs text-gray-400">{{ $d->poli->nama }}</div>
                    @foreach($d->jadwal as $j)
                    <div class="text-xs text-blue-600 mt-0.5">{{ $j->jam_mulai }} — {{ $j->jam_selesai }}</div>
                    @endforeach
                </div>
                @empty
                <div class="px-5 py-6 text-center text-xs text-gray-400">Tidak ada jadwal praktek hari ini</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="text-sm font-semibold text-gray-900 mb-3">Kunjungan 7 Hari</h2>
            @php $maxVal = max($grafikKunjungan->max('kunjungan'), 1); @endphp
            <div class="flex items-end gap-1.5 h-20">
                @foreach($grafikKunjungan as $g)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-full bg-blue-400 rounded-t" style="height:{{ max(2, ($g['kunjungan']/$maxVal)*72) }}px" title="{{ $g['kunjungan'] }} kunjungan"></div>
                    <span class="text-xs text-gray-400" style="font-size:9px">{{ $g['tanggal'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
