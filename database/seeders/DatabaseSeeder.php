<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\RekamMedis;
use App\Models\Obat;
use App\Models\Resep;
use App\Models\DetailResep;
use App\Models\Billing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──
        $admin    = User::create(['name' => 'Admin Klinik',  'email' => 'admin@klinik.test',    'password' => Hash::make('password'), 'role' => 'admin']);
        $dokter1U = User::create(['name' => 'dr. Budi Santoso', 'email' => 'dokter@klinik.test', 'password' => Hash::make('password'), 'role' => 'dokter']);
        $dokter2U = User::create(['name' => 'dr. Siti Rahayu', 'email' => 'dokter2@klinik.test', 'password' => Hash::make('password'), 'role' => 'dokter']);
                    User::create(['name' => 'Perawat Ani',   'email' => 'perawat@klinik.test',   'password' => Hash::make('password'), 'role' => 'perawat']);
                    User::create(['name' => 'Apoteker Rini', 'email' => 'apoteker@klinik.test',  'password' => Hash::make('password'), 'role' => 'apoteker']);
                    User::create(['name' => 'Kasir Dedi',    'email' => 'kasir@klinik.test',     'password' => Hash::make('password'), 'role' => 'kasir']);

        // ── Poli ──
        $poliUmum  = Poli::create(['kode' => 'POL-01', 'nama' => 'Poli Umum',      'lantai' => '1', 'nomor_ruang' => '101']);
        $poliGigi  = Poli::create(['kode' => 'POL-02', 'nama' => 'Poli Gigi',      'lantai' => '1', 'nomor_ruang' => '102']);
        $poliAnak  = Poli::create(['kode' => 'POL-03', 'nama' => 'Poli Anak',      'lantai' => '2', 'nomor_ruang' => '201']);
        $poliKand  = Poli::create(['kode' => 'POL-04', 'nama' => 'Poli Kandungan', 'lantai' => '2', 'nomor_ruang' => '202']);

        // ── Dokter ──
        $dokter1 = Dokter::create(['user_id' => $dokter1U->id, 'poli_id' => $poliUmum->id, 'nama' => 'dr. Budi Santoso',    'spesialisasi' => 'Dokter Umum',         'sip' => 'SIP/001/2024', 'biaya_konsultasi' => 50000]);
        $dokter2 = Dokter::create(['user_id' => $dokter2U->id, 'poli_id' => $poliAnak->id, 'nama' => 'dr. Siti Rahayu',     'spesialisasi' => 'Dokter Spesialis Anak','sip' => 'SIP/002/2024', 'biaya_konsultasi' => 150000]);
        $dokter3 = Dokter::create([                            'poli_id' => $poliGigi->id, 'nama' => 'drg. Ahmad Fauzi',    'spesialisasi' => 'Dokter Gigi',         'sip' => 'SIP/003/2024', 'biaya_konsultasi' => 100000]);
        $dokter4 = Dokter::create([                            'poli_id' => $poliKand->id, 'nama' => 'dr. Maya Kusuma, SpOG','spesialisasi' => 'Obstetri & Ginekologi','sip' => 'SIP/004/2024','biaya_konsultasi' => 200000]);

        // ── Jadwal Dokter ──
        $hariKerja = ['senin','selasa','rabu','kamis','jumat'];
        foreach ($hariKerja as $hari) {
            JadwalDokter::create(['dokter_id' => $dokter1->id, 'hari' => $hari, 'jam_mulai' => '08:00', 'jam_selesai' => '14:00']);
            JadwalDokter::create(['dokter_id' => $dokter2->id, 'hari' => $hari, 'jam_mulai' => '09:00', 'jam_selesai' => '15:00']);
        }
        JadwalDokter::create(['dokter_id' => $dokter3->id, 'hari' => 'senin',  'jam_mulai' => '10:00', 'jam_selesai' => '16:00']);
        JadwalDokter::create(['dokter_id' => $dokter3->id, 'hari' => 'rabu',   'jam_mulai' => '10:00', 'jam_selesai' => '16:00']);
        JadwalDokter::create(['dokter_id' => $dokter3->id, 'hari' => 'jumat',  'jam_mulai' => '10:00', 'jam_selesai' => '14:00']);
        JadwalDokter::create(['dokter_id' => $dokter4->id, 'hari' => 'selasa', 'jam_mulai' => '08:00', 'jam_selesai' => '12:00']);
        JadwalDokter::create(['dokter_id' => $dokter4->id, 'hari' => 'kamis',  'jam_mulai' => '08:00', 'jam_selesai' => '12:00']);
        JadwalDokter::create(['dokter_id' => $dokter4->id, 'hari' => 'sabtu',  'jam_mulai' => '09:00', 'jam_selesai' => '13:00']);

        // ── Obat ──
        $obatData = [
            ['nama' => 'Paracetamol 500mg',   'kategori' => 'Analgesik',    'satuan' => 'tablet', 'harga' => 500,   'stok' => 500],
            ['nama' => 'Amoxicillin 500mg',   'kategori' => 'Antibiotik',   'satuan' => 'kapsul', 'harga' => 2000,  'stok' => 200],
            ['nama' => 'Ibuprofen 400mg',     'kategori' => 'Analgesik',    'satuan' => 'tablet', 'harga' => 1000,  'stok' => 300],
            ['nama' => 'Antasida Tablet',     'kategori' => 'Antasida',     'satuan' => 'tablet', 'harga' => 300,   'stok' => 400],
            ['nama' => 'Vitamin C 500mg',     'kategori' => 'Vitamin',      'satuan' => 'tablet', 'harga' => 1500,  'stok' => 600],
            ['nama' => 'ORS / Oralit',        'kategori' => 'Rehidrasi',    'satuan' => 'sachet', 'harga' => 2000,  'stok' => 150],
            ['nama' => 'Cetirizine 10mg',     'kategori' => 'Antihistamin', 'satuan' => 'tablet', 'harga' => 3000,  'stok' => 100],
            ['nama' => 'Omeprazole 20mg',     'kategori' => 'Antasida',     'satuan' => 'kapsul', 'harga' => 4000,  'stok' => 200],
            ['nama' => 'Metformin 500mg',     'kategori' => 'Antidiabetik', 'satuan' => 'tablet', 'harga' => 2500,  'stok' => 8],
            ['nama' => 'Amlodipine 5mg',      'kategori' => 'Antihipertensi','satuan'=> 'tablet', 'harga' => 5000,  'stok' => 150],
            ['nama' => 'Salbutamol Inhaler',  'kategori' => 'Bronkodilator','satuan' => 'pcs',    'harga' => 45000, 'stok' => 30],
            ['nama' => 'Betadine Solution',   'kategori' => 'Antiseptik',   'satuan' => 'botol',  'harga' => 25000, 'stok' => 50],
        ];

        foreach ($obatData as $o) {
            Obat::create(array_merge($o, ['stok_minimum' => 10, 'aktif' => true]));
        }

        // ── Pasien Dummy ──
        $pasienData = [
            ['nama' => 'Ahmad Zainal',     'nik' => '3401010101900001', 'jenis_kelamin' => 'L', 'tgl_lahir' => '1990-01-01', 'telepon' => '081234567890', 'jenis_bayar' => 'umum'],
            ['nama' => 'Siti Nurhaliza',   'nik' => '3401010202950002', 'jenis_kelamin' => 'P', 'tgl_lahir' => '1995-02-02', 'telepon' => '081234567891', 'jenis_bayar' => 'bpjs', 'no_bpjs' => '0001234567890'],
            ['nama' => 'Budi Prakoso',     'nik' => '3401010303850003', 'jenis_kelamin' => 'L', 'tgl_lahir' => '1985-03-03', 'telepon' => '081234567892', 'jenis_bayar' => 'umum'],
            ['nama' => 'Dewi Lestari',     'nik' => '3401010404920004', 'jenis_kelamin' => 'P', 'tgl_lahir' => '1992-04-04', 'telepon' => '081234567893', 'jenis_bayar' => 'bpjs', 'no_bpjs' => '0001234567891'],
            ['nama' => 'Rizky Pratama',    'nik' => '3401010505980005', 'jenis_kelamin' => 'L', 'tgl_lahir' => '1998-05-05', 'telepon' => '081234567894', 'jenis_bayar' => 'umum'],
            ['nama' => 'Nur Aini',         'nik' => '3401010606870006', 'jenis_kelamin' => 'P', 'tgl_lahir' => '1987-06-06', 'telepon' => '081234567895', 'jenis_bayar' => 'umum'],
            ['nama' => 'Hendra Gunawan',   'nik' => '3401010707750007', 'jenis_kelamin' => 'L', 'tgl_lahir' => '1975-07-07', 'telepon' => '081234567896', 'jenis_bayar' => 'bpjs', 'no_bpjs' => '0001234567892'],
            ['nama' => 'Rina Wati',        'nik' => '3401010808000008', 'jenis_kelamin' => 'P', 'tgl_lahir' => '2000-08-08', 'telepon' => '081234567897', 'jenis_bayar' => 'umum'],
        ];

        $pasienObjs = [];
        foreach ($pasienData as $p) {
            $pasienObjs[] = Pasien::create([
                'nama'           => $p['nama'],
                'nik'            => $p['nik'],
                'jenis_kelamin'  => $p['jenis_kelamin'],
                'tanggal_lahir'  => $p['tgl_lahir'],
                'telepon'        => $p['telepon'],
                'jenis_bayar'    => $p['jenis_bayar'],
                'no_bpjs'        => $p['no_bpjs'] ?? null,
                'alamat'         => 'Jl. Contoh No. ' . rand(1,100) . ', Yogyakarta',
            ]);
        }

        // ── Kunjungan Hari Ini (antrian aktif) ──
        $paracetamol = Obat::where('nama', 'like', 'Paracetamol%')->first();
        $amoxicillin = Obat::where('nama', 'like', 'Amoxicillin%')->first();
        $vitaminC    = Obat::where('nama', 'like', 'Vitamin C%')->first();

        $kunjunganData = [
            ['pasien' => $pasienObjs[0], 'dokter' => $dokter1, 'poli' => $poliUmum, 'status' => 'selesai',   'keluhan' => 'Demam tinggi dan sakit kepala sejak 2 hari'],
            ['pasien' => $pasienObjs[1], 'dokter' => $dokter1, 'poli' => $poliUmum, 'status' => 'diperiksa', 'keluhan' => 'Batuk pilek sudah 3 hari tidak sembuh'],
            ['pasien' => $pasienObjs[2], 'dokter' => $dokter1, 'poli' => $poliUmum, 'status' => 'dipanggil', 'keluhan' => 'Nyeri perut bagian bawah'],
            ['pasien' => $pasienObjs[3], 'dokter' => $dokter2, 'poli' => $poliAnak, 'status' => 'menunggu',  'keluhan' => 'Anak demam dan tidak mau makan'],
            ['pasien' => $pasienObjs[4], 'dokter' => $dokter1, 'poli' => $poliUmum, 'status' => 'menunggu',  'keluhan' => 'Kontrol tekanan darah'],
            ['pasien' => $pasienObjs[5], 'dokter' => $dokter2, 'poli' => $poliAnak, 'status' => 'menunggu',  'keluhan' => 'Imunisasi rutin anak'],
        ];

        foreach ($kunjunganData as $kd) {
            $k = Kunjungan::create([
                'pasien_id'      => $kd['pasien']->id,
                'poli_id'        => $kd['poli']->id,
                'dokter_id'      => $kd['dokter']->id,
                'user_id'        => $admin->id,
                'tanggal'        => today(),
                'status'         => $kd['status'],
                'jenis_kunjungan'=> 'baru',
                'keluhan_utama'  => $kd['keluhan'],
            ]);

            // Buat rekam medis untuk yang sudah diperiksa/selesai
            if (in_array($kd['status'], ['diperiksa','selesai'])) {
                RekamMedis::create([
                    'kunjungan_id'    => $k->id,
                    'dokter_id'       => $kd['dokter']->id,
                    'tekanan_darah'   => '120/80',
                    'suhu'            => 37.5,
                    'nadi'            => 88,
                    'respirasi'       => 20,
                    'berat_badan'     => 65,
                    'tinggi_badan'    => 165,
                    'keluhan'         => $kd['keluhan'],
                    'diagnosa'        => 'Infeksi Saluran Pernapasan Atas (ISPA)',
                    'kode_icd'        => 'J06.9',
                    'tindakan'        => 'Pemeriksaan fisik, pemberian resep',
                    'catatan_dokter'  => 'Istirahat yang cukup, minum air putih banyak',
                    'anjuran'         => 'rawat_jalan',
                ]);
            }

            // Buat resep untuk yang selesai
            if ($kd['status'] === 'selesai') {
                $resep = Resep::create([
                    'kunjungan_id' => $k->id,
                    'dokter_id'    => $kd['dokter']->id,
                    'status'       => 'selesai',
                ]);
                DetailResep::create(['resep_id' => $resep->id, 'obat_id' => $paracetamol->id, 'jumlah' => 10, 'aturan_pakai' => '3x1 sesudah makan']);
                DetailResep::create(['resep_id' => $resep->id, 'obat_id' => $vitaminC->id,    'jumlah' => 10, 'aturan_pakai' => '1x1 sesudah makan']);

                // Billing lunas
                $biayaObat = ($paracetamol->harga * 10) + ($vitaminC->harga * 10);
                Billing::create([
                    'kunjungan_id'      => $k->id,
                    'biaya_konsultasi'  => $kd['dokter']->biaya_konsultasi,
                    'biaya_obat'        => $biayaObat,
                    'biaya_tindakan'    => 0,
                    'diskon'            => 0,
                    'total'             => $kd['dokter']->biaya_konsultasi + $biayaObat,
                    'status'            => 'lunas',
                    'metode_bayar'      => 'tunai',
                    'bayar_at'          => now(),
                ]);
            }
        }
    }
}
