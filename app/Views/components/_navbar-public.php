<header class="public-header">
    <nav class="public-navbar" aria-label="Navigasi utama">
        <div class="container-public public-navbar__inner cluster">
            <a class="public-navbar__brand" href="<?= base_url('/') ?>" aria-label="Intellimart Admin Template, beranda">
                <span class="public-navbar__brand-mark" aria-hidden="true">
                    <i class="fas fa-layer-group"></i>
                </span>
                <span>Intellimart Admin</span>
            </a>

            <button class="public-navbar__toggle" type="button" data-nav-toggle
                    aria-controls="public-navigation" aria-expanded="false">
                <span class="visually-hidden">Buka navigasi</span>
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <ul class="public-navbar__links" id="public-navigation" data-nav-links>
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#tech">Teknologi</a></li>
                <li><a class="btn-cta" href="<?= base_url('login') ?>">Masuk</a></li>
            </ul>
        </div>
    </nav>
</header>
