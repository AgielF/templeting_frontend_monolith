<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Profil Pengguna</h1>
    <?php if (empty($user)): ?>
        <div class="alert alert-danger" role="alert">Data pengguna tidak ditemukan.</div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <h2 class="h5 card-title mb-4">Informasi Profil</h2>
                <dl class="row mb-4">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9"><?= esc($user['nama'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Nomor</dt>
                    <dd class="col-sm-9"><?= esc($user['nomor'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Nomor Telepon</dt>
                    <dd class="col-sm-9"><?= esc($user['no_telp'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Jurusan</dt>
                    <dd class="col-sm-9"><?= esc($user['jurusan'] ?? '-') ?></dd>
                    <dt class="col-sm-3">Role</dt>
                    <dd class="col-sm-9"><?= esc($role_name ?? '-') ?></dd>
                </dl>
                <a href="<?= base_url('admin/profile') ?>" class="btn btn-primary">Edit Profil</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
