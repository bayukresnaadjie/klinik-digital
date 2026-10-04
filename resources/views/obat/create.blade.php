@extends('layouts.app')
@section('title', isset($obat) ? 'Edit Obat' : 'Tambah Obat')
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ isset($obat) ? route('obat.update', $obat) : route('obat.store') }}" method="POST" class="space-y-4">
    @csrf @if(isset($obat)) @method('PUT') @endif
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Obat <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $obat->nama ?? '') }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $obat->kategori ?? '') }}" list="kategori-list" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            <datalist id="kategori-list">
                @foreach($kategori as $k)<option value="{{ $k }}">@endforeach
            </datalist>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Satuan <span class="text-red-500">*</span></label>
            <select name="satuan" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['tablet','kapsul','botol','sachet','ampul','tube','pcs'] as $s)
                <option value="{{ $s }}" {{ old('satuan', $obat->satuan ?? 'tablet') === $s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="harga" value="{{ old('harga', $obat->harga ?? 0) }}" required min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Stok <span class="text-red-500">*</span></label>
            <input type="number" name="stok" value="{{ old('stok', $obat->stok ?? 0) }}" required min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Stok Minimum</label>
            <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $obat->stok_minimum ?? 10) }}" min="0" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $obat->aktif ?? true) ? 'checked':'' }} class="w-4 h-4 text-blue-600 rounded"/>
                <span class="text-sm text-gray-700">Obat aktif</span>
            </label>
        </div>
    </div>
    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('obat.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">{{ isset($obat) ? 'Simpan' : 'Tambah Obat' }}</button>
    </div>
</form>
</div>
</div>
@endsection
