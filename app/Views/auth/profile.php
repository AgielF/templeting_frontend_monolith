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

            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit me-1" aria-hidden="true"></i> Edit Profil
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/profile/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <?php $errors = session('errors') ?? []; ?>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ((array) $errors as $error): ?>
                                <div><?= esc($error) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                               value="<?= esc($user['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="nomor" name="nomor"
                               value="<?= esc($user['nomor'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp"
                               value="<?= esc($user['no_telp'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan"
                               value="<?= esc($user['jurusan'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
