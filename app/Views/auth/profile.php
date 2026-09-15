<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle me-2 text-primary" aria-hidden="true"></i>Profil Saya
                </h4>

                <form action="<?= base_url('logout') ?>" method="POST" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-right-from-bracket me-1" aria-hidden="true"></i> Logout
                    </button>
                </form>
            </div>

            <dl class="row mb-4">
                <dt class="col-sm-4">Nama</dt>
                <dd class="col-sm-8"><?= esc($user['nama'] ?? '-') ?></dd>

                <dt class="col-sm-4">Nomor</dt>
                <dd class="col-sm-8"><?= esc($user['nomor'] ?? '-') ?></dd>

                <dt class="col-sm-4">Nomor Telepon</dt>
                <dd class="col-sm-8"><?= esc($user['no_telp'] ?? '-') ?></dd>

                <dt class="col-sm-4">Jurusan</dt>
                <dd class="col-sm-8"><?= esc($user['jurusan'] ?? '-') ?></dd>
            </dl>

            <button type="button" class="btn btn--primary" data-modal-open="editProfileModal">
                <i class="fas fa-edit me-1" aria-hidden="true"></i> Edit Profil
            </button>
        </div>
    </div>
</div>

<?php
$errors = session('errors') ?? [];
$validationErrors = is_array($errors) ? $errors : [];
$validationInstance = $validation ?? null;
$getFieldError = static function (string $field) use ($validationErrors, $validationInstance): string {
    if ($validationInstance !== null) {
        return (string) ($validationInstance->getError($field) ?? '');
    }

    return (string) ($validationErrors[$field] ?? '');
};

ob_start();
?>
<form id="profileForm" action="<?= base_url('admin/profile/update') ?>" method="post">
    <?= csrf_field() ?>
    <div class="visually-hidden" role="status" aria-live="polite">
        <?php if (session()->getFlashdata('success')): ?>
            <?= esc(session()->getFlashdata('success')) ?>
        <?php elseif (session()->getFlashdata('error')): ?>
            <?= esc(session()->getFlashdata('error')) ?>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert--success" role="status" aria-live="polite">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert--error" role="alert" aria-live="polite">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($validationErrors)): ?>
        <div class="alert alert--error" role="alert">
            <?php foreach ($validationErrors as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $namaError = $getFieldError('nama'); ?>
    <div class="form-field">
        <label for="nama" class="form-field__label">Nama</label>
        <input type="text" class="form-field__input" id="nama" name="nama"
               value="<?= esc(old('nama', $user['nama'] ?? '')) ?>" required
               aria-describedby="nama-hint nama-error"<?= $namaError ? ' aria-invalid="true"' : '' ?>>
        <span id="nama-hint" class="form-field__hint">Minimal 3 karakter.</span>
        <span id="nama-error" class="form-field__error" role="alert"><?= esc($namaError) ?></span>
    </div>

    <?php $nomorError = $getFieldError('nomor'); ?>
    <div class="form-field">
        <label for="nomor" class="form-field__label">Nomor</label>
        <input type="text" class="form-field__input" id="nomor" name="nomor"
               value="<?= esc(old('nomor', $user['nomor'] ?? '')) ?>" required
               aria-describedby="nomor-hint nomor-error"<?= $nomorError ? ' aria-invalid="true"' : '' ?>>
        <span id="nomor-hint" class="form-field__hint">Nomor digunakan untuk login.</span>
        <span id="nomor-error" class="form-field__error" role="alert"><?= esc($nomorError) ?></span>
    </div>

    <?php $phoneError = $getFieldError('no_telp'); ?>
    <div class="form-field">
        <label for="no_telp" class="form-field__label">Nomor Telepon</label>
        <input type="text" class="form-field__input" id="no_telp" name="no_telp"
               value="<?= esc(old('no_telp', $user['no_telp'] ?? '')) ?>"
               aria-describedby="no_telp-hint no_telp-error"<?= $phoneError ? ' aria-invalid="true"' : '' ?>>
        <span id="no_telp-hint" class="form-field__hint">Opsional.</span>
        <span id="no_telp-error" class="form-field__error" role="alert"><?= esc($phoneError) ?></span>
    </div>

    <?php $majorError = $getFieldError('jurusan'); ?>
    <div class="form-field">
        <label for="jurusan" class="form-field__label">Jurusan</label>
        <input type="text" class="form-field__input" id="jurusan" name="jurusan"
               value="<?= esc(old('jurusan', $user['jurusan'] ?? '')) ?>"
               aria-describedby="jurusan-hint jurusan-error"<?= $majorError ? ' aria-invalid="true"' : '' ?>>
        <span id="jurusan-hint" class="form-field__hint">Opsional.</span>
        <span id="jurusan-error" class="form-field__error" role="alert"><?= esc($majorError) ?></span>
    </div>

    <?php $passwordError = $getFieldError('password'); ?>
    <div class="form-field">
        <label for="password" class="form-field__label">Password Baru</label>
        <input type="password" class="form-field__input" id="password" name="password"
               aria-describedby="password-hint password-error"<?= $passwordError ? ' aria-invalid="true"' : '' ?>>
        <span id="password-hint" class="form-field__hint">Kosongkan jika tidak ingin mengganti password.</span>
        <span id="password-error" class="form-field__error" role="alert"><?= esc($passwordError) ?></span>
    </div>
</form>
<?php
$profileForm = ob_get_clean();
?>

<?= view('components/_modal', [
    'id' => 'editProfileModal',
    'title' => 'Edit Profil',
    'body' => $profileForm,
    'footer' => '<button type="button" class="btn btn--outline" data-modal-close>Batal</button><button type="submit" form="profileForm" class="btn btn--primary">Simpan</button>',
]) ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<?= $this->endSection() ?>
