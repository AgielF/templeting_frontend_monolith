<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= esc($title ?? 'Admin Panel') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>
<a href="#main" class="visually-hidden-focusable">Lewati ke konten utama</a>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Navigasi utama admin">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-layer-group me-2" aria-hidden="true"></i>Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Buka navigasi admin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <div class="ms-auto dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle me-1" aria-hidden="true"></i>
                    <?= esc(session('nama') ?? 'User') ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 bg-light min-vh-100 py-3" aria-label="Menu utama">
            <?php
            $currentPath = service('request')->getUri()->getPath();
            $isActive = str_starts_with($currentPath, '/admin/berita');
            ?>
            <nav aria-label="Navigasi admin">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $isActive ? 'active' : '' ?>"
                       href="<?= base_url('admin/berita') ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                        <i class="fas fa-newspaper me-2" aria-hidden="true"></i>
                        <span>Berita &amp; Kegiatan</span>
                    </a>
                </li>
            </ul>
            </nav>
        </aside>
        <main id="main" class="col-md-10 py-3">
