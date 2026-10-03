@extends('layouts.app')
@section('title','Buat Resep Obat')
@section('subtitle', $kunjungan->pasien->nama . ' · ' . $kunjungan->nomor_kunjungan)
@section('content')
<div class="max-w-2xl">

@if($kunjungan->rekamMedis)
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
    <div class="text-xs font-semibold text-blue-700 mb-1">Diagnosa:</div>
    <div class="text-sm text-blue-900">{{ $kunjungan->rekamMedis->diagnosa }}</div>
</div>
@endif

<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ route('resep.store', $kunjungan) }}" method="POST" class="space-y-5">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Obat <span class="text-red-500">*</span></label>
        <div id="obat-items" class="space-y-3">
            <div class="obat-row flex gap-2 items-start">
                <select name="items[0][obat_id]" required class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obat as $o)
                    <option value="{{ $o->id }}">{{ $o->nama }} (Stok: {{ $o->stok }} {{ $o->satuan }}) — Rp {{ number_format($o->harga, 0, ',', '.') }}</option>
                    @endforeach
                </select>
                <input type="number" name="items[0][jumlah]" placeholder="Qty" min="1" required class="w-20 border border-gray-200 rounded-lg px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                <input type="text" name="items[0][aturan_pakai]" placeholder="3x1 sesudah makan" class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                <button type="button" onclick="hapusObat(this)" class="text-red-400 hover:text-red-600 mt-2">✕</button>
            </div>
        </div>
        <button type="button" onclick="tambahObat()" class="mt-2 text-sm text-blue-600 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Obat
        </button>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Apotek</label>
        <textarea name="catatan" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
    </div>

    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('antrian.show', $kunjungan) }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-orange-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-orange-700 transition">Kirim ke Apotek</button>
    </div>
</form>
</div>
</div>

<script>
let idx = 1;
const obatOptions = `@foreach($obat as $o)<option value="{{ $o->id }}">{{ $o->nama }} (Stok: {{ $o->stok }}) — Rp {{ number_format($o->harga, 0, ',', '.') }}</option>@endforeach`;

function tambahObat() {
    const div = document.createElement('div');
    div.className = 'obat-row flex gap-2 items-start';
    div.innerHTML = `
        <select name="items[${idx}][obat_id]" required class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><option value="">-- Pilih Obat --</option>${obatOptions}</select>
        <input type="number" name="items[${idx}][jumlah]" placeholder="Qty" min="1" required class="w-20 border border-gray-200 rounded-lg px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <input type="text" name="items[${idx}][aturan_pakai]" placeholder="3x1 sesudah makan" class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        <button type="button" onclick="hapusObat(this)" class="text-red-400 hover:text-red-600 mt-2">✕</button>`;
    document.getElementById('obat-items').appendChild(div);
    idx++;
}

function hapusObat(btn) {
    const rows = document.querySelectorAll('.obat-row');
    if (rows.length <= 1) return alert('Minimal 1 obat.');
    btn.closest('.obat-row').remove();
}
</script>
@endsection
