@extends('layouts.app')
@section('title','Data Pasien')
@section('header-action')
<a href="{{ route('pasien.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Daftar Pasien Baru
</a>
@endsection
@section('content')

<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <div class="flex gap-3 items-end">
        <div class="flex-1">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, No. RM, NIK, atau telepon..."
                       class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
        </div>
        <select name="jenis_bayar" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Jenis Bayar</option>
            <option value="umum"     {{ request('jenis_bayar')==='umum'     ? 'selected':'' }}>Umum</option>
            <option value="bpjs"     {{ request('jenis_bayar')==='bpjs'     ? 'selected':'' }}>BPJS</option>
            <option value="asuransi" {{ request('jenis_bayar')==='asuransi' ? 'selected':'' }}>Asuransi</option>
        </select>
        <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition">Cari</button>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">No. RM</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nama Pasien</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Umur / JK</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Telepon</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Jenis Bayar</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pasien as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-blue-600 font-semibold">{{ $p->nomor_rm }}</td>
                <td class="px-5 py-3">
                    <div class="font-medium text-gray-900">{{ $p->nama }}</div>
                    @if($p->nik)<div class="text-xs text-gray-400 font-mono">NIK: {{ $p->nik }}</div>@endif
                </td>
                <td class="px-5 py-3 text-gray-600">{{ $p->umur }} th · {{ $p->jenis_kelamin_label }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $p->telepon ?? '-' }}</td>
                <td class="px-5 py-3">
                    <span class="text-xs font-medium px-2 py-0.5 rounded uppercase
                        {{ $p->jenis_bayar === 'bpjs' ? 'bg-green-100 text-green-700' : ($p->jenis_bayar === 'asuransi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ $p->jenis_bayar }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex justify-end gap-1">
                        <a href="{{ route('pasien.show', $p) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Detail</a>
                        <a href="{{ route('antrian.daftar') }}?pasien_id={{ $p->id }}" class="text-xs text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded-lg">Daftarkan</a>
                        <a href="{{ route('pasien.edit', $p) }}" class="text-xs text-gray-600 bg-gray-100 hover:bg-gray-200 px-2.5 py-1 rounded-lg">Edit</a>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Belum ada data pasien</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($pasien->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">{{ $pasien->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
