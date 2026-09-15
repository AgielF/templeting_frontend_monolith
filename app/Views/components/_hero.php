<section class="hero" aria-labelledby="hero-heading">
    <div class="container-public hero__grid">
        <div class="hero__content" data-reveal>
            <p class="hero__eyebrow"><?= esc($eyebrow ?? 'Admin template untuk workflow yang lebih jelas') ?></p>
            <h1 id="hero-heading"><?= esc($title ?? 'Intellimart Admin Template') ?></h1>
            <p class="hero__copy"><?= esc($description ?? 'Fondasi admin panel CodeIgniter 4 dengan autentikasi, RBAC, profile pengguna, dan CRUD Berita & Kegiatan.') ?></p>
            <div class="hero__actions cluster">
                <a class="btn-cta" href="<?= base_url('login') ?>">
                    <?= esc($primaryLabel ?? 'Masuk ke Admin Panel') ?>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="btn-cta btn-cta--secondary" href="#fitur">
                    <?= esc($secondaryLabel ?? 'Lihat Fitur') ?>
                </a>
            </div>
        </div>

        <div class="hero__visual" data-reveal aria-label="Ringkasan teknologi template">
            <div class="hero__visual-mark" aria-hidden="true">
                <i class="fas fa-layer-group"></i>
            </div>
            <p class="eyebrow mb-0">Built for the next workflow</p>
            <h2>Struktur yang siap dikembangkan.</h2>
            <p class="mb-0">Komponen terukur, aksesibilitas yang terlihat, dan fondasi backend yang rapi.</p>
        </div>
    </div>
</section>
