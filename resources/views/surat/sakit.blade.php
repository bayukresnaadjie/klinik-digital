<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <title>Surat Keterangan Sakit</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Times New Roman',serif; font-size:12px; color:#111; }
        .kop { border-bottom:3px double #111; padding:12px 24px 10px; display:flex; align-items:center; gap:16px; }
        .kop-text .nama { font-size:18px; font-weight:bold; text-transform:uppercase; }
        .kop-text .alamat { font-size:10px; color:#444; margin-top:2px; }
        .body { padding:24px; }
        .judul { text-align:center; font-size:15px; font-weight:bold; text-decoration:underline; text-transform:uppercase; margin:16px 0 4px; }
        .nomor { text-align:center; font-size:11px; margin-bottom:16px; }
        .pengantar { margin-bottom:12px; line-height:1.7; }
        .data-table { width:100%; border-collapse:collapse; margin:12px 0; }
        .data-table td { padding:3px 6px; vertical-align:top; }
        .data-table td:first-child { width:35%; }
        .data-table td:nth-child(2) { width:5%; }
        .isi { line-height:1.8; margin:12px 0; }
        .catatan { background:#fffbeb; border:1px solid #f59e0b; padding:8px 12px; margin:12px 0; font-size:11px; }
        .ttd { margin-top:32px; display:flex; justify-content:flex-end; }
        .ttd-box { text-align:center; width:200px; }
        .ttd-space { height:60px; }
        .footer { border-top:1px solid #ccc; padding:8px 24px; text-align:center; font-size:9px; color:#888; margin-top:16px; }
    </style>
</head>
<body>
<div class="kop">
    <div style="font-size:40px">🏥</div>
    <div class="kop-text">
        <div class="nama">Klinik Digital</div>
        <div class="alamat">Jl. Kesehatan No. 1, Yogyakarta 55000</div>
        <div class="alamat">Telp: (0274) 000-0000 | Email: info@klinikdigital.id</div>
    </div>
</div>

<div class="body">
    <div class="judul">Surat Keterangan Sakit</div>
    <div class="nomor">No: SKS/{{ now()->format('Y/m') }}/{{ $kunjungan->id }}</div>

    <div class="pengantar">Yang bertanda tangan di bawah ini, dokter yang memeriksa pasien di Klinik Digital, menerangkan bahwa:</div>

    <table class="data-table">
        <tr><td>Nama</td><td>:</td><td><strong>{{ $kunjungan->pasien->nama }}</strong></td></tr>
        <tr><td>No. Rekam Medis</td><td>:</td><td>{{ $kunjungan->pasien->nomor_rm }}</td></tr>
        <tr><td>Tanggal Lahir</td><td>:</td><td>{{ $kunjungan->pasien->tanggal_lahir->format('d F Y') }} ({{ $kunjungan->pasien->umur }} tahun)</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $kunjungan->pasien->jenis_kelamin_label }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $kunjungan->pasien->alamat ?? '-' }}</td></tr>
    </table>

    <div class="isi">
        Berdasarkan pemeriksaan yang dilakukan pada tanggal <strong>{{ $kunjungan->tanggal->format('d F Y') }}</strong>,
        pasien tersebut di atas didiagnosa menderita:
        <br><br>
        <div style="text-align:center; font-size:14px; font-weight:bold; padding:8px; border:1px solid #ccc; background:#f9f9f9">
            {{ $kunjungan->rekamMedis->diagnosa }}
            @if($kunjungan->rekamMedis->kode_icd)
            <span style="font-size:11px; color:#666"> ({{ $kunjungan->rekamMedis->kode_icd }})</span>
            @endif
        </div>
        <br>
        dan dianjurkan untuk <strong>{{ str_replace('_', ' ', $kunjungan->rekamMedis->anjuran) }}</strong>
        @if($kunjungan->rekamMedis->tanggal_kontrol)
        dengan jadwal kontrol pada tanggal <strong>{{ $kunjungan->rekamMedis->tanggal_kontrol->format('d F Y') }}</strong>
        @endif
        .
    </div>

    @if($kunjungan->rekamMedis->catatan_dokter)
    <div class="catatan">
        <strong>Catatan:</strong> {{ $kunjungan->rekamMedis->catatan_dokter }}
    </div>
    @endif

    <div class="isi">
        Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <div class="ttd">
        <div class="ttd-box">
            <div>Yogyakarta, {{ now()->format('d F Y') }}</div>
            <div>Dokter Pemeriksa,</div>
            <div class="ttd-space"></div>
            <div style="font-weight:bold">{{ $kunjungan->dokter->nama }}</div>
            <div style="font-size:10px">{{ $kunjungan->dokter->spesialisasi }}</div>
            @if($kunjungan->dokter->sip)
            <div style="font-size:10px; color:#666">SIP: {{ $kunjungan->dokter->sip }}</div>
            @endif
        </div>
    </div>
</div>

<div class="footer">
    Klinik Digital · Jl. Kesehatan No. 1, Yogyakarta · Dokumen ini sah tanpa tanda tangan basah apabila dicetak dari sistem resmi klinik
</div>
</body>
</html>
