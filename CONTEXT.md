# Project Context

Proyek ini adalah template administrasi berbasis CodeIgniter 4 dengan autentikasi, RBAC, dashboard admin, dan contoh CRUD sebagai fondasi pengembangan antarmuka frontend bertahap.

## Stack

- CodeIgniter 4.7.4
- PHP 8.5
- MySQL melalui XAMPP

## Struktur `app/`

- `Controllers/`: menerima request dan mengatur alur aplikasi.
- `Filters/`: filter autentikasi, role, permission, dan throttle.
- `Models/`: akses serta aturan data aplikasi.
- `Views/`: halaman dan layout antarmuka.

## Konvensi

- Route admin menggunakan prefix `/admin/*`.
- Area admin menggunakan filter `auth`.
- Login menggunakan kolom `nomor`.

## Kredensial Tes

- Nomor: `admin`
- Password: `password123`

## Standar Fase 1-5

Pengembangan frontend mengikuti Brad Frost Atomic Design, Andy Bell CUBE CSS, prinsip aksesibilitas WCAG, progressive enhancement, responsive design, dan praktik semantic HTML.

## Prinsip Kerja

Perubahan dibuat kecil per fase dan setiap fase memiliki commit terpisah. RBAC yang sudah berjalan tidak diubah.

## Status Progress

Login dan dashboard sudah OK. CRUD belum diuji manual. Fase 1-5 belum mulai.