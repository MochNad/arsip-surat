<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistem Arsip Surat

Aplikasi pengelolaan arsip surat berbasis web yang dibangun dengan Laravel dan Bootstrap 5. Sistem ini memungkinkan pengguna untuk mengarsipkan, mengelola, dan melacak surat-surat dengan mudah dan efisien.

## Fitur Utama

-   📑 **Manajemen Surat**

    -   Upload dan arsip surat dalam format PDF
    -   Preview surat langsung di aplikasi
    -   Pencarian surat berdasarkan nomor dan judul
    -   Pengunduhan surat dalam format PDF
    -   Penghapusan surat dengan konfirmasi

-   🏷️ **Manajemen Kategori**

    -   Pengelolaan kategori surat
    -   Penambahan dan pengeditan kategori
    -   Pencarian kategori
    -   Hapus kategori dengan validasi

-   🔍 **Pencarian yang Ditingkatkan**

    -   Live search saat mengetik
    -   Indikator loading saat pencarian
    -   Filter berdasarkan multiple kriteria

-   📱 **Antarmuka Responsif**

    -   Desain mobile-friendly
    -   Layout yang adaptif
    -   Navigasi yang intuitif
    -   Breadcrumb untuk kemudahan navigasi

-   🎨 **UI/UX Modern**
    -   Bootstrap 5 untuk tampilan konsisten
    -   Notifikasi interaktif
    -   Preview PDF terintegrasi
    -   Modal konfirmasi untuk aksi penting

## Persyaratan Sistem

-   PHP >= 8.1
-   Composer
-   MySQL/MariaDB
-   Node.js & NPM
-   Web Server (Apache/Nginx)
-   Browser modern yang mendukung JavaScript

## Instalasi

1. Clone repositori

    ```bash
    git clone https://github.com/MochNad/arsip-surat.git
    cd arsip-surat
    ```

2. Install dependensi PHP

    ```bash
    composer install
    ```

3. Install dependensi JavaScript

    ```bash
    npm install
    npm run dev
    ```

4. Salin file .env

    ```bash
    cp .env.example .env
    ```

5. Generate key aplikasi

    ```bash
    php artisan key:generate
    ```

6. Konfigurasi database di file .env

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=arsip_surat
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. Jalankan migrasi dan seeder

    ```bash
    php artisan migrate --seed
    ```

8. Buat symlink storage

    ```bash
    php artisan storage:link
    ```

9. Jalankan aplikasi
    ```bash
    php artisan serve
    ```

## Struktur Database

### Tabel Categories

-   id (primary key)
-   nama_kategori (string, unique)
-   keterangan (text, nullable)
-   timestamps

### Tabel Letters

-   id (primary key)
-   category_id (foreign key)
-   nomor_surat (string, unique)
-   judul (string)
-   file_path (string)
-   timestamps

## Penggunaan

1. **Manajemen Surat**

    - Klik "Arsipkan Surat" untuk menambah surat baru
    - Isi formulir dengan nomor surat, kategori, judul
    - Upload file PDF surat
    - Lihat preview dan detail surat di halaman detail
    - Unduh atau hapus surat sesuai kebutuhan

2. **Manajemen Kategori**

    - Akses menu Kategori untuk melihat daftar kategori
    - Tambah kategori baru dengan nama dan keterangan
    - Edit kategori yang sudah ada
    - Hapus kategori (dengan validasi penggunaan)

3. **Pencarian**
    - Gunakan kotak pencarian untuk mencari surat/kategori
    - Hasil akan muncul secara otomatis saat mengetik
    - Filter berdasarkan nomor surat atau judul

## Keamanan

-   Validasi input untuk semua form
-   Sanitasi file yang diupload
-   Proteksi terhadap CSRF
-   Validasi tipe file (PDF only)
-   Batasan ukuran file upload

## Teknologi yang Digunakan

-   Laravel 10
-   Bootstrap 5
-   PDF.js
-   MySQL/MariaDB
-   JavaScript/jQuery
-   AJAX untuk live search
-   Responsive Design

## Support

Untuk bantuan dan pertanyaan, silakan hubungi:

-   Email: [email Anda]
-   Program Studi [Nama Program Studi]
-   Institusi [Nama Institusi]

## Lisensi

Copyright © 2025. Dilindungi Undang-undang.
