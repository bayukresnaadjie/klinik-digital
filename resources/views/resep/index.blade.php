@extends('layouts.app')
@section('title','Apotek & Resep')
@section('subtitle','Daftar resep yang perlu diproses')
@section('content')

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200"><tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Nomor Resep</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Pasien</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Dokter</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400">Tanggal</th>
            <th class="text-center px-5 py-3 text-xs font-semibold text-gray-400">Status</th>
            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-400">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($resep as $r)
            <tr class="hover:bg-gray-50 {{ $r->status === 'menunggu' ? 'bg-yellow-50' : '' }}">
                <td class="px-5 py-3 font-mono text-xs text-blue-600 font-semibold">{{ $r->nomor_resep }}</td>
                <td class="px-5 py-3 font-medium text-gray-900">{{ $r->kunjungan->pasien->nama ?? '-' }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $r->dokter->nama ?? '-' }}</td>
                <td class="px-5 py-3 text-xs text-gray-400">{{ $r->created_at->format('d M Y H:i') }}</td>
                <td class="px-5 py-3 text-center">
                    <span class="text-xs font-medium px-2 py-0.5 rounded
                        {{ $r->status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : ($r->status === 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                        {{ ucfirst($r->status) }}
                    </span>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="flex justify-end gap-1">
                        <a href="{{ route('resep.show', $r) }}" class="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-lg">Detail</a>
                        @if($r->status === 'menunggu')
                        <form action="{{ route('resep.proses', $r) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="diproses"/>
                            <button class="text-xs text-orange-600 bg-orange-50 hover:bg-orange-100 px-2.5 py-1 rounded-lg">Proses</button>
                        </form>
                        @endif
                        @if($r->status === 'diproses')
                        <form action="{{ route('resep.proses', $r) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="selesai"/>
                            <button class="text-xs text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg">Selesai</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-400">Tidak ada resep</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($resep->hasPages())
    <div class="px-5 py-3 border-t border-gray-100">{{ $resep->links() }}</div>
    @endif
</div>
@endsection
