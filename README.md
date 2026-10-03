# 🏥 Sistem Informasi Klinik (SIK)

Aplikasi manajemen klinik lengkap dengan rekam medis elektronik, antrian digital, resep obat, dan billing. Dibangun dengan Laravel 11.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-005C84?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## ✨ Fitur Utama

- 👤 **Manajemen Pasien** — Registrasi, nomor rekam medis otomatis (RM-YYYYMMDD-XXXX)
- 📋 **Antrian Digital** — Nomor antrian per poli, status real-time
- 🏥 **Poli & Dokter** — Manajemen poli, jadwal dokter per hari
- 🩺 **Rekam Medis** — Keluhan, diagnosa, vital sign, catatan dokter
- 💊 **Apotek & Resep** — Stok obat, tulis resep, dispensing
- 💰 **Billing** — Biaya konsultasi + obat, kwitansi PDF
- 📄 **Surat Keterangan Sakit** — PDF otomatis dengan kop klinik
- 📊 **Laporan** — Kunjungan harian, statistik, pendapatan
- 👥 **Multi-Role** — Admin, Dokter, Perawat, Apoteker, Kasir

---

## 🏗️ Alur Kerja

```
Pasien Datang
    ↓
Registrasi & Ambil Antrian (Admin/Perawat)
    ↓
Tunggu Antrian Dipanggil
    ↓
Pemeriksaan Dokter → Rekam Medis + Resep
    ↓
Ambil Obat di Apotek (Apoteker)
    ↓
Pembayaran di Kasir → Kwitansi PDF
    ↓
Surat Keterangan Sakit (jika perlu)
```

---

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **PHP:** 8.3
- **Database:** MySQL 8
- **PDF:** barryvdh/laravel-dompdf
- **Frontend:** Blade + Tailwind CSS (CDN)
- **Auth:** Laravel Breeze

---

## ⚙️ Instalasi

```bash
git clone https://github.com/bayukresnaadjie/klinik-digital.git
cd klinik-digital
composer install
cp .env.example .env
php artisan key:generate
# Edit .env: DB_DATABASE=klinik_digital
php artisan migrate --seed
php artisan serve
```

---

## 👥 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@klinik.test | password |
| Dokter | dokter@klinik.test | password |
| Perawat | perawat@klinik.test | password |
| Apoteker | apoteker@klinik.test | password |
| Kasir | kasir@klinik.test | password |

---

## 📄 Lisensi

[MIT](LICENSE)

---

<div align="center">
Dibuat oleh <a href="https://github.com/bayukresnaadjie">Bayu Kresna Adjie</a>
</div>
