# Navbar Publik

## Sumber
- Path: `app/Views/layout/header.php`
- Ukuran: 462 baris
- Asset yang di-link: `assets/bootsrap/css/bootstrap.min.css`, Font Awesome, `assets/images/GambarLogo.jpg`

## Kode UI (verbatim)
```php
<!-- Top Header Navigation -->
<header class="top-header">
	<div class="header-left">
		<i class="fas fa-bars menu-toggle"></i>
		<a class="navbar-brand ms-3 " href="/"">
			<img src="<?= base_url('assets/images/GambarLogo.jpg') ?>" alt="Logo Lab" style="height: 71px;">
		</a>
	</div>
	<ul class="navbar-nav flex-row">
		<li class="nav-item">
			<a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Home</a>
		</li>
		<?php if ($user): ?>
		<li class="nav-item">
			<a class="nav-link" href="/profile"><i class="fas fa-user"></i>Profile</a>
		</li>
		<li class="nav-item">
			<form action="/logout" method="POST" id="form-logout" style="display: none;">
				<?= csrf_field() ?>
			</form>
			<a class="nav-link" href="#" onclick="if(confirm('Yakin ingin logout?')) { document.getElementById('form-logout').submit(); } return false;">
				<i class="fas fa-right-from-bracket me-1"></i>Logout
			</a>
		</li>
		<?php else: ?>
		<li class="nav-item">
			<a class="nav-link" href="/login"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
		</li>
		<?php endif; ?>
		<li class="nav-item">
			<a class="nav-link" href="/asisten"><i class="fas fa-users me-1"></i>Anggota</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/contact"><i class="fas fa-address-book me-1"></i>Contact</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/organisasi"><i class="fas fa-address-book me-1"></i>Struktur Organisasi</a>
		</li>
	</ul>
</header>

[dipotong di sini — baris 1 sampai 390 dan 430 sampai 462 dari file asli]
```

Catatan: sumber memakai elemen `<header>` dengan `<ul>` untuk topbar, bukan elemen `<nav>` literal. Blok di atas adalah salinan verbatim bagian navigasi dan conditional login/logout dari `app/Views/layout/header.php`.

## Variabel yang Dipakai
| Variabel | Sumber (controller/session) | Keterangan |
|---|---|---|
| `session()->get('logged_in')` | Session | Menentukan navbar login/logout |
| `session()->get('nama')` | Session | Label pengguna bila tersedia |

## Form & Aksi
- Login: `/login`, metode GET melalui tautan.
- Logout/profile: ditentukan oleh tautan pada navbar.

## Struktur HTML Penting
- Root navigasi Bootstrap, brand/logo kampus, menu publik, conditional auth.
- Ikon memakai Font Awesome.

## Catatan A11y Saat Ini
- label for/id: tidak berlaku untuk navbar.
- aria-*: sebagian, perlu audit menu toggle.
- role: tidak konsisten.
- Heading hierarchy: bukan tanggung jawab komponen navbar.

## Catatan Branding SSIP
- Teks/logo/nama kampus: SSIP/ITENAS dan `GambarLogo.jpg`.
- Wajib diganti saat porting: ya, logo dan nama aplikasi.
