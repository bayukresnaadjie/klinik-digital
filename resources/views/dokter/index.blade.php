@extends('layouts.app')
@section('title','Data Dokter')
@section('header-action')
<a href="{{ route('dokter.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">+ Tambah Dokter</a>
@endsection
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nama Dokter</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Spesialisasi</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Poli</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Biaya</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Jadwal</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($dokter as $d)
            <tr class="hover:bg-gray-50 {{ !$d->aktif ? 'opacity-50':'' }}">
                <td class="px-5 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $d->spesialisasi }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $d->poli->nama }}</td>
                <td class="px-5 py-3 text-right text-gray-700">{{ $d->biaya_format }}</td>
                <td class="px-5 py-3">
                    <div class="flex flex-wrap gap-1">
                        @foreach($d->jadwal->where('aktif',true) as $j)
                        <span class="text-xs bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded">{{ ucfirst($j->hari) }}</span>
                        @endforeach
                    </div>
                </td>
                <td class="px-5 py-3 text-right">
                    <a href="{{ route('dokter.edit', $d) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Belum ada dokter</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
