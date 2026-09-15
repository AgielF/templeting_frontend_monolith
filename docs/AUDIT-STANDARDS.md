# Audit Standar Ahli — UI Template

## Ringkasan
- Total file view: 10
- Standar terpenuhi penuh: 0 dari 8 kategori; beberapa kategori sudah terpenuhi sebagian.
- Cakupan: `app/Views/layout/*.php`, `app/Views/auth/*.php`, dan `app/Views/admin/**/*.php`.
- Gap utama:
  - Belum ada `views/components/`, partial `_*.php`, atau View Cells; markup layout dan kontrol masih banyak berada langsung di view.
  - CSS login dan admin lama masih inline dengan hardcode warna, ukuran, dan spacing; belum ada token CSS atau utilities proyek.
  - JavaScript masih inline di `admin_header.php`; belum ada modul JS terpisah dan ada potensi error karena elemen toggle tidak selalu tersedia.
  - Loading state belum tersedia pada form, submit button, atau tabel.
  - `admin_header.php` merupakan layout duplikat yang tidak dipakai, memakai asset path lama, markup tanpa label navigasi/A11y lengkap, dan branding lama.

## Per Ahli

### 1. Brad Frost — Atomic Design
**Status**: ⚠️ Sebagian

**Bukti di kode:**
- `app/Views/layout/main.php:1-3` — shell layout dipakai ulang melalui `include('layout/header')`, `renderSection('content')`, dan `include('layout/footer')`.
- `app/Views/layout/header.php:1-65` — navbar dan sidebar menjadi struktur bersama untuk view yang extend `layout/main`.
- `app/Views/admin/berita/form.php:14-125` — field error, form control, dan tombol memiliki pola yang dapat dipisah menjadi komponen form/field.
- `app/Views/admin/berita/index.php:20-118` dan `app/Views/admin/example/index.php:4-78` — pola toolbar, alert, card, tabel, badge, dan aksi CRUD muncul di lebih dari satu view.

**Gap:**
- Tidak ditemukan `app/Views/components/` atau partial `_*.php` untuk button, badge, alert, table action, atau form field.
- Layout `header.php` dan `admin_header.php` menduplikasi tanggung jawab navbar/sidebar; `admin_header.php` tidak dipakai oleh view yang ditemukan.
- Markup alert, card, tombol, dan tabel diulang langsung di halaman.

**Rekomendasi:**
- Buat partial kecil seperti `components/alert.php`, `components/status-badge.php`, `components/empty-state.php`, dan `components/form-field.php`.
- Hapus atau konsolidasikan `admin_header.php` setelah memastikan tidak ada consumer eksternal.
- Pertahankan `layout/main.php` sebagai shell tunggal dan gunakan partial untuk elemen berulang.

### 2. Andy Bell — CUBE CSS
**Status**: ❌ Belum

**Bukti di kode:**
- `app/Views/auth/login.php:10-171` — seluruh styling login berada di satu blok `<style>` inline, termasuk warna `#002366`, `#f4f7fa`, radius, spacing, dan responsive breakpoint.
- `app/Views/layout/admin_header.php:13-131` — seluruh styling admin lama berada di blok `<style>` inline dengan hardcode warna, shadow, ukuran sidebar, dan spacing.
- `app/Views/layout/header.php:1-8` — hanya Bootstrap dan Font Awesome yang dimuat; tidak ada stylesheet CSS aplikasi atau custom token.
- `app/Views/auth/login.php:223` — masih ada inline style `style="margin-top: 20px;"`.

**Gap:**
- Tidak ada CSS variables untuk warna, spacing, radius, typography, atau z-index.
- Tidak ada file CSS proyek yang memisahkan composition, utility, block, atau exception; asset CSS yang terdeteksi hanya vendor Bootstrap/Font Awesome.
- Hardcode CSS tersebar di view dan dua layout berbeda.

**Rekomendasi:**
- Tambahkan stylesheet aplikasi, misalnya `public/assets/css/app.css`, dengan token `:root` dan layer CUBE yang jelas.
- Pindahkan style login dan style admin ke stylesheet tersebut; hilangkan inline `style`.
- Gunakan Bootstrap utilities untuk spacing/layout dan batasi CSS custom pada block/exception yang benar-benar diperlukan.

### 3. Heydon Pickering — Inclusive Components
**Status**: ⚠️ Sebagian

**Bukti di kode:**
- `app/Views/auth/login.php:199-244` — input `nomor` dan `password` memiliki label berpasangan, `id`, `required`, autocomplete, autofocus, dan error nomor dengan `role="alert"`.
- `app/Views/admin/berita/form.php:34-122` — setiap field memiliki `<label for>`, id yang cocok, `required` pada field wajib, class `is-invalid`, `aria-describedby`, dan error `role="alert"`.
- `app/Views/auth/profile.php:60-91` — field edit profil memiliki label/id yang cocok dan `required` pada nama/nomor.
- `app/Views/layout/header.php:11` — skip-link tersedia sebelum navigasi.
- `app/Views/admin/berita/index.php:84-108` — aksi Edit/Delete diberi `aria-label` yang menyebut judul berita.

**Gap:**
- `app/Views/auth/profile.php:39` — modal tidak memiliki `role="dialog"`; hanya memakai `aria-labelledby` dan `aria-hidden`.
- `app/Views/admin/example/index.php:42-77` — modal memiliki `aria-labelledby`, tetapi tidak memiliki `role="dialog"`; tombol tambah juga tidak memiliki atribut `aria-expanded`/`aria-controls` karena bukan trigger yang lengkap.
- `app/Views/layout/admin_header.php:145-193` — layout lama memiliki ikon navigasi tanpa `aria-hidden`, nav tanpa `aria-label`, dan tombol toggle berupa ikon tanpa label.
- Tidak semua halaman memiliki empty/error/loading treatment yang setara; loading state tidak ada.

**Rekomendasi:**
- Tambahkan `role="dialog"` pada modal dan pastikan focus management Bootstrap tetap dapat bekerja.
- Audit seluruh tombol/icon link, khususnya `admin_header.php` dan `example/index.php`.
- Tambahkan `aria-live`/status yang sesuai untuk feedback async atau submit state bila JavaScript modular ditambahkan.

### 4. Addy Osmani — JavaScript Design Patterns
**Status**: ❌ Belum

**Bukti di kode:**
- `app/Views/layout/admin_header.php:198-213` — JavaScript toggle sidebar ditulis inline di layout.
- Tidak ditemukan file JavaScript aplikasi pada asset proyek; asset JS yang ada berasal dari Bootstrap vendor.
- `app/Views/admin/berita/index.php:1-120` — aksi delete menggunakan inline handler `onsubmit="return confirm(...)"`.
- `app/Views/admin/example/index.php:56` — aksi delete juga menggunakan inline handler.

**Gap:**
- Tidak ada modul JS terpisah, initializer, event delegation, atau namespace aplikasi.
- Inline event handlers mencampur behavior dengan markup dan menyulitkan pengujian.
- `admin_header.php:202-204` mengasumsikan `sidebarToggle` selalu ada; tanpa elemen tersebut `addEventListener` dapat melempar error.
- Belum ada pola loading/disabled submit untuk mencegah double-submit.

**Rekomendasi:**
- Buat `public/assets/js/app.js` atau modul per fitur dengan namespace tunggal, misalnya `window.App` hanya bila benar-benar diperlukan.
- Pindahkan confirm delete, sidebar toggle, dan loading submit ke event listener terpusat.
- Gunakan progressive enhancement: form tetap bekerja tanpa JS, JS hanya menambah confirmation/loading.

### 5. Vitaly Friedman — UX States
**Status**: ⚠️ Sebagian

**Bukti di kode:**
- `app/Views/admin/berita/index.php:37-51` — empty state memiliki icon, heading, penjelasan, dan CTA `Tambah Berita Pertama`.
- `app/Views/admin/example/index.php:23-25` — tabel memiliki empty row `Data tidak ditemukan.`.
- `app/Views/admin/berita/index.php:21-35` — terdapat success, error, dan validation alert.
- `app/Views/admin/berita/form.php:21-31` — terdapat global error dan field error.
- `app/Views/auth/profile.php:52-58` — terdapat error alert untuk update profil.

**Gap:**
- Tidak ada loading state pada submit button, form, tabel, pagination, atau navigasi halaman.
- `app/Views/admin/example/index.php:14` hanya menampilkan flash success; error dan validation feedback belum ditangani secara konsisten.
- `app/Views/layout/header.php` tidak menyediakan state untuk menu/sidebar saat navigasi atau toggle.
- Error state masih bergantung pada session flash dan belum memiliki pola komponen bersama.

**Rekomendasi:**
- Tambahkan state submit `aria-busy`, disabled button, dan label proses melalui JS progressive enhancement.
- Standarkan alert success/error/validation dan empty state sebagai partial reusable.
- Sediakan state error yang jelas untuk kegagalan pemuatan list atau pagination bila endpoint mulai memakai AJAX.

### 6. Lonnie Ezell — CI4 View Cells
**Status**: ❌ Belum

**Bukti di kode:**
- `app/Views/layout/main.php:1-3` — komposisi view masih memakai `$this->include()` dan `$this->renderSection()`.
- `app/Views/layout/header.php:1-65` dan `app/Views/layout/footer.php:1-7` — layout dirakit sebagai include biasa.
- `app/Views` tidak memiliki file `components/` atau partial `_*.php` berdasarkan inventaris audit.

**Gap:**
- Tidak ditemukan View Cell.
- Tidak ditemukan partial bernama `_xxx.php`.
- Header, footer, alert, status badge, empty state, dan table actions belum diekstrak sebagai unit reusable.

**Rekomendasi:**
- Gunakan View Cells hanya untuk komponen yang benar-benar mengambil/menyiapkan data berulang, misalnya user menu atau notification/status summary.
- Untuk markup sederhana gunakan partial `_alert.php`, `_status_badge.php`, `_empty_state.php`, dan `_pagination.php`.
- Dokumentasikan batas antara controller data preparation, View Cell, partial, dan view halaman.

### 7. Scott O'Hara / Steve Faulkner — WAI-ARIA
**Status**: ⚠️ Sebagian

**Bukti di kode:**
- `app/Views/layout/header.php:11` — skip-link ke `#main`.
- `app/Views/layout/header.php:13,24,43,50` — nav/landmark diberi `aria-label`, dropdown memiliki `aria-haspopup` dan `aria-expanded`, ikon dekoratif memakai `aria-hidden`, dan menu aktif memakai `aria-current="page"` pada baris 55.
- `app/Views/admin/berita/index.php:60-69` — semua header tabel memiliki `scope="col"`.
- `app/Views/auth/login.php:194-199` — error flash memakai `role="alert"`; ikon dekoratif diberi `aria-hidden`.
- `app/Views/admin/berita/form.php:34-122` — field error dirujuk melalui `aria-describedby` dan `role="alert"`.
- `app/Views/admin/example/index.php:65-77` — label/id form dan `aria-labelledby` modal sudah tersedia.

**Gap:**
- `app/Views/auth/profile.php:39` dan `app/Views/admin/example/index.php:42` — modal belum memiliki `role="dialog"`.
- `app/Views/admin/example/index.php:6-8,52-60` — beberapa ikon di tombol bukan icon-only tetapi belum konsisten memakai `aria-hidden`; tombol delete berbasis ikon tidak memiliki `aria-label`.
- `app/Views/layout/admin_header.php:145-193` — ikon dan navigasi belum diberi atribut ARIA yang memadai.
- `app/Views/layout/footer.php:1-7` — tidak ada elemen `<footer>` atau landmark footer.
- Tabel `admin/example/index.php:11-19` memiliki `scope="col"`, tetapi empty state hanya teks dan tidak ada status live.

**Rekomendasi:**
- Tambahkan `role="dialog"` pada semua modal dan audit trigger/close/focus behavior.
- Tambahkan `aria-label` pada semua tombol icon-only dan `aria-hidden="true"` pada ikon dekoratif.
- Konsolidasikan layout aktif dan hapus audit debt dari `admin_header.php` atau tandai jelas sebagai dead code.
- Tambahkan landmark `<footer>` bila footer memang menjadi bagian shell.

### 8. Semantik HTML
**Status**: ⚠️ Sebagian

**Bukti di kode:**
- `app/Views/layout/header.php:13,45,49,60` — terdapat `<nav>` berlabel, `<aside>`, dan `<main id="main">`.
- `app/Views/admin/berita/index.php:58-72` — tabel memakai struktur `<table>`, `<thead>`, `<tbody>`, dan heading tabel dengan scope.
- `app/Views/admin/dashboard.php:4,9` dan `app/Views/admin/berita/index.php:15,39` — halaman utama memiliki heading `h1` dan heading turunan.
- `app/Views/auth/login.php:188-191` — halaman login memiliki hierarchy `h1` lalu `h2`.

**Gap:**
- `app/Views/layout/header.php:10-13` — tidak ada elemen `<header>` yang membungkus navbar.
- `app/Views/layout/footer.php:1-7` — tidak ada elemen `<footer>`.
- `app/Views/layout/main.php:1-3` hanya merakit shell dan bergantung pada `<main>` yang dibuka di `header.php`; batas tanggung jawab markup menjadi tidak intuitif.
- `app/Views/auth/profile.php:43-49` memakai `h4` tanpa `h1` pada halaman tersebut karena title halaman berasal dari layout `<title>`, bukan heading visual.
- `app/Views/admin/example/index.php:4` memakai `h1`, tetapi modal title memakai `h5` tanpa struktur section yang jelas.
- `app/Views/layout/admin_header.php:145-193` memakai `<aside>` dan `<header>`, tetapi tidak memakai `<nav aria-label>` dan menggunakan list navigasi mentah.

**Rekomendasi:**
- Jadikan layout shell eksplisit: `<header>`, `<nav>`, `<aside><nav>`, `<main id="main">`, dan `<footer>`.
- Pastikan setiap halaman memiliki satu `h1`; turunkan heading secara berurutan.
- Hindari membuka `<main>` di satu include dan menutupnya di include lain bila dapat dibuat lebih jelas di `main.php`.

## Per File

### app/Views/layout/header.php
- **Atomic**: ⚠️ — shell navbar/sidebar reusable melalui `layout/main`, tetapi belum dipisah menjadi partial komponen; lihat baris 13-65.
- **CUBE CSS**: ⚠️ — memakai Bootstrap, tetapi tidak ada token CSS aplikasi atau stylesheet custom; asset dimuat di baris 7-8.
- **A11y**: ✅ sebagian kuat — skip-link di baris 11, nav label di baris 13 dan 49, dropdown ARIA di baris 24-25, ikon hidden di baris 17, 26, 56.
- **Semantik**: ⚠️ — nav, aside, dan main tersedia di baris 13, 45, 49, 60, tetapi tidak ada elemen `<header>`/`footer` pada shell.
- **UX**: ⚠️ — menu aktif tersedia, tetapi tidak ada loading/error state untuk navigasi.
- **Catatan**: `main` dibuka di baris 60 dan ditutup oleh `footer.php`, sehingga struktur tersebar lintas include.

### app/Views/layout/admin_header.php
- **Atomic**: ❌ — layout kedua menduplikasi header/sidebar; tidak direferensikan oleh view target yang ditemukan.
- **CUBE CSS**: ❌ — blok `<style>` besar di baris 13-131 dengan hardcode warna/ukuran; tidak ada token.
- **A11y**: ❌/⚠️ — sidebar baris 145-193 tidak memiliki nav label; ikon toggle baris 198 tidak memiliki label; ikon menu tidak memakai `aria-hidden`.
- **Semantik**: ⚠️ — memiliki aside/header di baris 145 dan 196, tetapi landmark navigasi tidak lengkap.
- **JS**: ❌ — script inline baris 198-213; memakai global DOM lookup dan event handler langsung.
- **Rekomendasi**: konsolidasikan atau hapus setelah verifikasi consumer; jangan biarkan dua shell admin hidup berdampingan.

### app/Views/layout/main.php
- **Atomic**: ✅ sebagian — menjadi wrapper reusable dengan include header/footer di baris 1 dan 3.
- **CUBE CSS**: ✅ sebagian — tidak menambah CSS inline.
- **A11y/Semantik**: ⚠️ — tidak menghasilkan landmark sendiri; bergantung pada header untuk membuka `<main>`.
- **UX**: ⚠️ — tidak menyediakan loading/error boundary.
- **Rekomendasi**: pindahkan struktur `<main id="main">` ke file ini agar shell utuh dan mudah diaudit.

### app/Views/layout/footer.php
- **Atomic**: ✅ sebagian — partial footer/script yang dipakai layout utama, baris 1-7.
- **CUBE CSS**: ✅ sebagian — tidak memiliki CSS inline.
- **A11y/Semantik**: ❌/⚠️ — tidak ada elemen `<footer>`; hanya menutup container/main dan memuat script.
- **JS**: ⚠️ — memuat Bootstrap bundle vendor di baris 5, tetapi tidak ada modul aplikasi.
- **Rekomendasi**: tambahkan landmark footer bila memang dibutuhkan dan pertahankan script vendor di satu tempat.

### app/Views/auth/login.php
- **Atomic**: ⚠️ — form dan alert belum diekstrak; pola alert/form field berpotensi dipakai ulang.
- **CUBE CSS**: ❌ — CSS inline besar baris 10-171; ada inline style baris 223; hardcode token pada warna, radius, spacing, breakpoint.
- **A11y**: ✅ sebagian — label/id, required, autocomplete, autofocus, role alert, dan aria-describedby di baris 194-244.
- **Semantik**: ✅ sebagian — standalone document dengan `h1` baris 188 dan `h2` baris 189; belum ada landmark form bernama selain `aria-label`.
- **UX**: ⚠️ — flash error ada di baris 193-197, tetapi loading/submit state tidak ada.
- **JS**: ✅ — tidak ada script aplikasi inline.
- **Rekomendasi**: pindahkan CSS ke file custom, gunakan class utility, tambahkan submit loading/disabled secara progressive enhancement.

### app/Views/auth/profile.php
- **Atomic**: ⚠️ — profile card dan modal langsung ditulis; belum ada partial modal/form field.
- **CUBE CSS**: ✅ sebagian — memanfaatkan Bootstrap classes, tidak ada `<style>` lokal.
- **A11y**: ⚠️ — label/id form dan error alert tersedia di baris 52-91; modal baris 39 tidak memiliki `role="dialog"`.
- **Semantik**: ⚠️ — memakai `dl/dt/dd` baris 19-32, tetapi heading dimulai dari `h4` baris 8 tanpa h1 halaman.
- **UX**: ⚠️ — error state baris 52-58 tersedia; loading state tidak ada.
- **JS**: ✅ sebagian — behavior modal diserahkan ke Bootstrap, tidak ada script custom.
- **Rekomendasi**: tambahkan `role="dialog"`, rapikan hierarchy heading, ekstrak modal/form field bila pola dipakai lagi.

### app/Views/admin/dashboard.php
- **Atomic**: ⚠️ — memakai layout/card Bootstrap tetapi tidak memakai partial profile card.
- **CUBE CSS**: ✅ sebagian — class utility Bootstrap dominan, tanpa CSS lokal.
- **A11y**: ✅ sebagian — empty/error state baris 6-7 memakai `role="alert"`; link teks jelas.
- **Semantik**: ✅ sebagian — h1 baris 5 dan h2 baris 9 berurutan.
- **UX**: ⚠️ — fallback error data user ada, tetapi loading state tidak ada.
- **Rekomendasi**: ekstrak profile summary jika akan dipakai di dashboard/profile; pertimbangkan status loading hanya bila data dimuat async.

### app/Views/admin/example/index.php
- **Atomic**: ⚠️ — CRUD card/modal adalah pola yang dapat dipakai ulang, tetapi masih inline dan berdiri sendiri.
- **CUBE CSS**: ✅ sebagian — Bootstrap utilities dipakai; tidak ada token CSS aplikasi.
- **A11y**: ⚠️ — label/id lengkap baris 49-77, modal `aria-labelledby` baris 42, tetapi modal belum `role="dialog"` dan tombol delete icon-only baris 34-38 belum punya `aria-label`.
- **Semantik**: ✅ sebagian — h1 baris 4, tabel thead/tbody dan scope col baris 11-19.
- **UX**: ⚠️ — empty state baris 23-25 dan success flash baris 8-10 ada; error/loading state tidak lengkap.
- **JS**: ⚠️ — confirm inline baris 34; tidak ada loading state.
- **Rekomendasi**: gunakan partial table/action/modal, tambahkan error alert dan accessible delete action.

### app/Views/admin/berita/index.php
- **Atomic**: ⚠️ — alert, empty state, status badge, dan aksi tabel belum reusable.
- **CUBE CSS**: ✅ sebagian — Bootstrap utilities dipakai, tanpa CSS inline; token proyek belum ada.
- **A11y**: ✅ sebagian kuat — alert baris 21-35, empty icon hidden baris 39, `th scope="col"` baris 60-66, icon-only action label baris 91-104, pagination nav label baris 114.
- **Semantik**: ✅ — h1 baris 15, table/thead/tbody baris 58-72, nav pagination baris 114.
- **UX**: ✅ sebagian — success/error/validation state dan empty state lengkap; loading state tidak ada.
- **JS**: ⚠️ — delete masih inline `onsubmit` baris 98.
- **Rekomendasi**: ekstrak alert/status/empty state dan pindahkan confirm ke JS modular; pertimbangkan `aria-live` untuk feedback.

### app/Views/admin/berita/form.php
- **Atomic**: ⚠️ — form field/error pattern cukup konsisten tetapi belum menjadi partial.
- **CUBE CSS**: ✅ sebagian — Bootstrap classes dipakai, tidak ada CSS inline; belum ada design token custom.
- **A11y**: ✅ — label/id, required, autofocus create, aria-describedby, dan field `role="alert"` baris 34-122.
- **Semantik**: ✅ sebagian — h1 baris 18, form dan label semantik; tidak ada loading state.
- **UX**: ✅ sebagian — global error baris 21-31 dan field error tersedia; no-submit/loading state.
- **JS**: ✅ — tidak ada custom script.
- **Rekomendasi**: ekstrak field error/form control jika form lain bertambah; tambahkan progressive enhancement untuk disabled/loading submit.

## Gap Prioritas

1. **Konsolidasi layout dan dead code**: `header.php` adalah shell aktif, sementara `admin_header.php` menduplikasi shell dan memiliki audit debt besar.
2. **A11y modal/action**: tambahkan `role="dialog"`, lengkapi label icon-only, dan audit keyboard/focus behavior pada semua modal.
3. **CSS architecture**: pindahkan CSS inline login/admin ke stylesheet custom dengan design tokens CUBE CSS.
4. **JavaScript architecture**: keluarkan inline handler dan script ke modul JS dengan event listener terpusat serta loading/disabled submit state.
5. **Reusable UI**: buat partial/components untuk alert, badge, empty state, pagination, modal, dan table actions.
6. **Semantic shell**: rapikan `<header>`, `<main>`, `<aside>`, `<nav>`, dan `<footer>` agar tidak dibuka/ditutup lintas include secara tersebar.

## Roadmap Perbaikan

- **Jangka pendek (30 menit):** tambahkan `role="dialog"` pada modal profile/example, beri `aria-label` pada tombol icon-only, tandai ikon dekoratif dengan `aria-hidden`, dan tambahkan `role="alert"` pada error example.
- **Jangka menengah (2 jam):** konsolidasikan `admin_header.php` dengan shell aktif, pindahkan CSS inline login/admin ke `public/assets/css/app.css`, buat token warna/spacing/radius, dan buat partial `_alert.php`, `_empty_state.php`, `_status_badge.php`.
- **Jangka menengah (2 jam):** buat `public/assets/js/app.js` untuk confirm delete, sidebar/dropdown enhancement, serta submit loading state dengan progressive enhancement.
- **Jangka panjang:** evaluasi View Cells untuk komponen yang membutuhkan data berulang, tambahkan automated accessibility checks, audit keyboard/focus trap modal, dan standardisasi semantic heading/landmark seluruh halaman.
