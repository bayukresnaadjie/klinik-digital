@extends('layouts.app')
@section('title','Proses Pembayaran')
@section('subtitle', $kunjungan->pasien->nama . ' · ' . $kunjungan->nomor_kunjungan)
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ route('billing.store', $kunjungan) }}" method="POST" class="space-y-4">
    @csrf

    <div class="bg-gray-50 rounded-lg p-4 text-sm">
        <div class="font-semibold text-gray-900 mb-2">{{ $kunjungan->pasien->nama }}</div>
        <div class="text-xs text-gray-400">{{ $kunjungan->poli->nama }} · {{ $kunjungan->dokter->nama }}</div>
        <div class="text-xs text-gray-400">{{ $kunjungan->nomor_kunjungan }} · {{ $kunjungan->tanggal->format('d F Y') }}</div>
    </div>

    <div class="space-y-3">
        <div class="flex justify-between items-center">
            <label class="text-sm text-gray-700">Biaya Konsultasi</label>
            <input type="number" name="biaya_konsultasi" value="{{ $kunjungan->dokter->biaya_konsultasi }}" required min="0"
                   class="w-40 border border-gray-200 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div class="flex justify-between items-center">
            <label class="text-sm text-gray-700">Biaya Obat</label>
            <input type="number" name="biaya_obat" value="{{ $biayaObat }}" required min="0"
                   class="w-40 border border-gray-200 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div class="flex justify-between items-center">
            <label class="text-sm text-gray-700">Biaya Tindakan</label>
            <input type="number" name="biaya_tindakan" value="0" min="0"
                   class="w-40 border border-gray-200 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div class="flex justify-between items-center">
            <label class="text-sm text-gray-700">Diskon</label>
            <input type="number" name="diskon" value="0" min="0"
                   class="w-40 border border-gray-200 rounded-lg px-3 py-2 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <div class="border-t pt-3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran <span class="text-red-500">*</span></label>
            <select name="metode_bayar" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="tunai">Tunai / Cash</option>
                <option value="bpjs">BPJS Kesehatan</option>
                <option value="transfer">Transfer Bank</option>
                <option value="kartu">Kartu Debit/Kredit</option>
            </select>
        </div>
    </div>

    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('antrian.show', $kunjungan) }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-emerald-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-emerald-700 transition">✓ Konfirmasi Pembayaran</button>
    </div>
</form>
</div>
</div>
@endsection
