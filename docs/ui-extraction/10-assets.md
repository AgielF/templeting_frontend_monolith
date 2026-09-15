# Assets

## Sumber Pemindaian
- Path: `public/assets/`

## Ringkasan
- `public/assets/bootsrap/` ditemukan dan merupakan typo yang berisi salinan Bootstrap.
- `public/assets/bootstrap/` juga ditemukan sebagai folder dengan ejaan benar.
- `fontawesome/`, `fonts/`, dan `images/` tersedia.
- Logo: `public/assets/images/GambarLogo.jpg`.
- Font: `public/assets/fonts/OpenSans-Bold.ttf`.

## Referensi path yang terlihat
- Beberapa view memakai `assets/bootsrap/...` atau `assets/vendor/bootstrap/...`; path harus dinormalisasi saat porting.

## Keputusan Porting
- Jangan menyalin folder typo `bootsrap/` ke target.
- Target sudah memiliki `bootstrap/`, `fontawesome/`, dan `fonts/`.
- Salin hanya gambar/logo atau CSS/JS kustom yang benar-benar belum tersedia.
- Audit ulang `base_url()` dan `site_url()` agar tidak ada hard-coded path.
