# PBWL Modul 4 — RESTful API dan Konsumsi API

Project praktikum Pemrograman Berbasis Web Lanjut (PBWL) menggunakan Laravel untuk implementasi RESTful API dan konsumsi API pada halaman web.

## Teknologi

- PHP
- Laravel
- MySQL
- RESTful API
- Blade dan JavaScript

## Persiapan Project

1. Clone repository:
   ```bash
   git clone https://github.com/oktaviaputrirj/PBWL-Modul4.git
   ```

2. Masuk ke folder project:
   ```bash
   cd PBWL-Modul4
   ```

3. Install dependency PHP:
   ```bash
   composer install
   ```

4. Salin file konfigurasi:
   ```bash
   copy .env.example .env
   ```

5. Buat application key:
   ```bash
   php artisan key:generate
   ```

6. Sesuaikan konfigurasi database di file `.env`, lalu buat database MySQL untuk project ini.

7. Jalankan migration:
   ```bash
   php artisan migrate
   ```

8. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```

9. Buka halaman konsumsi API:
   `http://127.0.0.1:8000/mata-kuliah`

## Catatan

Pastikan konfigurasi database sudah sesuai sebelum menjalankan migration. File `.env` tidak disertakan dalam repository karena berisi konfigurasi lokal.