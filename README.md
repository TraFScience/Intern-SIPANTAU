# SIPANTAU — Sistem Informasi Peta Analisis & Navigasi Teritorial Alam Utama

Platform **Web-GIS** informasi peta bencana untuk wilayah Kalimantan Selatan. SIPANTAU menampilkan data bencana utama — banjir, kebakaran hutan dan lahan (karhutla), angin puting beliung, dan tanah longsor — dalam bentuk visualisasi interaktif yang mudah diakses oleh masyarakat dan petugas.

---

## Daftar Isi

- [Ringkasan Proyek](#ringkasan-proyek)
- [Latar Belakang & Tujuan](#latar-belakang--tujuan)
- [Anggota Kelompok](#anggota-kelompok)
- [Fitur](#fitur)
- [Peran & Hak Akses](#peran--hak-akses)
- [Alur Kerja (Workflow)](#alur-kerja-workflow)
- [Teknologi](#teknologi)
- [Instalasi & Menjalankan Proyek](#instalasi--menjalankan-proyek)
- [Target Hasil Akhir](#target-hasil-akhir)
- [Catatan Penting](#catatan-penting)

---

## Ringkasan Proyek

SIPANTAU merupakan proyek pengembangan website berbasis **Web-GIS** yang berfungsi sebagai platform informasi peta bencana untuk wilayah Kalimantan Selatan. Proyek ini menampilkan data bencana utama di provinsi tersebut, seperti banjir, karhutla, angin puting beliung, dan tanah longsor, dalam bentuk visualisasi interaktif yang mudah diakses oleh masyarakat dan petugas.

Proyek ini merupakan simulasi pengembangan sistem yang terinspirasi dari sistem informasi kebencanaan riil seperti SiMantab, Ingat Si Anang, dan platform WebGIS lainnya.

---

## Latar Belakang & Tujuan

Kalimantan Selatan merupakan salah satu provinsi di Indonesia yang memiliki tingkat kerawanan bencana yang tinggi. Jenis bencana yang dominan adalah banjir, karhutla, dan puting beliung. Kejadian banjir pada tahun 2023 saja tercatat merendam 39.484 rumah di Kabupaten Banjar. Karhutla juga menjadi ancaman serius, terutama di lahan gambut dan area persawahan.

Meskipun telah ada platform seperti Ingat Si Anang milik BPBD yang menyediakan informasi peringatan dini, proyek pengembangan website mandiri ini bertujuan untuk:

- Memberikan pengalaman langsung dalam membangun sistem informasi kebencanaan.
- Mengintegrasikan data spasial dari berbagai sumber ke dalam satu platform.
- Meningkatkan keterampilan teknis peserta magang dalam bidang Web-GIS dan pengembangan sistem.

---

## Anggota Kelompok

1. alifariz
2. nabil
3. alya
4. Ira

---

## Fitur

- **Peta Bencana Interaktif (Web-GIS):** menampilkan titik lokasi kejadian bencana pada peta digital menggunakan Leaflet JS, termasuk detail lokasi dan status verifikasi.
- **Statistik Bencana:** grafik dan ringkasan tren kejadian bencana per tahun dan per jenis bencana menggunakan Chart.js.
- **Wilayah Rawan Bencana:** peta kerawanan dengan visualisasi area (polygon) yang berpotensi terkena bencana tertentu.
- **Berita Terkini:** halaman berita/artikel seputar kebencanaan yang dikelola oleh admin/petugas.
- **Lapor Kejadian Bencana:** form pelaporan kejadian bencana (jenis, lokasi, koordinat, korban, dan gambar) untuk masyarakat dan petugas.
- **Verifikasi Laporan:** alur verifikasi laporan kejadian (menunggu/terverifikasi/ditolak) oleh petugas/admin.
- **Profil Pengguna:** halaman profil beserta riwayat laporan pengguna.
- **Panel Admin:** pengelolaan data bencana, berita, dan akun pengguna.

---

## Peran & Hak Akses

Sistem menggunakan **Spatie Laravel-Permission** untuk mengelola peran (role) dan izin (permission).

### Role

| Role        | Deskripsi                                                                  |
|-------------|----------------------------------------------------------------------------|
| `admin`     | Akses penuh ke semua menu, manajemen pengguna, dan panel admin.            |
| `petugas`   | Mengelola entri bencana, verifikasi laporan, berita, dan wilayah rawan.    |
| `masyarakat`| Melaporkan kejadian bencana dan melihat informasi publik.                   |

### Permission

- `kelola-pengguna`
- `kelola-berita`
- `kelola-bencana`
- `verifikasi-bencana`
- `lapor-bencana`
- `kelola-wilayah`
- `kelola-jenis-bencana`
- `kelola-wilayah-rawan`

Pemetaan permission per role:

- **admin** — semua permission.
- **petugas** — `kelola-bencana`, `verifikasi-bencana`, `lapor-bencana`, `kelola-berita`, `kelola-wilayah-rawan`.
- **masyarakat** — `lapor-bencana`.

---

## Alur Kerja (Workflow)

Alur kerja sistem disesuaikan dengan peran pengguna (*User Role*):

- **Admin:** memiliki akses penuh untuk mengelola data kejadian (tambah, edit, hapus), mengelola berita, dan mengelola akun pengguna.
- **Petugas Lapangan:** dapat menginput data kejadian dari lapangan dan memverifikasi laporan masyarakat.
- **Masyarakat/Pengguna Umum:** dapat melihat peta, titik-titik bencana, membaca berita/informasi, serta melaporkan kejadian bencana.

**Alur Data:**

`Input Data Bencana (oleh Masyarakat/Petugas)` → `Verifikasi (oleh Petugas/Admin)` → `Penyimpanan di Database` → `Tampilan Peta (Visualisasi titik/polygon di WebGIS)` → `Informasi kepada Publik (Dashboard dan Berita)`

---

## Teknologi

- **Framework:** Laravel 12
- **Bahasa:** PHP 8.2+
- **Database:** MySQL
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Vite
- **Peta (Web-GIS):** Leaflet JS 1.9.4
- **Grafik:** Chart.js 4.5
- **Autentikasi:** Laravel Breeze
- **Role & Permission:** Spatie Laravel-Permission 6.25

---

## Instalasi & Menjalankan Proyek

1. **Clone repository dan install dependensi:**
   ```bash
   composer install
   npm install
   ```

2. **Konfigurasi environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan konfigurasi database pada file `.env` (contoh: MySQL dengan database `SIPANTAUDB`).

3. **Jalankan migrasi dan seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Jalankan aplikasi:**
   ```bash
   npm run dev
   php artisan serve
   ```

5. **Akun default untuk uji coba:**
   - Email: `test@example.com`
   - Password: `password`
   - Role: `admin`

---

## Target Hasil Akhir

- Website fungsional yang dapat diakses melalui lokal server.
- Peta interaktif yang mampu menampilkan minimal 2 jenis bencana (banjir dan karhutla) di Kalimantan Selatan.
- Fitur CRUD (*Create, Read, Update, Delete*) untuk data bencana.
- Sistem peran dan hak akses (role & permission) berbasis Spatie.
- Laporan akhir proyek dan dokumentasi kode program.

---

## Catatan Penting

- Proyek ini berfokus pada aspek pengembangan teknis dan fungsionalitas sistem, mengingat ini adalah proyek magang.
- Data bencana yang digunakan dapat berupa data simulasi atau data contoh yang tersedia untuk keperluan uji coba, mengacu pada sumber data seperti inaRISK atau data terbuka BNPB.
