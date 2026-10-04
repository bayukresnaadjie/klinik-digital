@extends('layouts.app')
@section('title', 'Detail Pasien')
@section('subtitle', $pasien->nomor_rm)
@section('header-action')
<div class="flex gap-2">
    <a href="{{ route('rekam-medis.riwayat', $pasien) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">Riwayat Medis</a>
    <a href="{{ route('antrian.daftar') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Daftarkan Kunjungan</a>
</div>
@endsection
@section('content')
<div class="max-w-3xl space-y-4">

<div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="text-blue-700 font-bold text-xl">{{ substr($pasien->nama, 0, 1) }}</span>
        </div>
        <div>
            <h2 class="font-bold text-gray-900 text-lg">{{ $pasien->nama }}</h2>
            <div class="text-sm text-gray-400 font-mono">{{ $pasien->nomor_rm }}</div>
        </div>
        <div class="ml-auto">
            <span class="text-xs font-medium px-2 py-1 rounded uppercase {{ $pasien->jenis_bayar === 'bpjs' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $pasien->jenis_bayar }}
            </span>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-4 text-sm">
        <div><span class="text-xs text-gray-400 block">Jenis Kelamin</span><span>{{ $pasien->jenis_kelamin_label }}</span></div>
        <div><span class="text-xs text-gray-400 block">Tanggal Lahir</span><span>{{ $pasien->tanggal_lahir->format('d F Y') }} ({{ $pasien->umur }} th)</span></div>
        <div><span class="text-xs text-gray-400 block">Golongan Darah</span><span class="font-bold">{{ $pasien->golongan_darah ?? '-' }}</span></div>
        <div><span class="text-xs text-gray-400 block">Telepon</span><span>{{ $pasien->telepon ?? '-' }}</span></div>
        <div><span class="text-xs text-gray-400 block">Pekerjaan</span><span>{{ $pasien->pekerjaan ?? '-' }}</span></div>
        <div><span class="text-xs text-gray-400 block">No. BPJS</span><span class="font-mono text-xs">{{ $pasien->no_bpjs ?? '-' }}</span></div>
        <div class="col-span-3"><span class="text-xs text-gray-400 block">Alamat</span><span>{{ $pasien->alamat ?? '-' }}</span></div>
        @if($pasien->alergi)
        <div class="col-span-3"><span class="text-xs text-red-500 font-semibold block">⚠ Alergi</span><span class="text-red-700">{{ $pasien->alergi }}</span></div>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 text-sm">Riwayat Kunjungan</h3>
        <span class="text-xs text-gray-400">{{ $pasien->kunjungan->count() }} kunjungan</span>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($pasien->kunjungan->sortByDesc('tanggal') as $k)
        <a href="{{ route('antrian.show', $k) }}" class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <div class="text-sm font-medium text-gray-900">{{ $k->poli->nama }} — {{ $k->dokter->nama }}</div>
                <div class="text-xs text-gray-400">{{ $k->tanggal->format('d F Y') }} · {{ $k->nomor_kunjungan }}</div>
                @if($k->rekamMedis)
                <div class="text-xs text-gray-500 mt-0.5">{{ Str::limit($k->rekamMedis->diagnosa, 50) }}</div>
                @endif
            </div>
            <span class="text-xs px-2 py-0.5 rounded {{ $k->status_badge['class'] }}">{{ $k->status_badge['label'] }}</span>
        </a>
        @empty
        <div class="px-5 py-8 text-center text-sm text-gray-400">Belum ada riwayat kunjungan</div>
        @endforelse
    </div>
</div>

<div class="flex gap-3">
    <a href="{{ route('pasien.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
    <a href="{{ route('pasien.edit', $pasien) }}" class="text-sm text-blue-600 hover:underline">Edit Data</a>
</div>
</div>
@endsection
