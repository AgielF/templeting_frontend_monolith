<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$isEdit = ($mode ?? 'create') === 'edit';
$article = $berita ?? [];
$errors = session('errors') ?? [];
$globalError = session()->getFlashdata('error');
$fieldError = static function (string $field) use ($errors): string {
    return is_array($errors) ? (string) ($errors[$field] ?? '') : '';
};
$value = static function (string $field) use ($article): string {
    return esc(old($field, $article[$field] ?? ''));
};
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= $isEdit ? 'Edit Berita' : 'Tambah Berita' ?></h1>
        <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Kembali
        </a>
    </div>

    <?php if ($globalError): ?>
        <div class="alert alert-danger" role="alert"><?= esc($globalError) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors) && !is_array($errors)): ?>
        <div class="alert alert-danger" role="alert"><?= esc($errors) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= $isEdit ? base_url('admin/berita/update/' . (int) $article['id']) : base_url('admin/berita/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" id="judul" name="judul"
                           class="form-control<?= $fieldError('judul') ? ' is-invalid' : '' ?>"
                           value="<?= $value('judul') ?>" maxlength="200" required<?= $isEdit ? '' : ' autofocus' ?>
                           aria-describedby="judul-error">
                    <?php if ($fieldError('judul')): ?>
                        <div id="judul-error" class="invalid-feedback" role="alert"><?= esc($fieldError('judul')) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug <span class="text-muted">(opsional)</span></label>
                    <input type="text" id="slug" name="slug"
                           class="form-control<?= $fieldError('slug') ? ' is-invalid' : '' ?>"
                           value="<?= $value('slug') ?>" maxlength="220"
                           aria-describedby="slug-error">
                    <?php if ($fieldError('slug')): ?>
                        <div id="slug-error" class="invalid-feedback" role="alert"><?= esc($fieldError('slug')) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="konten" class="form-label">Konten</label>
                    <textarea id="konten" name="konten" rows="8"
                              class="form-control<?= $fieldError('konten') ? ' is-invalid' : '' ?>"
                              minlength="10" required aria-describedby="konten-error"><?= $value('konten') ?></textarea>
                    <?php if ($fieldError('konten')): ?>
                        <div id="konten-error" class="invalid-feedback" role="alert"><?= esc($fieldError('konten')) ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select id="kategori" name="kategori"
                                class="form-select<?= $fieldError('kategori') ? ' is-invalid' : '' ?>"
                                required aria-describedby="kategori-error">
                            <?php $selectedCategory = old('kategori', $article['kategori'] ?? 'umum'); ?>
                            <?php foreach (['umum', 'akademik', 'pengumuman', 'kegiatan'] as $category): ?>
                                <option value="<?= esc($category) ?>"<?= $selectedCategory === $category ? ' selected' : '' ?>>
                                    <?= esc(ucfirst($category)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($fieldError('kategori')): ?>
                            <div id="kategori-error" class="invalid-feedback" role="alert"><?= esc($fieldError('kategori')) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <?php $selectedStatus = old('status', $article['status'] ?? 'draft'); ?>
                        <select id="status" name="status"
                                class="form-select<?= $fieldError('status') ? ' is-invalid' : '' ?>"
                                required aria-describedby="status-error">
                            <option value="draft"<?= $selectedStatus === 'draft' ? ' selected' : '' ?>>Draft</option>
                            <option value="published"<?= $selectedStatus === 'published' ? ' selected' : '' ?>>Published</option>
                        </select>
                        <?php if ($fieldError('status')): ?>
                            <div id="status-error" class="invalid-feedback" role="alert"><?= esc($fieldError('status')) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">Path Gambar <span class="text-muted">(opsional)</span></label>
                    <input type="text" id="gambar" name="gambar"
                           class="form-control<?= $fieldError('gambar') ? ' is-invalid' : '' ?>"
                           value="<?= $value('gambar') ?>" maxlength="255"
                           aria-describedby="gambar-error">
                    <?php if ($fieldError('gambar')): ?>
                        <div id="gambar-error" class="invalid-feedback" role="alert"><?= esc($fieldError('gambar')) ?></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1" aria-hidden="true"></i>
                        <?= $isEdit ? 'Update' : 'Simpan' ?>
                    </button>
                    <a href="<?= base_url('admin/berita') ?>" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
