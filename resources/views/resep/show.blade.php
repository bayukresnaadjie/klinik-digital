@extends('layouts.app')
@section('title','Detail Resep')
@section('subtitle', $resep->nomor_resep)
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <div class="flex justify-between items-center mb-3">
            <span class="font-mono text-sm text-blue-600 font-bold">{{ $resep->nomor_resep }}</span>
            <span class="text-xs px-2 py-0.5 rounded {{ $resep->status === 'selesai' ? 'bg-green-100 text-green-600' : ($resep->status === 'diproses' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-700') }}">
                {{ ucfirst($resep->status) }}
            </span>
        </div>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div><span class="text-xs text-gray-400 block">Pasien</span><span class="font-medium">{{ $resep->kunjungan->pasien->nama }}</span></div>
            <div><span class="text-xs text-gray-400 block">Dokter</span><span>{{ $resep->dokter->nama }}</span></div>
            <div><span class="text-xs text-gray-400 block">Tanggal</span><span>{{ $resep->created_at->format('d F Y H:i') }}</span></div>
        </div>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100"><tr>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Obat</th>
            <th class="text-center px-5 py-2.5 text-xs font-semibold text-gray-400">Jumlah</th>
            <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-400">Aturan Pakai</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($resep->details as $d)
            <tr>
                <td class="px-5 py-3 font-medium">{{ $d->obat->nama }}</td>
                <td class="px-5 py-3 text-center">{{ $d->jumlah }} {{ $d->obat->satuan }}</td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $d->aturan_pakai ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($resep->status !== 'selesai')
    <div class="px-6 py-4 border-t border-gray-100 flex gap-2">
        @if($resep->status === 'menunggu')
        <form action="{{ route('resep.proses', $resep) }}" method="POST" class="flex-1">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="diproses"/>
            <button class="w-full bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">Mulai Proses</button>
        </form>
        @endif
        @if($resep->status === 'diproses')
        <form action="{{ route('resep.proses', $resep) }}" method="POST" class="flex-1">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="selesai"/>
            <button class="w-full bg-green-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-green-700 transition">Tandai Selesai</button>
        </form>
        @endif
    </div>
    @endif
</div>
<div class="mt-4"><a href="{{ route('resep.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a></div>
</div>
@endsection
