# Sistem Manajemen Lapangan Olahraga

## Deskripsi

Sistem Manajemen Lapangan Olahraga adalah aplikasi web sederhana yang digunakan untuk mengelola data pengguna dan data lapangan olahraga.

Aplikasi ini dibuat menggunakan PHP dan MySQL serta menggunakan Bootstrap sebagai library eksternal untuk tampilan antarmuka.

## Fitur

### Data Pengguna
- Menambahkan data pengguna
- Melihat data pengguna
- Mengubah data pengguna
- Menghapus data pengguna
- Validasi email
- Password disimpan menggunakan password hashing

### Data Lapangan
- Menambahkan data lapangan
- Melihat data lapangan
- Mengubah data lapangan
- Menghapus data lapangan
- Data lapangan terhubung dengan data pengguna

## Database

Database yang digunakan:

`db_lapangan`

Terdapat 2 tabel:

1. `pengguna`
2. `lapangan`

Relasi:

`pengguna` 1 : N `lapangan`

Tabel `lapangan` memiliki foreign key `pengguna_id` yang mengarah ke tabel `pengguna`.

## Keamanan

Aplikasi menerapkan beberapa dasar keamanan:

- Prepared statement untuk mengurangi risiko SQL Injection
- `htmlspecialchars()` untuk membantu mencegah XSS pada output
- Validasi input
- Sanitasi input menggunakan `trim()`
- Password menggunakan `password_hash()`

## Library

Aplikasi menggunakan:

- Bootstrap 5.3.3

## Teknologi

- PHP
- MySQL
- HTML
- CSS
- Bootstrap
- XAMPP

## Cara Menjalankan

1. Install XAMPP.
2. Aktifkan Apache dan MySQL.
3. Simpan folder project ke:

`C:\xampp\htdocs\remedial-web`

4. Buat database `db_lapangan` melalui phpMyAdmin.
5. Import file `db_lapangan.sql`.
6. Pastikan konfigurasi database sesuai dengan file:

`config/database.php`

7. Buka browser dan akses:

`http://localhost/remedial-web/`

## Struktur Project

```text
remedial-web/
├── config/
│   ├── database.php
│   └── database.example.php
├── db_lapangan.sql
├── index.php
├── pengguna.php
├── lapangan.php
├── README.md
├── style.css
└── .gitignore