@extends('layouts.app')
@section('title','Detail Kunjungan')
@section('subtitle', $kunjungan->nomor_kunjungan)
@section('content')
<div class="max-w-3xl space-y-4">

{{-- Info Pasien & Kunjungan --}}
<div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <span class="font-bold text-blue-700 text-lg">{{ $kunjungan->nomor_antrian }}</span>
            </div>
            <div>
                <div class="font-bold text-gray-900 text-lg">{{ $kunjungan->pasien->nama }}</div>
                <div class="text-sm text-gray-400">{{ $kunjungan->pasien->nomor_rm }} · {{ $kunjungan->pasien->umur }} tahun · {{ $kunjungan->pasien->jenis_kelamin_label }}</div>
            </div>
        </div>
        <span class="text-sm font-medium px-3 py-1 rounded-full {{ $kunjungan->status_badge['class'] }}">{{ $kunjungan->status_badge['label'] }}</span>
    </div>
    <div class="grid grid-cols-3 gap-4 text-sm">
        <div><span class="text-xs text-gray-400 block">Poli</span><span class="font-medium">{{ $kunjungan->poli->nama }}</span></div>
        <div><span class="text-xs text-gray-400 block">Dokter</span><span class="font-medium">{{ $kunjungan->dokter->nama }}</span></div>
        <div><span class="text-xs text-gray-400 block">Tanggal</span><span>{{ $kunjungan->tanggal->format('d F Y') }}</span></div>
        <div><span class="text-xs text-gray-400 block">Jenis Kunjungan</span><span class="capitalize">{{ $kunjungan->jenis_kunjungan }}</span></div>
        <div><span class="text-xs text-gray-400 block">Jenis Bayar</span><span class="uppercase font-medium text-blue-600">{{ $kunjungan->pasien->jenis_bayar }}</span></div>
        @if($kunjungan->keluhan_utama)
        <div class="col-span-3"><span class="text-xs text-gray-400 block">Keluhan Utama</span><span>{{ $kunjungan->keluhan_utama }}</span></div>
        @endif
    </div>
</div>

{{-- Rekam Medis --}}
@if($kunjungan->rekamMedis)
<div class="bg-white rounded-xl border border-gray-200 p-5">
    <h3 class="font-semibold text-gray-900 text-sm mb-3">Rekam Medis</h3>
    <div class="grid grid-cols-4 gap-3 text-sm mb-3">
        <div class="bg-gray-50 rounded-lg p-3 text-center"><div class="text-xs text-gray-400">Tensi</div><div class="font-bold">{{ $kunjungan->rekamMedis->tekanan_darah ?? '-' }}</div></div>
        <div class="bg-gray-50 rounded-lg p-3 text-center"><div class="text-xs text-gray-400">Suhu</div><div class="font-bold">{{ $kunjungan->rekamMedis->suhu ?? '-' }}°C</div></div>
        <div class="bg-gray-50 rounded-lg p-3 text-center"><div class="text-xs text-gray-400">Nadi</div><div class="font-bold">{{ $kunjungan->rekamMedis->nadi ?? '-' }}/mnt</div></div>
        <div class="bg-gray-50 rounded-lg p-3 text-center"><div class="text-xs text-gray-400">BB/TB</div><div class="font-bold text-xs">{{ $kunjungan->rekamMedis->berat_badan ?? '-' }}kg / {{ $kunjungan->rekamMedis->tinggi_badan ?? '-' }}cm</div></div>
    </div>
    <div class="space-y-2 text-sm">
        <div><span class="text-xs font-semibold text-gray-500 uppercase">Diagnosa:</span> {{ $kunjungan->rekamMedis->diagnosa }} @if($kunjungan->rekamMedis->kode_icd)<span class="text-xs text-gray-400 font-mono ml-1">({{ $kunjungan->rekamMedis->kode_icd }})</span>@endif</div>
        @if($kunjungan->rekamMedis->catatan_dokter)<div><span class="text-xs font-semibold text-gray-500 uppercase">Catatan:</span> {{ $kunjungan->rekamMedis->catatan_dokter }}</div>@endif
        <div><span class="text-xs font-semibold text-gray-500 uppercase">Anjuran:</span> <span class="capitalize">{{ str_replace('_',' ', $kunjungan->rekamMedis->anjuran) }}</span></div>
    </div>
</div>
@endif

{{-- Resep --}}
@if($kunjungan->resep)
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-3 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900 text-sm">Resep Obat</h3>
        <span class="text-xs px-2 py-0.5 rounded {{ $kunjungan->resep->status === 'selesai' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($kunjungan->resep->status) }}</span>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50"><tr>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Obat</th>
            <th class="text-center px-5 py-2.5 text-xs font-semibold text-gray-400">Jumlah</th>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Aturan Pakai</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($kunjungan->resep->details as $d)
            <tr>
                <td class="px-5 py-2.5 font-medium">{{ $d->obat->nama }}</td>
                <td class="px-5 py-2.5 text-center">{{ $d->jumlah }} {{ $d->obat->satuan }}</td>
                <td class="px-5 py-2.5 text-gray-500">{{ $d->aturan_pakai ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Billing --}}
@if($kunjungan->billing)
<div class="bg-white rounded-xl border border-gray-200 p-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-gray-900 text-sm">Billing</h3>
        <span class="text-xs font-medium px-2 py-0.5 rounded {{ $kunjungan->billing->status_badge['class'] }}">{{ $kunjungan->billing->status_badge['label'] }}</span>
    </div>
    <div class="space-y-1.5 text-sm">
        <div class="flex justify-between"><span class="text-gray-500">Biaya Konsultasi</span><span>Rp {{ number_format($kunjungan->billing->biaya_konsultasi, 0, ',', '.') }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Biaya Obat</span><span>Rp {{ number_format($kunjungan->billing->biaya_obat, 0, ',', '.') }}</span></div>
        <div class="flex justify-between font-bold border-t pt-2"><span>Total</span><span class="text-blue-600">{{ $kunjungan->billing->total_format }}</span></div>
    </div>
</div>
@endif

{{-- Action Buttons --}}
<div class="flex gap-3 flex-wrap">
    <a href="{{ route('antrian.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
    @if(!$kunjungan->rekamMedis && in_array($kunjungan->status, ['dipanggil','diperiksa']))
    <a href="{{ route('rekam-medis.create', $kunjungan) }}" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Isi Rekam Medis</a>
    @endif
    @if($kunjungan->rekamMedis && !$kunjungan->resep)
    <a href="{{ route('resep.create', $kunjungan) }}" class="bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Buat Resep</a>
    @endif
    @if($kunjungan->status === 'selesai' && (!$kunjungan->billing || $kunjungan->billing->status === 'belum_bayar'))
    <a href="{{ route('billing.create', $kunjungan) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Proses Pembayaran</a>
    @endif
    @if($kunjungan->billing && $kunjungan->billing->status === 'lunas')
    <a href="{{ route('billing.kwitansi', $kunjungan->billing) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">Cetak Kwitansi</a>
    @endif
    @if($kunjungan->rekamMedis)
    <a href="{{ route('surat.sakit', $kunjungan) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">Surat Sakit PDF</a>
    @endif
</div>

</div>
@endsection
