<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$errors = session('errors') ?? [];
$success = session()->getFlashdata('success');
$error = session()->getFlashdata('error');
$beritaRows = is_array($berita ?? null) ? $berita : iterator_to_array($berita ?? []);
$paginationLinks = $pager->links() ?? '';
?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Daftar Berita</h1>
            <p class="text-muted mb-0">Kelola berita dan kegiatan admin.</p>
        </div>
        <a href="<?= base_url('admin/berita/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1" aria-hidden="true"></i> Tambah Berita
        </a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success" role="alert"><?= esc($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert"><?= esc($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ((array) $errors as $message): ?>
                <div><?= esc($message) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php if (empty($beritaRows)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3" aria-hidden="true"></i>
                    <h2 class="h5">Belum ada berita</h2>
                    <p class="text-muted">Mulai tambahkan berita pertama untuk ditampilkan di sini.</p>
                    <a href="<?= base_url('admin/berita/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1" aria-hidden="true"></i> Tambah Berita Pertama
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Status</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Tanggal Publish</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($beritaRows as $index => $row): ?>
                                <?php
                                $number = (($pager->getCurrentPage() - 1) * $pager->getPerPage()) + $index + 1;
                                $status = $row['status'] ?? 'draft';
                                $statusClass = $status === 'published' ? 'bg-success' : 'bg-secondary';
                                $publishedAt = $row['published_at'] ?? null;
                                $author = $row['penulis_nama'] ?? null;
                                if (!$author) {
                                    $author = 'User #' . ($row['penulis_id'] ?? '-');
                                }
                                ?>
                                <tr>
                                    <td><?= esc($number) ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= esc($row['judul'] ?? '-') ?></div>
                                        <?php if (!empty($row['slug'])): ?>
                                            <small class="text-muted">/<?= esc($row['slug']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?= esc($row['kategori'] ?? 'umum') ?></span></td>
                                    <td><span class="badge <?= esc($statusClass) ?>"><?= esc($status) ?></span></td>
                                    <td><?= esc($author) ?></td>
                                    <td>
                                        <?= $publishedAt ? esc(date('d M Y H:i', strtotime($publishedAt))) : '<span class="text-muted">Belum diterbitkan</span>' ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="<?= base_url('admin/berita/edit/' . (int) $row['id']) ?>"
                                               class="btn btn-sm btn-outline-primary"
                                               aria-label="Edit berita <?= esc($row['judul'] ?? '') ?>">
                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <form action="<?= base_url('admin/berita/delete/' . (int) $row['id']) ?>"
                                                  method="post"
                                                  onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        aria-label="Hapus berita <?= esc($row['judul'] ?? '') ?>">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($paginationLinks): ?>
                    <nav class="mt-4" aria-label="Navigasi halaman">
                        <?= $paginationLinks ?>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
