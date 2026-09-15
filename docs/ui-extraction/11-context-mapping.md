# Context Mapping

Pemetaan UI SSIP ke target `~/kuliah/KP/templeting_frontend_monolith_CI`.

## A. Pemetaan Variabel
| Elemen UI | Var SSIP | Var Target | Sumber Target |
|---|---|---|---|
| Login identifier | email/username | `nomor` | `AuthController::attemptLogin` |
| Nama pengguna | session/user query | `nama` | target session/UserModel |
| ID pengguna | `id_user` | `user_id` | target session |
| Peran | role/permission SSIP | `role_id` | target session |
| Status login | session auth | `logged_in` | target session/header |
| Judul berita | `$row['judul']` | `$row['judul']` | BeritaModel baru |
| Isi berita | `$row['konten']` | `$row['konten']` | BeritaModel baru |
| Kategori | `$row['kategori']` | `$row['kategori']` | BeritaModel baru |
| Tanggal | `$row['tanggal']` | `$row['tanggal']` | BeritaModel baru |
| Pembuat | `$row['creator']` | join users / `nama` | controller target |

## B. Pemetaan Rute
| Aksi UI | Rute SSIP | Target Rute | Target Pengontrol |
|---|---|---|---|
| Login submit | AuthUi route SSIP | POST `/login` | `AuthController::attemptLogin` |
| List berita publik | GET `/berita` | GET `/berita` | `BeritaController::index` (BARU) |
| List berita admin | GET `/berita_admin` | `/admin/berita` | `BeritaController::index` (BARU) |
| Store | POST `/berita/store` | `/admin/berita/store` | controller berita target |
| Update | POST `/berita/update/(:num)` | `/admin/berita/update/$1` | controller berita target |
| Delete | POST `/berita/delete/(:num)` | `/admin/berita/delete/$1` | controller berita target |
| Logout | AuthUi target SSIP | GET `/logout` | `AuthController::logout` |

Rute SSIP aktual di `app/Config/Routes.php`: GET `/berita`, GET `/berita_admin`, POST `berita/store`, POST `berita/update/(:num)`, POST `berita/delete/(:num)`, dengan filter `session_security` dan `permission:berita_admin` pada grup admin.

## C. Mapping Kolom DB
| Kolom SSIP | Tipe | Kolom Target (usulan) | Catatan |
|---|---|---|---|
| `id_berita` | INT primary | `id_berita` | Pertahankan atau map ke `id` |
| `judul` | VARCHAR(100) | `judul` | Validasi max 100 |
| `konten` | TEXT | `konten` | Escape output |
| `kategori` | VARCHAR | `kategori` | Filter kategori |
| `tanggal` | DATE | `tanggal` | Validasi valid_date |
| `id_user` | INT | `user_id`/`id_user` | FK ke users |

## D. Formulir Pemetaan Bidang
| Field SSIP | Field Target | Alasan |
|---|---|---|
| `judul` | `judul` | Kontrak UI sama |
| `konten` | `konten` | Kontrak UI sama |
| `kategori` | `kategori` | Filter publik memakai kategori |
| `tanggal` | `tanggal` | Tanggal daftar dan sorting |
| `id_berita` | `id_berita` | Edit/delete key |

## E. Gap / Catatan Beda Struktur
- SSIP memakai filter `session_security` + `permission:berita_admin`; target memakai `auth` di grup `/admin/*`.
- SSIP login memakai email/username pada UI lama; target wajib memakai `nomor`.
- SSIP rute admin berita tidak memakai prefix `/admin`; target mengharuskannya.
- `app/Controllers/Admin/Berita.php` ada, tetapi rute aktual yang ditemukan menunjuk `BeritaController`; jangan mengasumsikan controller admin itu aktif.
- Wrapper list hanya meng-include section; section adalah sumber UI utama.
- `profile_view.php` kosong dan `user_profile_view.php` sangat ringkas; gunakan `auth/profile.php`.
- Path aset SSIP tidak konsisten (`bootsrap`, `bootstrap`, `vendor/bootstrap`).
