# Sidebar

## Sumber
- Path: `app/Views/layout/admin_header.php`
- Ukuran: 218 baris
- Asset yang di-link: Bootstrap dan Font Awesome.

## Kode UI (verbatim)
```php
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
```

## Variabel yang Dipakai
| Variabel | Sumber (controller/session) | Keterangan |
|---|---|---|
| session user/role | Session dan filter permission | Menentukan akses menu |
| URL menu | Hard-coded pada view | Link modul admin |

## Form & Aksi
- Link menu, bukan form.
- Toggle sidebar memakai JavaScript pada file sumber.

## Struktur HTML Penting
- Sidebar/collapse, item menu, ikon Font Awesome.
- Target porting diminta hanya menu Berita dan Kegiatan.

## Catatan A11y Saat Ini
- label for/id: tidak berlaku.
- aria-*: toggle perlu `aria-expanded` dan `aria-controls`.
- role: tambahkan `nav`/label navigasi.
- Heading hierarchy: tidak ada heading konten yang dijamin.

## Catatan Branding SSIP
- Menu dan nama modul SSIP perlu diseleksi ulang.
- Wajib diganti saat porting: ya untuk menu yang tidak ada di template target.
