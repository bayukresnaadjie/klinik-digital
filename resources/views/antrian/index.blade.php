@extends('layouts.app')
@section('title','Antrian & Kunjungan')
@section('header-action')
<a href="{{ route('antrian.daftar') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Daftar Pasien
</a>
@endsection
@section('content')

{{-- Stats --}}
<div class="grid grid-cols-4 gap-3 mb-4">
    @foreach(['menunggu'=>['Menunggu','yellow'],'diproses'=>['Diproses','blue'],'selesai'=>['Selesai','green'],'batal'=>['Batal','red']] as $key => [$label,$color])
    <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
        <div class="text-2xl font-bold text-{{ $color }}-600">{{ $stats[$key] }}</div>
        <div class="text-xs text-gray-500 mt-1">{{ $label }}</div>
    </div>
    @endforeach
</div>

{{-- Filter --}}
<form method="GET" class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <div class="flex gap-3 items-end">
        <div><label class="block text-xs text-gray-500 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/></div>
        <div><label class="block text-xs text-gray-500 mb-1">Poli</label>
            <select name="poli_id" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Poli</option>
                @foreach($poli as $p)
                <option value="{{ $p->id }}" {{ $poliId == $p->id ? 'selected':'' }}>{{ $p->nama }}</option>
                @endforeach
            </select></div>
        <button type="submit" class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition">Filter</button>
    </div>
</form>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">No</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Pasien</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Poli / Dokter</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Keluhan</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Status</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Rekam Medis</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($kunjungan as $k)
            <tr class="hover:bg-gray-50 {{ $k->status === 'dipanggil' ? 'bg-blue-50' : '' }}">
                <td class="px-5 py-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="font-bold text-blue-700 text-sm">{{ $k->nomor_antrian }}</span>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <div class="font-medium text-gray-900">{{ $k->pasien->nama }}</div>
                    <div class="text-xs text-gray-400 font-mono">{{ $k->pasien->nomor_rm }}</div>
                </td>
                <td class="px-5 py-3">
                    <div class="text-sm text-gray-700">{{ $k->poli->nama }}</div>
                    <div class="text-xs text-gray-400">{{ $k->dokter->nama }}</div>
                </td>
                <td class="px-5 py-3 text-xs text-gray-500 max-w-xs truncate">{{ $k->keluhan_utama ?? '-' }}</td>
                <td class="px-5 py-3 text-center">
                    <form action="{{ route('antrian.status', $k) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-lg px-2 py-1 focus:outline-none">
                            @foreach(['menunggu','dipanggil','diperiksa','selesai','batal'] as $s)
                            <option value="{{ $s }}" {{ $k->status === $s ? 'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td class="px-5 py-3 text-center">
                    @if($k->rekamMedis)
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded">✓ Ada</span>
                    @else
                        <span class="text-xs text-gray-400">Belum</span>
                    @endif
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex justify-end gap-1">
                        <a href="{{ route('antrian.show', $k) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Detail</a>
                        @if(!$k->rekamMedis && in_array($k->status, ['dipanggil','diperiksa']))
                        <a href="{{ route('rekam-medis.create', $k) }}" class="text-xs text-purple-600 bg-purple-50 hover:bg-purple-100 px-2.5 py-1 rounded-lg">Periksa</a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-5 py-12 text-center text-sm text-gray-400">Tidak ada kunjungan untuk tanggal ini</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
