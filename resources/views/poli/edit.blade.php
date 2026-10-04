@extends('layouts.app')
@section('title', isset($poli) ? 'Edit Poli' : 'Tambah Poli')
@section('content')
<div class="max-w-lg">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ isset($poli) ? route('poli.update', $poli) : route('poli.store') }}" method="POST" class="space-y-4">
    @csrf @if(isset($poli)) @method('PUT') @endif
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Kode Poli <span class="text-red-500">*</span></label>
            <input type="text" name="kode" value="{{ old('kode', $poli->kode ?? '') }}" required placeholder="POL-01"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Poli <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $poli->nama ?? '') }}" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Lantai</label>
            <input type="text" name="lantai" value="{{ old('lantai', $poli->lantai ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Nomor Ruang</label>
            <input type="text" name="nomor_ruang" value="{{ old('nomor_ruang', $poli->nomor_ruang ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
    </div>
    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('poli.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">{{ isset($poli) ? 'Simpan' : 'Tambah Poli' }}</button>
    </div>
</form>
</div>
</div>
@endsection
