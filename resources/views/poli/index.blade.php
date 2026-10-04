@extends('layouts.app')
@section('title','Data Poli')
@section('header-action')
<a href="{{ route('poli.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">+ Tambah Poli</a>
@endsection
@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Kode</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nama Poli</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Lokasi</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Dokter</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Kunjungan Hari Ini</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($poli as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $p->kode }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $p->nama }}</td>
                <td class="px-5 py-3 text-gray-500 text-sm">Lantai {{ $p->lantai ?? '-' }} · Ruang {{ $p->nomor_ruang ?? '-' }}</td>
                <td class="px-5 py-3 text-center">{{ $p->dokter_count }}</td>
                <td class="px-5 py-3 text-center font-semibold text-blue-600">{{ $p->kunjungan_count }}</td>
                <td class="px-5 py-3 text-right">
                    <a href="{{ route('poli.edit', $p) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Belum ada poli</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
