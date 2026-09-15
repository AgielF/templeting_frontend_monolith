# Laporan Ekstraksi UI SSIP

Dokumentasi untuk porting UI SSIP ke template CI4 lain. Semua output laporan berada di folder ini.

## Indeks
1. [Navbar publik](01-navbar-public.md)
2. [Navbar admin](02-navbar-admin.md)
3. [Sidebar](03-sidebar.md)
4. [Home](04-home.md)
5. [Login](05-login.md)
6. [Profile](06-profile.md)
7. [List berita publik](07-berita-list-public.md)
8. [List berita admin](08-berita-list-admin.md)
9. [Form berita](09-berita-form.md)
10. [Assets](10-assets.md)
11. [Context mapping](11-context-mapping.md)
12. [Adaptation notes](12-adaptation-notes.md)

## Ringkasan Temuan
- Semua path target utama ditemukan.
- `app/Views/profile_view.php` ditemukan tetapi kosong (0 baris).
- `app/Views/user_profile_view.php` ditemukan tetapi hanya 9 baris; `app/Views/auth/profile.php` dipilih karena paling lengkap dan dipakai `AuthUi::profile()`.
- `berita_list_view.php` dan `berita_list_admin_view.php` adalah wrapper 6 baris; UI aktual berada di `sections/berita_list.php` dan `sections/berita_list_admin.php`.
- Form create/edit berita berada di `sections/berita_list_admin.php`; tidak ada view form berita terpisah yang ditemukan.
- `app/Controllers/Admin/Berita.php` ditemukan, tetapi rute aktual pada `app/Config/Routes.php` menunjuk `BeritaController`.
- Aset typo `public/assets/bootsrap/` ditemukan bersama `public/assets/bootstrap/`; jangan salin folder typo.

## Sumber Backend Dibaca
- `app/Controllers/BeritaController.php`
- `app/Controllers/Admin/Berita.php`
- `app/Models/BeritaModel.php`
- `app/Database/Migrations/2025-07-24-193460_CreateBerita.php`
- `app/Config/Routes.php` (rute `berita`)

## File Tidak Ditemukan
- Tidak ada file target utama yang tidak ditemukan.
- Sumber alternatif yang diperlukan: wrapper berita memakai `sections/`; profile utama memakai `auth/profile.php`.

## Catatan Kode Verbatim
Kode verbatim penuh kini tersedia untuk login, profile, list berita publik, section list berita admin, dan blok form/modal berita. Blok navbar publik, topbar/sidebar admin, dan sidebar admin juga ditempel verbatim; hanya bagian header publik di luar blok navigasi yang diberi penanda rentang baris sumber. Tidak ada sumber aplikasi yang diedit.

## Statistik
- Jumlah file laporan: 13 termasuk README.
- Total KB/baris final: jalankan `du -sk docs/ui-extraction` dan `wc -l docs/ui-extraction/*.md` setelah review.

## Draft Commit
```text
docs(ui-extract): ekstraksi UI SSIP + mapping ke template target
```
Jangan commit otomatis. Perintah manual:
```bash
git add docs/ui-extraction/
git status
git commit -m "docs(ui-extract): ekstraksi UI SSIP + mapping ke template target"
```
