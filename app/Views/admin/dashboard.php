<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Dashboard</h1>
    <div class="alert alert-info">
        Welcome, <strong><?= esc(session()->get('nama') ?? 'User') ?></strong>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Example CRUD</h5>
                    <p class="card-text">Contoh modul CRUD untuk template.</p>
                    <a href="<?= base_url('admin/example') ?>" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
