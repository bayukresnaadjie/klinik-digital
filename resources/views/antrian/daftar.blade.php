@extends('layouts.app')
@section('title','Daftar Pasien')
@section('subtitle','Registrasi kunjungan & ambil nomor antrian')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ route('antrian.store') }}" method="POST" class="space-y-5">
    @csrf
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pasien <span class="text-red-500">*</span></label>
        <select name="pasien_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Cari & Pilih Pasien --</option>
            @foreach($pasien as $p)
            <option value="{{ $p->id }}" {{ old('pasien_id') == $p->id ? 'selected':'' }}>
                {{ $p->nomor_rm }} — {{ $p->nama }} ({{ $p->umur }} th, {{ $p->jenis_kelamin_label }})
            </option>
            @endforeach
        </select>
        <div class="mt-1 flex gap-2">
            <a href="{{ route('pasien.create') }}" class="text-xs text-blue-600 hover:underline">+ Daftarkan pasien baru</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Poli <span class="text-red-500">*</span></label>
            <select name="poli_id" id="poli-select" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterDokter()">
                <option value="">-- Pilih Poli --</option>
                @foreach($poli as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dokter <span class="text-red-500">*</span></label>
            <select name="dokter_id" id="dokter-select" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">-- Pilih Poli dulu --</option>
                @foreach($dokter as $d)
                <option value="{{ $d->id }}" data-poli="{{ $d->poli_id }}">{{ $d->nama }} ({{ $d->spesialisasi }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kunjungan <span class="text-red-500">*</span></label>
            <select name="jenis_kunjungan" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="baru">Kunjungan Baru</option>
                <option value="lama">Kunjungan Lama</option>
                <option value="kontrol">Kontrol</option>
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan Utama</label>
        <textarea name="keluhan_utama" rows="3" placeholder="Tuliskan keluhan utama pasien..."
                  class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('keluhan_utama') }}</textarea>
    </div>

    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('antrian.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">Ambil Nomor Antrian</button>
    </div>
</form>
</div>
</div>

<script>
function filterDokter() {
    const poliId   = document.getElementById('poli-select').value;
    const options  = document.querySelectorAll('#dokter-select option');
    const select   = document.getElementById('dokter-select');
    select.value   = '';
    options.forEach(opt => {
        if (!opt.dataset.poli) return;
        opt.style.display = opt.dataset.poli === poliId ? '' : 'none';
    });
}
</script>
@endsection
