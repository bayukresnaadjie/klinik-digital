@extends('layouts.app')
@section('title', 'Rekam Medis')
@section('subtitle', $kunjungan->nomor_kunjungan)
@section('content')
<div class="max-w-2xl">
    @if($kunjungan->rekamMedis)
    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-4">
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-2 pb-1 border-b">Tanda Vital</h3>
            <div class="grid grid-cols-4 gap-3 text-center text-sm">
                <div class="bg-gray-50 rounded-lg p-3"><div class="text-xs text-gray-400">Tensi</div><div class="font-bold">{{ $kunjungan->rekamMedis->tekanan_darah ?? '-' }}</div></div>
                <div class="bg-gray-50 rounded-lg p-3"><div class="text-xs text-gray-400">Suhu</div><div class="font-bold">{{ $kunjungan->rekamMedis->suhu ?? '-' }}°C</div></div>
                <div class="bg-gray-50 rounded-lg p-3"><div class="text-xs text-gray-400">Nadi</div><div class="font-bold">{{ $kunjungan->rekamMedis->nadi ?? '-' }}/mnt</div></div>
                <div class="bg-gray-50 rounded-lg p-3"><div class="text-xs text-gray-400">IMT</div><div class="font-bold">{{ $kunjungan->rekamMedis->imt ?? '-' }}</div></div>
            </div>
        </div>
        <div class="space-y-2 text-sm">
            <div><span class="text-xs font-semibold text-gray-500 uppercase block mb-0.5">Diagnosa</span>{{ $kunjungan->rekamMedis->diagnosa }}</div>
            @if($kunjungan->rekamMedis->tindakan)<div><span class="text-xs font-semibold text-gray-500 uppercase block mb-0.5">Tindakan</span>{{ $kunjungan->rekamMedis->tindakan }}</div>@endif
            @if($kunjungan->rekamMedis->catatan_dokter)<div><span class="text-xs font-semibold text-gray-500 uppercase block mb-0.5">Catatan</span>{{ $kunjungan->rekamMedis->catatan_dokter }}</div>@endif
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-sm text-gray-400">Belum ada rekam medis</div>
    @endif
    <div class="mt-4"><a href="{{ route('antrian.show', $kunjungan) }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a></div>
</div>
@endsection
