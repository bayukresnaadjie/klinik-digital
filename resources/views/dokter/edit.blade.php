@extends('layouts.app')
@section('title', isset($dokter) ? 'Edit Dokter' : 'Tambah Dokter')
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ isset($dokter) ? route('dokter.update', $dokter) : route('dokter.store') }}" method="POST" class="space-y-4">
    @csrf @if(isset($dokter)) @method('PUT') @endif
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Dokter <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $dokter->nama ?? '') }}" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Spesialisasi <span class="text-red-500">*</span></label>
            <input type="text" name="spesialisasi" value="{{ old('spesialisasi', $dokter->spesialisasi ?? '') }}" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Poli <span class="text-red-500">*</span></label>
            <select name="poli_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach($poli as $p)
                <option value="{{ $p->id }}" {{ old('poli_id', $dokter->poli_id ?? '') == $p->id ? 'selected':'' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">No. SIP</label>
            <input type="text" name="sip" value="{{ old('sip', $dokter->sip ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Biaya Konsultasi (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="biaya_konsultasi" value="{{ old('biaya_konsultasi', $dokter->biaya_konsultasi ?? 50000) }}" required min="0"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        @if(isset($dokter))
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $dokter->aktif ?? true) ? 'checked':'' }} class="w-4 h-4 text-blue-600 rounded"/>
                <span class="text-sm text-gray-700">Dokter aktif</span>
            </label>
        </div>
        @endif
    </div>
    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('dokter.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">{{ isset($dokter) ? 'Simpan' : 'Tambah Dokter' }}</button>
    </div>
</form>
</div>
</div>
@endsection
