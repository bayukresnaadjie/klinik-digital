<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <title>Kwitansi {{ $billing->nomor_billing }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; font-size:11px; color:#111; }
        .header { text-align:center; padding:16px; border-bottom:2px solid #2563eb; }
        .klinik-name { font-size:18px; font-weight:bold; color:#2563eb; }
        .klinik-sub  { font-size:10px; color:#888; margin-top:2px; }
        .body { padding:16px; }
        .title { text-align:center; font-size:14px; font-weight:bold; margin:12px 0 4px; }
        .nomor { text-align:center; font-size:10px; color:#666; margin-bottom:12px; font-family:monospace; }
        .info-table { width:100%; border-collapse:collapse; margin-bottom:12px; }
        .info-table td { padding:4px 6px; font-size:10px; }
        .info-table td:first-child { width:35%; color:#666; }
        .detail-table { width:100%; border-collapse:collapse; margin-bottom:12px; }
        .detail-table th { padding:6px 8px; background:#eff6ff; font-size:9px; font-weight:bold; text-align:left; border:1px solid #dbeafe; }
        .detail-table td { padding:6px 8px; font-size:10px; border:1px solid #e5e7eb; }
        .text-right { text-align:right; }
        .total-box { background:#eff6ff; border:1px solid #2563eb; padding:10px 14px; border-radius:6px; }
        .total-row { display:flex; justify-content:space-between; font-size:11px; margin-bottom:3px; }
        .total-final { display:flex; justify-content:space-between; font-size:14px; font-weight:bold; color:#2563eb; border-top:1px solid #2563eb; padding-top:6px; margin-top:4px; }
        .footer { text-align:center; margin-top:16px; font-size:9px; color:#aaa; border-top:1px solid #eee; padding-top:10px; }
        .status-lunas { display:inline-block; background:#d1fae5; color:#065f46; padding:2px 10px; border-radius:20px; font-size:10px; font-weight:bold; }
    </style>
</head>
<body>
<div class="header">
    <div class="klinik-name">🏥 Klinik Digital</div>
    <div class="klinik-sub">Jl. Kesehatan No. 1, Yogyakarta · Telp: (0274) 000-0000</div>
</div>
<div class="body">
    <div class="title">KWITANSI PEMBAYARAN</div>
    <div class="nomor">{{ $billing->nomor_billing }} &nbsp;|&nbsp; <span class="status-lunas">LUNAS</span></div>

    <table class="info-table">
        <tr><td>Nama Pasien</td><td>: <strong>{{ $billing->kunjungan->pasien->nama }}</strong></td></tr>
        <tr><td>No. Rekam Medis</td><td>: {{ $billing->kunjungan->pasien->nomor_rm }}</td></tr>
        <tr><td>No. Kunjungan</td><td>: {{ $billing->kunjungan->nomor_kunjungan }}</td></tr>
        <tr><td>Poli</td><td>: {{ $billing->kunjungan->poli->nama }}</td></tr>
        <tr><td>Dokter</td><td>: {{ $billing->kunjungan->dokter->nama }}</td></tr>
        <tr><td>Metode Bayar</td><td>: {{ ucfirst($billing->metode_bayar) }}</td></tr>
        <tr><td>Tanggal Bayar</td><td>: {{ $billing->bayar_at ? $billing->bayar_at->format('d F Y H:i') : now()->format('d F Y H:i') }}</td></tr>
    </table>

    <table class="detail-table">
        <thead><tr>
            <th>Keterangan</th>
            <th class="text-right">Jumlah</th>
        </tr></thead>
        <tbody>
            <tr><td>Biaya Konsultasi</td><td class="text-right">Rp {{ number_format($billing->biaya_konsultasi, 0, ',', '.') }}</td></tr>
            <tr><td>Biaya Obat</td><td class="text-right">Rp {{ number_format($billing->biaya_obat, 0, ',', '.') }}</td></tr>
            @if($billing->biaya_tindakan > 0)
            <tr><td>Biaya Tindakan</td><td class="text-right">Rp {{ number_format($billing->biaya_tindakan, 0, ',', '.') }}</td></tr>
            @endif
            @if($billing->diskon > 0)
            <tr><td>Diskon</td><td class="text-right" style="color:#dc2626">- Rp {{ number_format($billing->diskon, 0, ',', '.') }}</td></tr>
            @endif
        </tbody>
    </table>

    <div class="total-box">
        <div class="total-final"><span>TOTAL PEMBAYARAN</span><span>Rp {{ number_format($billing->total, 0, ',', '.') }}</span></div>
    </div>

    @if($billing->kunjungan->resep && $billing->kunjungan->resep->details->count() > 0)
    <div style="margin-top:12px">
        <div style="font-size:10px;font-weight:bold;color:#666;margin-bottom:4px">RINCIAN OBAT:</div>
        @foreach($billing->kunjungan->resep->details as $d)
        <div style="font-size:10px;padding:2px 0">{{ $d->obat->nama }} × {{ $d->jumlah }} — {{ $d->aturan_pakai }}</div>
        @endforeach
    </div>
    @endif
</div>
<div class="footer">
    Klinik Digital · Sistem Informasi Klinik · {{ now()->year }}<br>
    Dokumen ini dicetak otomatis dari sistem — Simpan sebagai bukti pembayaran
</div>
</body>
</html>
