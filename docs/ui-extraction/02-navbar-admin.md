# Navbar Admin

## Sumber
- Path: `app/Views/layout/admin_header.php`
- Ukuran: 218 baris
- Asset yang di-link: Bootstrap, Font Awesome, kemungkinan stylesheet admin.

## Kode UI (verbatim)
```php
<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-header">
        <span>Admin Menu</span>
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= (uri_string() == 'admin') ? 'active' : '' ?>" href="/admin">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/rekrut') !== false) ? 'active' : '' ?>" href="/admin/rekrut">
                <i class="fas fa-user-plus"></i>Rekrutmen
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/proyek-riset') !== false) ? 'active' : '' ?>" href="/admin/proyek-riset">
                <i class="fas fa-project-diagram"></i>Proyek Riset
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/berita') !== false) ? 'active' : '' ?>" href="/admin/berita">
                <i class="fas fa-newspaper"></i>Berita
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>" href="/admin/users">
                <i class="fas fa-users"></i>Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (strpos(uri_string(), 'admin/roles') !== false) ? 'active' : '' ?>" href="/admin/roles">
                <i class="fas fa-user-tag"></i>Roles
            </a>
        </li>
    </ul>
</aside>

<!-- Top Header Navigation -->
<header class="top-header">
    <div class="header-left">
        <i class="fas fa-bars menu-toggle" id="sidebarToggle"></i>
        <a class="navbar-brand ms-3" href="/admin">
            Admin Panel
        </a>
    </div>
    <ul class="navbar-nav flex-row">
        <li class="nav-item">
            <a class="nav-link" href="/"><i class="fas fa-home me-1"></i>Frontend</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-user me-1"></i>Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
        </li>
    </ul>
</header>
```

## Variabel yang Dipakai
| Variabel | Sumber (controller/session) | Keterangan |
|---|---|---|
| `session()` | Session CI4 | Identitas dan status pengguna admin |
| `$title` | Controller/view data | Judul halaman bila dikirim |

## Form & Aksi
- Navigasi admin menuju modul-modul pengelolaan.
- Profile dan logout perlu dipastikan dari bagian header aktual saat porting.

## Struktur HTML Penting
- Header admin dengan tombol toggle sidebar.
- Navigasi responsif Bootstrap; sidebar dikendalikan JavaScript `classList.toggle('collapsed')`.

## Catatan A11y Saat Ini
- label for/id: tidak berlaku untuk semua kontrol; tombol toggle perlu label.
- aria-*: perlu ditambahkan pada toggle/sidebar.
- role: belum konsisten.
- Heading hierarchy: tidak menjadi fokus layout.

## Catatan Branding SSIP
- Label SSIP/ITENAS dan ikon admin dapat muncul.
- Wajib diganti saat porting: ya untuk brand; menu bisnis dipertahankan sesuai target.
