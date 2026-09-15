<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Intellimart Admin Template, fondasi admin panel CodeIgniter 4 dengan RBAC dan modul Berita.">
    <title>Intellimart Admin Template — CI4 + RBAC + Bootstrap 5</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tokens.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <a href="#main" class="visually-hidden-focusable">Lewati ke konten utama</a>

    <?= view('components/_navbar-public') ?>

    <main id="main">
        <?= view('components/_hero', [
            'eyebrow' => 'Admin panel yang siap bertumbuh',
            'title' => 'Bangun workflow admin yang lebih fokus.',
            'description' => 'Intellimart Admin Template menyatukan fondasi CodeIgniter 4, autentikasi, RBAC, dan komponen UI yang dapat dikembangkan tanpa kehilangan kejelasan.',
            'primaryLabel' => 'Masuk ke Admin Panel',
            'secondaryLabel' => 'Lihat Fitur',
        ]) ?>

        <section id="fitur" class="section" aria-labelledby="fitur-heading">
            <div class="container-public">
                <div class="section__heading" data-reveal>
                    <h2 id="fitur-heading">Fitur Utama</h2>
                    <p>Fondasi praktis untuk tim yang membutuhkan admin panel rapi, aman, dan mudah diperluas.</p>
                </div>
                <div class="grid-auto">
                    <?= view('components/_feature-card', [
                        'icon' => 'fa-shield-alt',
                        'title' => 'Login Aman',
                        'description' => 'Session-based authentication dengan identifier nomor dan proteksi route admin.',
                    ]) ?>
                    <?= view('components/_feature-card', [
                        'icon' => 'fa-users-cog',
                        'title' => 'RBAC',
                        'description' => 'Roles, permissions, dan filter auth menjadi fondasi akses yang terukur.',
                        'highlight' => true,
                    ]) ?>
                    <?= view('components/_feature-card', [
                        'icon' => 'fa-newspaper',
                        'title' => 'CRUD Berita',
                        'description' => 'Kelola berita dan kegiatan dengan slug, status, pagination, serta soft delete.',
                    ]) ?>
                    <?= view('components/_feature-card', [
                        'icon' => 'fa-universal-access',
                        'title' => 'Aksesibilitas',
                        'description' => 'Skip-link, semantic HTML, label form, dan atribut ARIA hadir di alur utama.',
                    ]) ?>
                </div>
            </div>
        </section>

        <section id="tech" class="section section--alt" aria-labelledby="tech-heading">
            <div class="container-public">
                <div class="section__heading" data-reveal>
                    <h2 id="tech-heading">Teknologi</h2>
                    <p>Stack lokal yang sederhana untuk development cepat dan deployment yang mudah dikendalikan.</p>
                </div>
                <ul class="tech-list" data-reveal>
                    <li>CodeIgniter 4.7.4</li>
                    <li>PHP 8.5</li>
                    <li>MySQL</li>
                    <li>Bootstrap 5</li>
                    <li>Font Awesome</li>
                </ul>
            </div>
        </section>

        <section id="cta" class="section section--highlight text-center" aria-labelledby="cta-heading">
            <div class="container-public" data-reveal>
                <h2 id="cta-heading">Siap mulai?</h2>
                <p>Masuk ke workspace admin untuk mengelola profil dan berita.</p>
                <a href="<?= base_url('login') ?>" class="btn-cta">
                    Masuk ke Admin Panel
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </section>
    </main>

    <?= view('components/_footer-public') ?>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
