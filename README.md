# Intellimart Admin Template

> Template admin panel berbasis CodeIgniter 4 dengan standar industri.
> Diekstrak dari project SSIP_IF_ITENAS untuk penerapan di project Intellimart.

Template ini menyediakan fondasi admin panel untuk login berbasis session, RBAC,
profile pengguna, dan modul Berita & Kegiatan. Repository ini juga menjadi dokumentasi
implementasi serta bahan pemaparan KP dengan bukti kode yang dapat diverifikasi.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Stack & Dependensi](#-stack--dependensi)
- [Standar Industri](#-standar-industri-yang-diterapkan)
- [Cara Install](#-cara-install)
- [Kredensial Default](#-kredensial-default)
- [Screenshot](#-screenshot)
- [Struktur Folder](#-struktur-folder)
- [Daftar Route](#-daftar-route)
- [Skema Database](#-skema-database)
- [Cara Test](#-cara-test)
- [Roadmap](#-roadmap)
- [Dokumentasi Lain](#-dokumentasi-lain)
- [Lisensi](#-lisensi)
- [Author](#-author)

## ✨ Fitur Utama

- Login session-based menggunakan kolom `nomor`, bukan email.
- RBAC melalui roles, permissions, dan auth filters.
- Layout admin responsif dengan navbar profile/logout dan sidebar Berita & Kegiatan.
- Dashboard profile dengan informasi user dan akses edit profile.
- CRUD Berita & Kegiatan dengan soft delete dan pagination.
- Slug otomatis, status draft/published, dan empty state.
- Validasi form dengan feedback error per field.
- Implementasi WAI-ARIA pada bagian layout, form, dan tabel yang sudah diaudit.

## 🏗️ Stack & Dependensi

| Komponen | Versi |
|----------|-------|
| CodeIgniter | 4.7.4 |
| PHP | 8.5 |
| MySQL | via XAMPP atau server MySQL lain |
| Bootstrap | 5, asset lokal |
| Font Awesome | asset lokal |

Dependensi utama dari `composer.json` adalah `codeigniter4/framework: ^4.7`,
PHP `^8.2`, PHPUnit `^10.5.16`, Faker, dan VFS Stream. Environment proyek saat ini
menggunakan PHP 8.5.

## 📐 Standar Industri yang Diterapkan

Acuan utama bagian ini adalah [docs/AUDIT-STANDARDS.md](docs/AUDIT-STANDARDS.md).
Status berikut mengikuti bukti aktual, bukan asumsi target masa depan.

| # | Ahli | Standar | Status | Bukti Utama |
|---|------|---------|--------|-------------|
| 1 | Brad Frost | Atomic Design | ⚠️ Sebagian | [layout/main.php:1-3](app/Views/layout/main.php#L1-L3), shell reusable tanpa components |
| 2 | Andy Bell | CUBE CSS | ❌ Belum | [login.php:10-171](app/Views/auth/login.php#L10-L171), CSS inline tanpa token |
| 3 | Heydon Pickering | Inclusive Components | ⚠️ Sebagian | [berita/form.php:34-122](app/Views/admin/berita/form.php#L34-L122), label/error sudah ada |
| 4 | Addy Osmani | JS Design Patterns | ❌ Belum | [admin_header.php:198-213](app/Views/layout/admin_header.php#L198-L213), script inline |
| 5 | Vitaly Friedman | UX States | ⚠️ Sebagian | [berita/index.php:37-51](app/Views/admin/berita/index.php#L37-L51), empty state ada |
| 6 | Lonnie Ezell | CI4 View Cells | ❌ Belum | [main.php:1-3](app/Views/layout/main.php#L1-L3), include/renderSection |
| 7 | Scott O'Hara & Steve Faulkner | WAI-ARIA | ⚠️ Sebagian | [header.php:11-60](app/Views/layout/header.php#L11-L60), atribut ARIA parsial |
| 8 | Standar HTML | Semantic HTML5 | ⚠️ Sebagian | [header.php:13-60](app/Views/layout/header.php#L13-L60), nav/aside/main tersedia |

Status: ✅ Penuh · ⚠️ Sebagian · ❌ Belum

### 1. Brad Frost — Atomic Design

**Filosofi**: Atomic Design menyusun UI dari unit kecil reusable menjadi molecule,
organism, template, dan page agar konsistensi serta pemeliharaan meningkat.
**Status**: ⚠️ Sebagian
**Bukti di kode**:

- [app/Views/layout/main.php:1-3](app/Views/layout/main.php#L1-L3) memakai shell layout bersama.
- [app/Views/layout/header.php:13-65](app/Views/layout/header.php#L13-L65) memusatkan navbar/sidebar.
- [app/Views/admin/berita/index.php:20-118](app/Views/admin/berita/index.php#L20-L118) masih menulis alert, badge, empty state, dan table action langsung.

**Contoh kode**:

```php
<?= $this->include('layout/header') ?>
<?= $this->renderSection('content') ?>
<?= $this->include('layout/footer') ?>

```

**Gap & rekomendasi**:

- Belum ada `app/Views/components/` atau partial `_*.php`.
- Ekstrak alert, status badge, empty state, pagination, dan form field.
- Konsolidasikan `header.php` dan `admin_header.php` menjadi satu shell.

### 2. Andy Bell — CUBE CSS

**Filosofi**: CUBE CSS memisahkan Composition, Utility, Block, dan Exception,
didukung token visual agar CSS tetap terukur dan konsisten.
**Status**: ❌ Belum
**Bukti di kode**:

- [app/Views/auth/login.php:10-171](app/Views/auth/login.php#L10-L171) memiliki blok `<style>` besar.
- [app/Views/layout/admin_header.php:13-131](app/Views/layout/admin_header.php#L13-L131) juga memiliki CSS inline.
- [app/Views/auth/login.php:223](app/Views/auth/login.php#L223) memiliki inline style.

**Contoh kode**:

```css
.auth-left {
    background: #002366;
    color: white;
}

```

**Gap & rekomendasi**:

- Tidak ada CSS variables untuk warna, spacing, radius, typography, atau z-index.
- Pindahkan CSS ke `public/assets/css/app.css` dan tambahkan token `:root`.
- Gunakan Bootstrap utilities untuk layout umum dan CSS custom untuk block khusus.

### 3. Heydon Pickering — Inclusive Components

**Filosofi**: Komponen harus dapat dipahami dan digunakan oleh berbagai pengguna,
termasuk pengguna keyboard dan assistive technology, sejak tahap desain.
**Status**: ⚠️ Sebagian
**Bukti di kode**:

- [app/Views/auth/login.php:199-244](app/Views/auth/login.php#L199-L244) memiliki label/id, required, autocomplete, autofocus, dan error.
- [app/Views/admin/berita/form.php:34-122](app/Views/admin/berita/form.php#L34-L122) memakai `aria-describedby` dan `role="alert"`.
- [app/Views/layout/header.php:11](app/Views/layout/header.php#L11) memiliki skip-link.

**Contoh kode**:

```php
<label for="judul" class="form-label">Judul</label>
<input type="text" id="judul" name="judul"
       class="form-control<?= $fieldError('judul') ? ' is-invalid' : '' ?>"
       maxlength="200" required aria-describedby="judul-error">

```

**Gap & rekomendasi**:

- Modal profile dan example belum memiliki `role="dialog"`.
- Audit focus management dan keyboard behavior pada modal.
- Lengkapi atribut A11y pada layout lama `admin_header.php` atau konsolidasikan file itu.

### 4. Addy Osmani — JS Design Patterns

**Filosofi**: Behavior dipisahkan dari markup menggunakan modul atau namespace yang
jelas, event listener terpusat, dan lifecycle yang dapat diuji.
**Status**: ❌ Belum
**Bukti di kode**:

- [app/Views/layout/admin_header.php:198-213](app/Views/layout/admin_header.php#L198-L213) berisi script sidebar inline.
- [app/Views/admin/berita/index.php:98](app/Views/admin/berita/index.php#L98) menggunakan inline `onsubmit`.
- Tidak ada file JS aplikasi; asset JS yang tersedia adalah vendor Bootstrap.

**Contoh kode**:

```html
<form method="post"
      onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash" aria-hidden="true"></i>
    </button>
</form>

```

**Gap & rekomendasi**:

- Buat `public/assets/js/app.js` atau modul per fitur.
- Pindahkan confirm delete dan loading submit ke event listener.
- Pertahankan progressive enhancement agar form tetap bekerja tanpa JS.

### 5. Vitaly Friedman — UX States

**Filosofi**: UI perlu menjelaskan kondisi kosong, memuat, berhasil, dan gagal agar
pengguna selalu memahami hasil atau status aksinya.
**Status**: ⚠️ Sebagian
**Bukti di kode**:

- [app/Views/admin/berita/index.php:37-51](app/Views/admin/berita/index.php#L37-L51) memiliki empty state dan CTA.
- [app/Views/admin/berita/index.php:21-35](app/Views/admin/berita/index.php#L21-L35) memiliki success/error/validation alert.
- [app/Views/admin/berita/form.php:21-31](app/Views/admin/berita/form.php#L21-L31) memiliki global error.
- [app/Views/admin/example/index.php:23-25](app/Views/admin/example/index.php#L23-L25) memiliki empty row.

**Contoh kode**:

```php
<?php if (empty($beritaRows)): ?>
    <div class="text-center py-5">
        <i class="fas fa-newspaper fa-3x text-muted mb-3" aria-hidden="true"></i>
        <h2 class="h5">Belum ada berita</h2>
        <a href="<?= base_url('admin/berita/create') ?>" class="btn btn-primary">
            Tambah Berita Pertama
        </a>
    </div>
<?php endif; ?>

```

**Gap & rekomendasi**:

- Loading state belum tersedia pada submit, tabel, pagination, atau navigasi.
- `example/index.php` belum konsisten menampilkan error state.
- Standarkan alert/empty state sebagai partial dan tambahkan disabled/loading submit.

### 6. Lonnie Ezell — CI4 View Cells

**Filosofi**: View Cells cocok untuk komponen view yang perlu menyiapkan data dan
markup berulang, sehingga controller serta halaman tetap fokus pada konteks.
**Status**: ❌ Belum
**Bukti di kode**:

- [app/Views/layout/main.php:1-3](app/Views/layout/main.php#L1-L3) memakai include dan render section.
- [app/Views/layout/header.php:1-65](app/Views/layout/header.php#L1-L65) menempatkan shell langsung di view.
- Inventaris audit tidak menemukan `components/` atau partial `_*.php`.

**Contoh kode**:

```php
<?= $this->include('layout/header') ?>
<?= $this->renderSection('content') ?>
<?= $this->include('layout/footer') ?>

```

**Gap & rekomendasi**:

- Tidak ada View Cell atau partial reusable bernama `_xxx.php`.
- Gunakan partial untuk alert, badge, empty state, dan pagination.
- Evaluasi View Cell untuk user menu atau summary yang membutuhkan data berulang.

### 7. Scott O'Hara & Steve Faulkner — WAI-ARIA

**Filosofi**: ARIA melengkapi HTML native untuk status, hubungan field-error,
navigasi, dan widget interaktif. ARIA harus mendukung behavior nyata.
**Status**: ⚠️ Sebagian
**Bukti di kode**:

- [app/Views/layout/header.php:11-60](app/Views/layout/header.php#L11-L60) memiliki skip-link, nav label, dropdown state, `aria-hidden`, dan `aria-current`.
- [app/Views/admin/berita/index.php:60-69](app/Views/admin/berita/index.php#L60-L69) memakai `scope="col"`.
- [app/Views/admin/berita/form.php:34-122](app/Views/admin/berita/form.php#L34-L122) memakai `aria-describedby` dan `role="alert"`.

**Contoh kode**:

```php
<nav aria-label="Navigasi admin">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/berita') ?>">
                <i class="fas fa-newspaper me-2" aria-hidden="true"></i>
                <span>Berita &amp; Kegiatan</span>
            </a>
        </li>
    </ul>
</nav>

```

**Gap & rekomendasi**:

- Modal profile dan example belum memiliki `role="dialog"`.
- Tombol delete icon-only pada example belum memiliki `aria-label`.
- Audit keyboard/focus dan konsolidasikan `admin_header.php`.

### 8. Standar HTML5 — Semantic HTML

**Filosofi**: Semantic HTML memakai elemen sesuai makna agar struktur dokumen,
landmark, heading, navigasi, form, dan tabel mudah dipahami browser serta assistive technology.
**Status**: ⚠️ Sebagian
**Bukti di kode**:

- [app/Views/layout/header.php:13-60](app/Views/layout/header.php#L13-L60) memiliki nav, aside, dan main.
- [app/Views/admin/berita/index.php:58-72](app/Views/admin/berita/index.php#L58-L72) memiliki table/thead/tbody dan scope.
- [app/Views/admin/dashboard.php:5-9](app/Views/admin/dashboard.php#L5-L9) memiliki h1 lalu h2.
- [app/Views/auth/login.php:188-189](app/Views/auth/login.php#L188-L189) memiliki h1 lalu h2.

**Contoh kode**:

```php
<aside aria-label="Menu utama">
    <nav aria-label="Navigasi admin">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/berita') ?>">
                    Berita &amp; Kegiatan
                </a>
            </li>
        </ul>
    </nav>
</aside>
<main id="main" class="col-md-10 py-3">

```

**Gap & rekomendasi**:

- Shell aktif belum membungkus navbar dengan `<header>` dan belum memiliki `<footer>`.
- `<main>` dibuka di `header.php` dan ditutup oleh `footer.php`.
- `auth/profile.php` memulai heading visual dari h4 tanpa h1.
- Pastikan setiap halaman memiliki satu h1 dan heading berurutan.

## 🚀 Cara Install

### Prasyarat

- PHP >= 8.5
- Composer
- MySQL via XAMPP, Laragon, atau instalasi manual
- Extensions CodeIgniter seperti `intl`, `mbstring`, dan `mysqli`

### Langkah

```bash
git clone https://github.com/AgielF/templeting_frontend_monolith.git
cd templeting_frontend_monolith
composer install
cp env .env
mysql -u root -e "CREATE DATABASE intellimart_template"
php spark migrate
php spark serve --port 8081

```

Edit `.env` setelah menyalin file `env` untuk menyesuaikan `app.baseURL` dan
`database.default.*`. Repository menyediakan `env`, bukan `.env.example`.

## 🔑 Kredensial Default

| Field | Value |
|-------|-------|
| Nomor | `admin` |
| Password | `password123` |

Gunakan credential tersebut hanya untuk development/testing lokal.

## 📸 Screenshot

Screenshot aktual belum disertakan. Placeholder:

- [Login page](docs/screenshots/01-login.png)
- [Dashboard profile](docs/screenshots/02-dashboard-profile.png)
- [List berita empty](docs/screenshots/03-berita-empty.png)
- [List berita berisi data](docs/screenshots/04-berita-list.png)
- [Form create/edit](docs/screenshots/05-berita-form.png)

Embed setelah gambar tersedia:

```markdown
![Login page](docs/screenshots/01-login.png)

```

## 📂 Struktur Folder

```text
app/
├── Config/
│   └── Routes.php
├── Controllers/
│   ├── AuthController.php
│   ├── BeritaController.php
│   └── DashboardController.php
├── Database/Migrations/
│   └── 2026-09-15-220000_CreateBeritaTable.php
├── Models/
│   ├── BeritaModel.php
│   ├── RoleModel.php
│   └── UserModel.php
└── Views/
    ├── admin/berita/{index.php,form.php}
    ├── admin/dashboard.php
    ├── auth/{login.php,profile.php}
    └── layout/{header.php,main.php,footer.php}
docs/
├── AUDIT-STANDARDS.md
└── ui-extraction/

```

## 🗺️ Daftar Route

Route dalam group `admin` menggunakan filter `auth`.

| Method | Route | Handler | Filter |
|--------|-------|---------|--------|
| GET | `/` | `Home::index` | - |
| GET | `/login` | `AuthController::login` | - |
| POST | `/login` | `AuthController::attemptLogin` | - |
| GET | `/logout` | `AuthController::logout` | - |
| GET | `/admin` | `DashboardController::index` | auth |
| GET | `/admin/dashboard` | `DashboardController::index` | auth |
| GET | `/admin/profile` | `DashboardController::profile` | auth |
| POST | `/admin/profile/update` | `DashboardController::updateProfile` | auth |
| GET | `/admin/example` | `ExampleController::index` | auth |
| POST | `/admin/example/store` | `ExampleController::store` | auth |
| POST | `/admin/example/update/(:num)` | `ExampleController::update/$1` | auth |
| GET | `/admin/example/delete/(:num)` | `ExampleController::delete/$1` | auth |
| GET | `/admin/berita` | `BeritaController::index` | auth |
| GET | `/admin/berita/create` | `BeritaController::create` | auth |
| POST | `/admin/berita/store` | `BeritaController::store` | auth |
| GET | `/admin/berita/edit/(:num)` | `BeritaController::edit/$1` | auth |
| POST | `/admin/berita/update/(:num)` | `BeritaController::update/$1` | auth |
| POST | `/admin/berita/delete/(:num)` | `BeritaController::delete/$1` | auth |

## 🗃️ Skema Database

### Tabel `users`

- `id`, `nomor`, `nama`, `no_telp`, `jurusan`, `role_id`, `password`.
- `created_at`, `updated_at`.

Bukti: [app/Models/UserModel.php:8-16](app/Models/UserModel.php#L8-L16).

### Tabel `roles`

- `id`, `role_name`, `created_at`, `updated_at`.

### Tabel `role_permissions`

- Relasi role dan permission untuk fondasi RBAC.
- Struktur detail mengikuti migration `RolePermissions.php`.

### Tabel `berita`

- `id`, `judul`, `slug`, `konten`, `kategori`, `gambar`, `status`.
- `penulis_id`, `published_at`, `created_at`, `updated_at`, `deleted_at`.

Bukti: [app/Models/BeritaModel.php:8-42](app/Models/BeritaModel.php#L8-L42).

### Validasi Berita

```php
protected $validationRules = [
    'judul' => 'required|min_length[3]|max_length[200]',
    'slug' => 'required|max_length[220]',
    'konten' => 'required|min_length[10]',
    'status' => 'required|in_list[draft,published]',
];

```

## 🧪 Cara Test

```bash
php spark routes
php spark routes | grep berita
php -l app/Controllers/BeritaController.php
php -l app/Models/BeritaModel.php
php -l app/Views/admin/berita/index.php
php -l app/Views/admin/berita/form.php
composer test

```

Checklist manual:

- [ ] Login dengan nomor `admin` dan password development.
- [ ] Dashboard menampilkan user dan role.
- [ ] Edit profile, ubah `no_telp`, lalu simpan.
- [ ] Logout kembali ke `/login`.
- [ ] Empty state muncul di `/admin/berita` saat belum ada data.
- [ ] Create berita draft berhasil dan muncul di list.
- [ ] Edit berita menjadi `published` mengisi `published_at`.
- [ ] Delete berita memakai konfirmasi, POST, CSRF, dan soft delete.
- [ ] Pagination dan keyboard tab navigation berjalan.

## 🛠️ Roadmap

- ☑ Baseline CI4 + RBAC
- ☑ Migration dan model Berita
- ☑ Layout admin, login, dan dashboard profile
- ☑ CRUD Berita end-to-end
- □ Atomic Design: components dan partial reusable
- □ CUBE CSS: design tokens dan stylesheet aplikasi
- □ Modular JS: `app.js` dan `modules/*`
- □ Audit A11y lanjutan untuk modal dan focus
- □ Loading state untuk form/tabel/submit
- □ File upload gambar berita
- □ User management CRUD

## 📄 Dokumentasi Lain

- [CONTEXT.md](CONTEXT.md) — konteks dan status progres.
- [docs/AUDIT-STANDARDS.md](docs/AUDIT-STANDARDS.md) — audit standar ahli.
- [docs/ui-extraction/](docs/ui-extraction/) — ekstraksi UI dan mapping porting.
- [composer.json](composer.json) — dependensi dan constraint versi.

## 📝 Lisensi

MIT

## 👤 Author

**Agiel Fernanda**

- GitHub: [@AgielF](https://github.com/AgielF)
- Project: [templeting_frontend_monolith](https://github.com/AgielF/templeting_frontend_monolith)
