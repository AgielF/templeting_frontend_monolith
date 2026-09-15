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
- [Cakupan Standar per Halaman](#-cakupan-standar-per-halaman)
- [Cara Install](#-cara-install)
- [Kredensial Default](#-kredensial-default)
- [Screenshot](#-screenshot)
- [Struktur Folder](#-struktur-folder)
- [Daftar Route](#-daftar-route)
- [Skema Database](#-skema-database)
- [Cara Test](#-cara-test)
- [Roadmap](#-roadmap)
- [Known Issues](#️-known-issues)
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
- Landing page publik dengan CUBE CSS dan design tokens.
- Modal profil dengan WAI-ARIA (`role="dialog"`, focus trap, `aria-invalid`).
- Asset custom: `tokens.css`, `app.css`, `admin.css`, dan `app.js` modular.

## 🏗️ Stack & Dependensi

| Komponen | Versi |
|----------|-------|
| CodeIgniter | 4.7.4 |
| PHP | 8.5 |
| MySQL | via XAMPP atau server MySQL lain |
| Bootstrap | 5, asset lokal |
| Font Awesome | asset lokal |
| Custom CSS | `tokens.css` + `app.css` + `admin.css` |
| Custom JS | `app.js` (IIFE namespace `App`) |

Dependensi utama dari `composer.json` adalah `codeigniter4/framework: ^4.7`,
PHP `^8.2`, PHPUnit `^10.5.16`, Faker, dan VFS Stream. Environment proyek saat ini
menggunakan PHP 8.5.

## 📐 Standar Industri yang Diterapkan

| # | Ahli | Standar | Status |
|---|------|---------|--------|
| 1 | Brad Frost | Atomic Design | ✅ Landing + Modal |
| 2 | Andy Bell | CUBE CSS | ✅ `tokens.css` + `app.css` + `admin.css` |
| 3 | Heydon Pickering | Inclusive Components | ✅ Landing + Modal |
| 4 | Addy Osmani | JS Design Patterns | ✅ IIFE namespace `App` |
| 5 | Vitaly Friedman | UX States | ✅ Landing (empty/error) |
| 6 | Lonnie Ezell | CI4 View Cells | ❌ Belum (out of scope) |
| 7 | Scott O'Hara & Steve Faulkner | WAI-ARIA | ✅ Landing + Modal |
| 8 | HTML5 Spec | Semantic HTML | ✅ Landing |

### 1. Brad Frost — Atomic Design

**Filosofi**: Atomic Design menyusun UI dari unit kecil reusable menjadi molecule,
organism, template, dan page agar konsistensi serta pemeliharaan meningkat.

**Status**: ✅ Landing + Modal Profil

**Bukti di kode**:

- [app/Views/components/_navbar-public.php](app/Views/components/_navbar-public.php) — organisme navigasi publik.
- [app/Views/components/_hero.php](app/Views/components/_hero.php) — organisme hero landing.
- [app/Views/components/_feature-card.php](app/Views/components/_feature-card.php) — molecule feature card dengan parameter eksplisit.
- [app/Views/components/_footer-public.php](app/Views/components/_footer-public.php) — organisme footer publik.
- [app/Views/components/_modal.php](app/Views/components/_modal.php) — organism modal reusable dengan parameter.
- [app/Views/home.php](app/Views/home.php) — page standalone merangkai komponen.
- [app/Views/layout/main.php](app/Views/layout/main.php) — shell layout bersama.

**Contoh kode**:

```php
<?= $this->include('components/_navbar-public') ?>
<?= $this->include('components/_hero') ?>
<section id="features" class="section">
  <?= $this->include('components/_feature-card', $item) ?>
</section>
<?= $this->include('components/_footer-public') ?>
```

**Sisa pekerjaan (out of scope)**:

- Ekstrak alert, badge, empty state, dan pagination admin ke `components/`.
- Konsolidasikan `header.php` dan `admin_header.php` (sisa SSIP).

### 2. Andy Bell — CUBE CSS

**Filosofi**: CUBE CSS memisahkan Composition, Utility, Block, dan Exception,
didukung token visual agar CSS tetap terukur dan konsisten.

**Status**: ✅ Landing + Modal

**Bukti di kode**:

- [public/assets/css/tokens.css](public/assets/css/tokens.css) — seluruh design tokens (`--color-*`, `--space-*`, `--font-*`, `--radius-*`, `--shadow-*`).
- [public/assets/css/app.css](public/assets/css/app.css) — Composition (`.container`, `.grid`, `.section`), Utility (`.sr-only`, `.text-center`), Block (`.hero`, `.feature-card`, `.site-footer`, `.btn`), Exception (media queries).
- [public/assets/css/admin.css](public/assets/css/admin.css) — Block modal, form field, alert, breadcrumb.
- [app/Views/layout/header.php](app/Views/layout/header.php) — load ketiga stylesheet dengan urutan yang benar.

**Contoh kode**:

```css
:root {
  --color-primary: #2563eb;
  --space-4: 1rem;
  --radius-md: 0.5rem;
}
.feature-card {
  background: var(--color-surface);
  border-radius: var(--radius-lg);
  padding: var(--space-6);
}
```

**Sisa pekerjaan**:

- Migrasi styling admin lama (`admin_header.php` inline CSS) ke `admin.css`.
- Ganti Bootstrap utility pada layout admin dengan CUBE utility.

### 3. Heydon Pickering — Inclusive Components

**Filosofi**: Komponen harus dapat dipahami dan digunakan oleh berbagai pengguna,
termasuk pengguna keyboard dan assistive technology, sejak tahap desain.

**Status**: ✅ Landing + Modal

**Bukti di kode**:

- [app/Views/components/_navbar-public.php](app/Views/components/_navbar-public.php) — tombol hamburger dengan `aria-expanded` dan `aria-controls`.
- [app/Views/components/_modal.php](app/Views/components/_modal.php) — dialog dengan `role="dialog"`, `aria-modal`, label, dan tombol close.
- [public/assets/js/app.js](public/assets/js/app.js) — focus trap, Escape, backdrop click, focus restore ke trigger.
- [app/Views/auth/profile.php](app/Views/auth/profile.php) — field dengan `aria-describedby`, `aria-invalid`, dan `aria-live="polite"`.

**Contoh kode**:

```php
<div role="dialog" aria-modal="true" aria-labelledby="editProfileModal-title">
  <button data-modal-close aria-label="Tutup dialog">
    <i class="fas fa-times" aria-hidden="true"></i>
  </button>
</div>
```

### 4. Addy Osmani — JS Design Patterns

**Filosofi**: Behavior dipisahkan dari markup menggunakan modul atau namespace yang
jelas, event listener terpusat, dan lifecycle yang dapat diuji.

**Status**: ✅ Landing + Modal

**Bukti di kode**:

- [public/assets/js/app.js](public/assets/js/app.js) — IIFE dengan namespace `App`.
- Module: `Navbar`, `SmoothScroll`, `Modal` — masing-masing dengan `init()`.
- Event delegation terpusat di `document.addEventListener`.

**Contoh kode**:

```javascript
(function () {
  "use strict";
  const Modal = {
    open(id) { /* ... */ },
    close(id) { /* ... */ },
    trapFocus(e) { /* ... */ },
    init() { /* event delegation */ },
  };
  const App = {
    init() { Modal.init(); Navbar.init(); },
  };
  App.init();
})();
```

**Sisa pekerjaan**:

- Pecah ke `modules/*.js` jika file bertambah besar.
- Ganti `onsubmit="return confirm(...)"` di `berita/index.php` dengan module `Confirm`.

### 5. Vitaly Friedman — UX States

**Filosofi**: UI perlu menjelaskan kondisi kosong, memuat, berhasil, dan gagal agar
pengguna selalu memahami hasil atau status aksinya.

**Status**: ✅ Landing + sebagian admin

**Bukti di kode**:

- [app/Views/home.php](app/Views/home.php) — CTA jelas, feature cards dengan hover state.
- [app/Views/admin/berita/index.php](app/Views/admin/berita/index.php) — empty state dengan CTA, alert success/error/validation.
- [app/Views/auth/profile.php](app/Views/auth/profile.php) — `aria-live="polite"` untuk status submit, error per field.

**Contoh kode**:

```php
<?php if (empty($beritaRows)): ?>
  <div class="text-center py-5">
    <i class="fas fa-newspaper fa-3x text-muted mb-3" aria-hidden="true"></i>
    <h2 class="h5">Belum ada berita</h2>
    <a href="<?= base_url('admin/berita/create') ?>" class="btn btn--primary">
      Tambah Berita Pertama
    </a>
  </div>
<?php endif; ?>
```

**Sisa pekerjaan**:

- Loading state pada submit form dan pagination.
- Error state konsisten di `example/index.php`.

### 6. Lonnie Ezell — CI4 View Cells

**Filosofi**: View Cells cocok untuk komponen view yang perlu menyiapkan data dan
markup berulang, sehingga controller serta halaman tetap fokus pada konteks.

**Status**: ❌ Belum (out of scope)

**Bukti di kode**:

- Partial sudah ada di `app/Views/components/`, tapi masih memakai `$this->include()`.
- Belum ada `app/Cells/`.

**Rekomendasi**:

- Konversi `_feature-card.php` menjadi `app/Cells/FeatureCardCell.php`.
- Evaluasi View Cell untuk menu user atau statistik dashboard.

### 7. Scott O'Hara & Steve Faulkner — WAI-ARIA

**Filosofi**: ARIA melengkapi HTML native untuk status, hubungan field-error,
navigasi, dan widget interaktif. ARIA harus mendukung behavior nyata.

**Status**: ✅ Landing + Modal

**Bukti di kode**:

- [app/Views/home.php](app/Views/home.php) — skip-link, landmark (`header`/`main`/`footer`), `aria-labelledby` per section.
- [app/Views/components/_modal.php](app/Views/components/_modal.php) — `role="dialog"`, `aria-modal`, `aria-hidden` toggle.
- [app/Views/auth/profile.php](app/Views/auth/profile.php) — `aria-describedby` per field, `aria-invalid` saat error, `role="alert"` untuk pesan error.
- [app/Views/layout/header.php](app/Views/layout/header.php) — skip-link, nav label, dropdown state, `aria-current`.

**Contoh kode**:

```php
<label for="nama" class="form-field__label">Nama</label>
<input
  type="text"
  id="nama"
  name="nama"
  class="form-field__input"
  aria-describedby="nama-hint nama-error"
  aria-invalid="<?= $validation->hasError('nama') ? 'true' : 'false' ?>"
>
<span id="nama-error" class="form-field__error" role="alert">
  <?= $validation->getError('nama') ?>
</span>
```

### 8. Standar HTML5 — Semantic HTML

**Filosofi**: Semantic HTML memakai elemen sesuai makna agar struktur dokumen,
landmark, heading, navigasi, form, dan tabel mudah dipahami browser serta assistive technology.

**Status**: ✅ Landing

**Bukti di kode**:

- [app/Views/home.php](app/Views/home.php) — `header`, `main`, `section` dengan `aria-labelledby`, `article` per feature card, `footer`.
- [app/Views/components/_hero.php](app/Views/components/_hero.php) — `<section aria-labelledby>` dengan `h1`.
- [app/Views/components/_feature-card.php](app/Views/components/_feature-card.php) — `<article aria-label>` dengan `h3`.

**Contoh kode**:

```html
<main id="main-content">
  <section id="features" class="section" aria-labelledby="features-heading">
    <h2 id="features-heading" class="section__title">Fitur Unggulan</h2>
    <article class="feature-card" aria-label="Atomic Design">
      <h3 class="feature-card__title">Atomic Design</h3>
    </article>
  </section>
</main>
```

**Sisa pekerjaan**:

- Audit heading hierarchy di `auth/profile.php` (masih mulai dari h4).
- Bungkus navbar admin lama dengan `<header>`.

## 📊 Cakupan Standar per Halaman

| Halaman | Atomic | CUBE | JS | WAI-ARIA | Semantic | UX States |
|---------|:---:|:---:|:---:|:---:|:---:|:---:|
| Landing (`app/Views/home.php`) | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Modal Profil (`app/Views/components/_modal.php`) | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ |
| Login (`app/Views/auth/login.php`) | ⚠️ | ⚠️ | ❌ | ⚠️ | ⚠️ | ⚠️ |
| Dashboard (`app/Views/admin/dashboard.php`) | ⚠️ | ⚠️ | ❌ | ⚠️ | ⚠️ | ❌ |
| Berita List (`app/Views/admin/berita/index.php`) | ⚠️ | ⚠️ | ❌ | ⚠️ | ⚠️ | ✅ |
| Berita Form (`app/Views/admin/berita/form.php`) | ⚠️ | ⚠️ | ❌ | ⚠️ | ⚠️ | ⚠️ |
| Layout Admin (`app/Views/layout/header.php`) | ⚠️ | ⚠️ | ⚠️ | ⚠️ | ⚠️ | ❌ |

**Legenda:** ✅ diterapkan penuh · ⚠️ sebagian · ❌ belum

## 🚀 Cara Install

### Prasyarat

- PHP >= 8.2 (development memakai 8.5)
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
`database.default.*`. Repository menyediakan `env` di root project.

**Penting**: pastikan `app.indexPage` di `.env` diset kosong (`app.indexPage = ''`) agar URL bersih tanpa `/index.php`.

## 🔑 Kredensial Default

| Field | Value |
|-------|-------|
| Nomor | `admin` |
| Password | `password123` |

Gunakan credential tersebut hanya untuk development/testing lokal.

## 📸 Screenshot

Screenshot aktual belum disertakan. Placeholder:

- [Landing page](docs/screenshots/00-landing.png)
- [Login page](docs/screenshots/01-login.png)
- [Dashboard profile](docs/screenshots/02-dashboard-profile.png)
- [List berita empty](docs/screenshots/03-berita-empty.png)
- [List berita berisi data](docs/screenshots/04-berita-list.png)
- [Form create/edit](docs/screenshots/05-berita-form.png)
- [Modal profile](docs/screenshots/06-modal-profile.png)

Embed setelah gambar tersedia:

```markdown
![Landing page](docs/screenshots/00-landing.png)
```

## 📂 Struktur Folder

```text
app/
├── Config/
│   └── Routes.php
├── Controllers/
│   ├── AuthController.php
│   ├── BeritaController.php
│   ├── DashboardController.php
│   ├── ExampleController.php
│   └── Home.php
├── Database/Migrations/
│   ├── 2025-07-24-193451_CreateRoles.php
│   ├── 2025-07-24-193452_CreateUsers.php
│   ├── 2026-07-30-043359_RolePermissions.php
│   ├── 2026-09-15-105213_CreateExamplesTable.php
│   └── 2026-09-15-220000_CreateBeritaTable.php
├── Filters/
│   ├── AuthFilter.php
│   ├── AdminFilter.php
│   ├── RoleFilter.php
│   ├── PermissionFilter.php
│   └── ThrottleFilter.php
├── Models/
│   ├── BeritaModel.php
│   ├── RoleModel.php
│   ├── RolePermissionModel.php
│   ├── UserModel.php
│   └── ExampleModel.php
└── Views/
    ├── components/
    │   ├── _navbar-public.php
    │   ├── _hero.php
    │   ├── _feature-card.php
    │   ├── _footer-public.php
    │   └── _modal.php
    ├── layout/
    │   ├── header.php
    │   ├── footer.php
    │   └── main.php
    ├── admin/
    │   ├── dashboard.php
    │   ├── berita/{index.php,form.php}
    │   └── example/index.php
    ├── auth/
    │   ├── login.php
    │   └── profile.php
    └── home.php

public/assets/
├── bootstrap/         # v5 lokal
├── fontawesome/       # lokal
├── css/
│   ├── tokens.css
│   ├── app.css
│   └── admin.css
└── js/
    └── app.js

docs/
├── AUDIT-STANDARDS.md
├── ui-extraction/
└── screenshots/
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

> **Catatan:** Route `/logout` saat ini memakai method GET. Best practice POST + CSRF
> direncanakan sebagai perbaikan.

## 🗃️ Skema Database

### Tabel `users`

- `id`, `nomor`, `nama`, `no_telp`, `jurusan`, `role_id`, `password`
- `created_at`, `updated_at`

Bukti: [app/Models/UserModel.php](app/Models/UserModel.php).

### Tabel `roles`

- `id`, `role_name`, `created_at`, `updated_at`

### Tabel `role_permissions`

- Relasi role dan permission untuk fondasi RBAC.
- Struktur detail mengikuti migration `RolePermissions.php`.

### Tabel `berita`

- `id`, `judul`, `slug`, `konten`, `kategori`, `gambar`, `status`
- `penulis_id`, `published_at`, `created_at`, `updated_at`, `deleted_at`

Bukti: [app/Models/BeritaModel.php](app/Models/BeritaModel.php).

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
node --check public/assets/js/app.js
composer test
```

Checklist manual:

- [ ] Login dengan nomor `admin` dan password development.
- [ ] Landing page tampil di `/` saat belum login.
- [ ] Setelah login, `/` redirect ke `/admin/dashboard`.
- [ ] Dashboard menampilkan user dan role.
- [ ] Edit profile via modal — focus trap, Escape, backdrop click berfungsi.
- [ ] Submit form dengan data invalid — error tampil dengan `aria-invalid`.
- [ ] Logout kembali ke `/login`.
- [ ] Empty state muncul di `/admin/berita` saat belum ada data.
- [ ] Create berita draft berhasil dan muncul di list.
- [ ] Edit berita menjadi `published` mengisi `published_at`.
- [ ] Delete berita memakai konfirmasi, POST, CSRF, dan soft delete.
- [ ] Pagination dan keyboard tab navigation berjalan.
- [ ] Skip-link aktif saat Tab pertama di landing page.

## 🛠️ Roadmap

- ☑ Baseline CI4 + RBAC
- ☑ Migration dan model Berita
- ☑ Layout admin, login, dan dashboard profile
- ☑ CRUD Berita end-to-end
- ☑ Landing page publik dengan CUBE CSS + design tokens
- ☑ Atomic Design: components dan partial reusable
- ☑ CUBE CSS: design tokens dan stylesheet aplikasi
- ☑ Modular JS: `app.js` dengan IIFE namespace `App`
- ☑ Audit A11y untuk modal (`role="dialog"` + focus trap)
- □ Layout admin refactor (sidebar/navbar/breadcrumb CUBE)
- □ Berita CRUD polish (a11y tabel & form)
- □ Loading state untuk form/tabel/submit
- □ CI4 View Cells
- □ File upload gambar berita
- □ User management CRUD
- □ Screenshot 10 halaman untuk laporan KP

## ⚠️ Known Issues

- Tombol logout di navbar admin sedang dalam perbaikan. Route `POST /logout` masih berfungsi via form.
- `app.js` dimuat via section `scripts` di `profile.php`, belum global di `footer.php`.
- Focus awal modal masuk ke tombol close (idealnya ke input pertama).
- Route `/logout` masih memakai method GET, belum POST + CSRF.
- Nama folder `templeting_frontend_monolith_CI` typo (seharusnya `templating`) — kosmetik.
- `app/Views/layout/admin_header.php` masih ada (sisa SSIP), tidak dipakai.

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