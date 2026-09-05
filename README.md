<<<<<<< HEAD
# SIPANTAU — Sistem Informasi Peta Analisis & Navigasi Teritorial Alam Utama

Platform **Web-GIS** informasi peta bencana untuk wilayah Kalimantan Selatan. SIPANTAU menampilkan data bencana utama — banjir, kebakaran hutan dan lahan (karhutla), angin puting beliung, dan tanah longsor — dalam bentuk visualisasi interaktif yang mudah diakses oleh masyarakat dan petugas.

---

## Daftar Isi

- [Ringkasan Proyek](#ringkasan-proyek)
- [Latar Belakang & Tujuan](#latar-belakang--tujuan)
- [Anggota Kelompok](#anggota-kelompok)
- [Fitur](#fitur)
- [Alur Kerja (Workflow)](#alur-kerja-workflow)
- [Teknologi](#teknologi)
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

- **Visualisasi Peta Interaktif (Web-GIS):** Fitur inti yang menampilkan titik-titik lokasi bencana (banjir, karhutla) pada peta digital menggunakan library seperti Leaflet JS atau integrasi dengan Google Maps API. Peta menampilkan data spasial seperti polygon area banjir atau titik api karhutla.
- **Form Pelaporan Kejadian:** Fitur bagi admin atau petugas (simulasi) untuk menginput data bencana baru, termasuk lokasi, jenis bencana, jumlah korban, dan kerugian. Data mengacu pada standar pelaporan seperti Format A, B, dan C.
- **Dashboard Informasi & Berita:** Halaman depan yang menampilkan ringkasan data bencana (misalnya total kejadian, wilayah terdampak) serta berita atau artikel terkait kebencanaan.
- **Informasi Wilayah Rawan Bencana:** Menampilkan peta kerentanan yang mengidentifikasi wilayah-wilayah berpotensi tinggi terkena bencana tertentu, seperti banjir di Kabupaten Banjar atau longsor di Kabupaten Kotabaru.
- **Data Statistik Sederhana:** Menampilkan grafik atau statistik deskriptif dari data historis bencana untuk memberikan gambaran tren kepada pengguna.

---

## Alur Kerja (Workflow)

Alur kerja sistem disesuaikan dengan peran pengguna (*User Role*):

- **Admin/Operator:** Memiliki akses penuh untuk mengelola data kejadian (tambah, edit, hapus), mengelola berita, dan mengelola akun pengguna.
- **Masyarakat/Pengguna Umum:** Dapat melihat peta, melihat titik-titik bencana, dan membaca berita/informasi (*guest view*).
- **Petugas Lapangan (Simulasi):** *(Opsional)* Dapat menginputkan data kejadian dari lapangan melalui form yang disediakan pada website.

**Alur Data:**

`Input Data Bencana (oleh Admin/Petugas)` → `Pemrosesan Data (Penyimpanan di Database)` → `Tampilan Peta (Visualisasi titik/polygon di WebGIS)` → `Informasi kepada Publik (Dashboard dan Berita)`

---

## Teknologi

- **Web-GIS:** Leaflet JS / Google Maps API
- *(akan dilengkapi sesuai stack yang digunakan selama pengembangan)*

---

## Target Hasil Akhir

- Website fungsional yang dapat diakses melalui lokal server.
- Peta interaktif yang mampu menampilkan minimal 2 jenis bencana (banjir dan karhutla) di Kalimantan Selatan.
- Fitur CRUD (*Create, Read, Update, Delete*) untuk data bencana.
- Laporan akhir proyek dan dokumentasi kode program.

---

## Catatan Penting

- Proyek ini berfokus pada aspek pengembangan teknis dan fungsionalitas sistem, mengingat ini adalah proyek magang.
- Data bencana yang digunakan dapat berupa data simulasi atau data contoh yang tersedia untuk keperluan uji coba, mengacu pada sumber data seperti inaRISK atau data terbuka BNPB.
=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
db21854 (paket)
