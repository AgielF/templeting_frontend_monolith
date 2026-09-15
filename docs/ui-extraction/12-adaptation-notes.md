# Catatan Porting

## Perubahan per File
| File SSIP | Target di Template | Yang Diubah |
|---|---|---|
| `layout/header.php` | `app/Views/layout/header.php` | Pertahankan shell target; map session `nomor`, `nama`, `logged_in`; ganti brand |
| `layout/admin_header.php` | layout admin target | Ambil navbar/profile/logout dan sederhanakan menu |
| Sidebar admin | `layout/admin_header.php` | Sisakan Berita & Kegiatan; gunakan filter `auth` |
| `auth/login.php` | `auth/login.php` | Ganti identifier ke `nomor`, pertahankan error state |
| `auth/profile.php` | `auth/profile.php` | Map user target: id, nomor, nama, no_telp, jurusan, role_id |
| `sections/berita_list.php` | `berita/index.php` atau component | Map `$schedules`, pagination/empty state, route target |
| `sections/berita_list_admin.php` | `admin/berita/index.php` | Pindah CRUD ke `/admin/berita/*`, tambah a11y |
| `sections/berita_list_admin.php` form | `admin/berita/_form.php` | Jadikan component reusable untuk create/edit |
| `footer.php` | `layout/footer.php` | Normalisasi asset dan semantic footer |

## Standar Ahli yang Wajib Diterapkan di Target
- A11y (Heydon Pickering, Scott O'Hara): label `for`/`id`, `aria-label`, `role="dialog"` pada modal, `th scope`, skip-link, semantic nav/main/footer.
- Semantik (Lonnie Ezell): `header`/`nav`/`main`/`aside`/`footer` sesuai peran; gunakan View Cells bila komponen dipakai lebih dari sekali.
- UX (Vitaly Friedman): keadaan kosong, memuat, dan kesalahan.
- Atomic Design (Brad Frost): komponen reusable di `views/components/`.
- WAI-ARIA (Scott O'Hara): gunakan role dan aria sesuai perilaku, bukan dekoratif.

## Daftar Periksa Tes Nanti
- [ ] Login pakai nomor
- [ ] Dashboard/profile tampil data dari session
- [ ] Navbar atas: profile dropdown + logout
- [ ] Sidebar: menu Berita & Kegiatan saja
- [ ] List berita: empty state kalau kosong
- [ ] Buat/simpan formulir
- [ ] Edit/perbarui
- [ ] Delete + konfirmasi
- [ ] Keluar

## Aset yang Perlu Dipertimbangkan
- SSIP punya folder typo `bootsrap/`; jangan dicopy ke target.
- Target sudah punya `bootstrap/`, `fontawesome/`, `fonts/`.
- Salin hanya CSS/JS/gambar SSIP kustom yang benar-benar baru.

## Risiko Implementasi
- Escape data tabel/modal dengan benar; atribut `data-*` perlu encoding aman.
- Jangan pakai action hard-coded `/berita/...` setelah dipindah ke prefix `/admin`.
- Pastikan CSRF tetap aktif untuk store/update/delete.
- Tambahkan `scope="col"` pada header tabel dan konfirmasi yang dapat diakses keyboard.
