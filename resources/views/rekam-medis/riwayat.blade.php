@extends('layouts.app')
@section('title', 'Riwayat Medis')
@section('subtitle', $pasien->nama . ' · ' . $pasien->nomor_rm)
@section('content')
<div class="max-w-3xl">

<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">{{ substr($pasien->nama, 0, 1) }}</div>
        <div>
            <div class="font-semibold text-blue-900">{{ $pasien->nama }}</div>
            <div class="text-xs text-blue-600">{{ $pasien->nomor_rm }} · {{ $pasien->umur }} tahun · {{ $pasien->jenis_kelamin_label }}</div>
            @if($pasien->alergi)<div class="text-xs text-red-600 mt-0.5">⚠ Alergi: {{ $pasien->alergi }}</div>@endif
        </div>
    </div>
</div>

<div class="space-y-3">
    @forelse($kunjungan as $k)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
            <div>
                <span class="font-mono text-xs text-blue-600">{{ $k->nomor_kunjungan }}</span>
                <span class="text-gray-400 text-xs ml-2">{{ $k->tanggal->format('d F Y') }}</span>
            </div>
            <span class="text-xs px-2 py-0.5 rounded {{ $k->status_badge['class'] }}">{{ $k->status_badge['label'] }}</span>
        </div>
        <div class="px-5 py-3">
            <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                <div><span class="text-xs text-gray-400 block">Poli</span><span>{{ $k->poli->nama }}</span></div>
                <div><span class="text-xs text-gray-400 block">Dokter</span><span>{{ $k->dokter->nama }}</span></div>
            </div>
            @if($k->rekamMedis)
            <div class="bg-gray-50 rounded-lg p-3 text-sm space-y-1.5">
                <div><span class="text-xs font-semibold text-gray-500 uppercase">Diagnosa:</span> {{ $k->rekamMedis->diagnosa }}
                    @if($k->rekamMedis->kode_icd)<span class="text-xs text-gray-400 ml-1 font-mono">({{ $k->rekamMedis->kode_icd }})</span>@endif
                </div>
                @if($k->rekamMedis->catatan_dokter)
                <div><span class="text-xs font-semibold text-gray-500 uppercase">Catatan:</span> {{ $k->rekamMedis->catatan_dokter }}</div>
                @endif
                <div class="grid grid-cols-4 gap-2 mt-2 text-xs text-center">
                    @if($k->rekamMedis->tekanan_darah)<div class="bg-white rounded p-1.5"><div class="text-gray-400">Tensi</div><div class="font-bold">{{ $k->rekamMedis->tekanan_darah }}</div></div>@endif
                    @if($k->rekamMedis->suhu)<div class="bg-white rounded p-1.5"><div class="text-gray-400">Suhu</div><div class="font-bold">{{ $k->rekamMedis->suhu }}°C</div></div>@endif
                    @if($k->rekamMedis->nadi)<div class="bg-white rounded p-1.5"><div class="text-gray-400">Nadi</div><div class="font-bold">{{ $k->rekamMedis->nadi }}/mnt</div></div>@endif
                    @if($k->rekamMedis->berat_badan)<div class="bg-white rounded p-1.5"><div class="text-gray-400">BB</div><div class="font-bold">{{ $k->rekamMedis->berat_badan }}kg</div></div>@endif
                </div>
            </div>
            @else
            <p class="text-xs text-gray-400 italic">Belum ada rekam medis untuk kunjungan ini</p>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-sm text-gray-400">Belum ada riwayat medis</div>
    @endforelse
</div>

<div class="mt-4"><a href="{{ route('pasien.show', $pasien) }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a></div>
</div>
@endsection
