@extends('layouts.app')
@section('title','Pemeriksaan Pasien')
@section('subtitle', $kunjungan->pasien->nama . ' · ' . $kunjungan->nomor_kunjungan)
@section('content')
<div class="max-w-3xl">

{{-- Info Pasien --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">{{ $kunjungan->nomor_antrian }}</div>
        <div>
            <div class="font-semibold text-blue-900">{{ $kunjungan->pasien->nama }}</div>
            <div class="text-xs text-blue-600">{{ $kunjungan->pasien->nomor_rm }} · {{ $kunjungan->pasien->umur }} tahun · {{ $kunjungan->pasien->jenis_kelamin_label }} · {{ $kunjungan->poli->nama }}</div>
            @if($kunjungan->pasien->alergi)<div class="text-xs text-red-600 font-medium mt-0.5">⚠ Alergi: {{ $kunjungan->pasien->alergi }}</div>@endif
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ route('rekam-medis.store', $kunjungan) }}" method="POST" class="space-y-5">
    @csrf

    {{-- Vital Sign --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b">Tanda Vital</h3>
        <div class="grid grid-cols-3 gap-3">
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Tekanan Darah</label>
                <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah') }}" placeholder="120/80"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Suhu (°C)</label>
                <input type="number" name="suhu" value="{{ old('suhu') }}" placeholder="36.5" step="0.1" min="30" max="45"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Nadi (/menit)</label>
                <input type="number" name="nadi" value="{{ old('nadi') }}" placeholder="80"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Respirasi (/menit)</label>
                <input type="number" name="respirasi" value="{{ old('respirasi') }}" placeholder="20"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Berat Badan (kg)</label>
                <input type="number" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="65" step="0.1"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="165"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
    </div>

    {{-- Anamnesa --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b">Anamnesa</h3>
        <div class="space-y-3">
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Keluhan Utama</label>
                <textarea name="keluhan" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('keluhan', $kunjungan->keluhan_utama) }}</textarea></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Riwayat Penyakit</label>
                <textarea name="riwayat_penyakit" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('riwayat_penyakit') }}</textarea></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Riwayat Alergi</label>
                <input type="text" name="riwayat_alergi" value="{{ old('riwayat_alergi', $kunjungan->pasien->alergi) }}" placeholder="Tidak ada"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        </div>
    </div>

    {{-- Pemeriksaan & Diagnosa --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b">Pemeriksaan & Diagnosa</h3>
        <div class="space-y-3">
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Pemeriksaan Fisik</label>
                <textarea name="pemeriksaan_fisik" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('pemeriksaan_fisik') }}</textarea></div>
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2"><label class="block text-xs font-medium text-gray-600 mb-1">Diagnosa <span class="text-red-500">*</span></label>
                    <input type="text" name="diagnosa" value="{{ old('diagnosa') }}" required placeholder="Contoh: ISPA, Hipertensi..."
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
                <div><label class="block text-xs font-medium text-gray-600 mb-1">Kode ICD-10</label>
                    <input type="text" name="kode_icd" value="{{ old('kode_icd') }}" placeholder="J06.9"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            </div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Tindakan</label>
                <textarea name="tindakan" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('tindakan') }}</textarea></div>
            <div><label class="block text-xs font-medium text-gray-600 mb-1">Catatan Dokter</label>
                <textarea name="catatan_dokter" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan_dokter') }}</textarea></div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-xs font-medium text-gray-600 mb-1">Anjuran <span class="text-red-500">*</span></label>
                    <select name="anjuran" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="rawat_jalan">Rawat Jalan</option>
                        <option value="rawat_inap">Rawat Inap</option>
                        <option value="rujuk">Rujuk</option>
                        <option value="kontrol">Kontrol Ulang</option>
                    </select></div>
                <div><label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Kontrol</label>
                    <input type="date" name="tanggal_kontrol" value="{{ old('tanggal_kontrol') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
            </div>
        </div>
    </div>

    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('antrian.show', $kunjungan) }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">Simpan & Lanjut ke Resep</button>
    </div>
</form>
</div>
</div>
@endsection
