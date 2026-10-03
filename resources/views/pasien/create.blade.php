@extends('layouts.app')
@section('title', isset($pasien) ? 'Edit Data Pasien' : 'Daftar Pasien Baru')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl border border-gray-200 p-6">
<form action="{{ isset($pasien) ? route('pasien.update', $pasien) : route('pasien.store') }}" method="POST" class="space-y-5">
    @csrf @if(isset($pasien)) @method('PUT') @endif

    <div>
        <h3 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b">Data Pribadi</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $pasien->nama ?? '') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $pasien->nik ?? '') }}" maxlength="16" placeholder="16 digit"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') === 'L' ? 'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin ?? '') === 'P' ? 'selected':'' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($pasien) ? $pasien->tanggal_lahir->format('Y-m-d') : '') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Golongan Darah</label>
                <select name="golongan_darah" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Tidak Diketahui --</option>
                    @foreach(['A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-'] as $gb)
                    <option value="{{ $gb }}" {{ old('golongan_darah', $pasien->golongan_darah ?? '') === $gb ? 'selected':'' }}>{{ $gb }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $pasien->pekerjaan ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $pasien->telepon ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $pasien->email ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-sm font-semibold text-gray-900 mb-3 pb-2 border-b">Informasi Pembayaran & Keluarga</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Pembayaran <span class="text-red-500">*</span></label>
                <select name="jenis_bayar" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="umum"     {{ old('jenis_bayar', $pasien->jenis_bayar ?? '') === 'umum'     ? 'selected':'' }}>Umum</option>
                    <option value="bpjs"     {{ old('jenis_bayar', $pasien->jenis_bayar ?? '') === 'bpjs'     ? 'selected':'' }}>BPJS</option>
                    <option value="asuransi" {{ old('jenis_bayar', $pasien->jenis_bayar ?? '') === 'asuransi' ? 'selected':'' }}>Asuransi</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">No. BPJS</label>
                <input type="text" name="no_bpjs" value="{{ old('no_bpjs', $pasien->no_bpjs ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Keluarga/Wali</label>
                <input type="text" name="nama_keluarga" value="{{ old('nama_keluarga', $pasien->nama_keluarga ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Telepon Keluarga</label>
                <input type="text" name="telepon_keluarga" value="{{ old('telepon_keluarga', $pasien->telepon_keluarga ?? '') }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1">Alergi</label>
                <input type="text" name="alergi" value="{{ old('alergi', $pasien->alergi ?? '') }}" placeholder="Contoh: Penisilin, Seafood (kosongkan jika tidak ada)"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>
        </div>
    </div>

    <div class="flex gap-3 pt-2 border-t border-gray-100">
        <a href="{{ route('pasien.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg hover:bg-blue-700 transition">
            {{ isset($pasien) ? 'Simpan Perubahan' : 'Daftarkan Pasien' }}
        </button>
    </div>
</form>
</div>
</div>
@endsection
