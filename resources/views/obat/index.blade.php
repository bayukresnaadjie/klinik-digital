@extends('layouts.app')
@section('title','Data Obat')
@section('header-action')
<a href="{{ route('obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Tambah Obat
</a>
@endsection
@section('content')

@if($menipis > 0)
<div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2 text-red-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <span class="text-sm font-medium">{{ $menipis }} obat stoknya menipis atau habis — segera lakukan restok!</span>
    </div>
    <a href="?stok=menipis" class="text-xs text-red-600 bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg transition">Lihat Obat Menipis</a>
</div>
@endif

<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <div class="flex gap-3 items-end">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode obat..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <select name="kategori" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)
            <option value="{{ $k }}" {{ request('kategori')===$k ? 'selected':'' }}>{{ $k }}</option>
            @endforeach
        </select>
        <select name="stok" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Stok</option>
            <option value="menipis" {{ request('stok')==='menipis' ? 'selected':'' }}>Menipis</option>
        </select>
        <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Kode</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nama Obat</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Kategori</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Harga</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Stok</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($obat as $o)
            <tr class="hover:bg-gray-50 {{ $o->isStokHabis() ? 'bg-red-50' : ($o->isStokMinimum() ? 'bg-amber-50' : '') }}">
                <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $o->kode }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $o->nama }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $o->kategori ?? '-' }}</td>
                <td class="px-5 py-3 text-right text-gray-700">{{ $o->harga_format }}</td>
                <td class="px-5 py-3 text-center">
                    <span class="font-bold {{ $o->isStokHabis() ? 'text-red-600' : ($o->isStokMinimum() ? 'text-amber-600' : 'text-gray-900') }}">
                        {{ $o->stok }} {{ $o->satuan }}
                    </span>
                    @if($o->isStokHabis())    <div class="text-xs text-red-500">Habis!</div>
                    @elseif($o->isStokMinimum()) <div class="text-xs text-amber-500">Menipis</div>
                    @endif
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex justify-end gap-1">
                        <a href="{{ route('obat.edit', $o) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Edit</a>
                        <form action="{{ route('obat.destroy', $o) }}" method="POST" onsubmit="return confirm('Hapus obat ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded-lg">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Belum ada data obat</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($obat->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">{{ $obat->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
