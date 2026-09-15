# Form Berita

## Sumber
- Path: `app/Views/sections/berita_list_admin.php`
- Ukuran: 253 baris
- Asset yang di-link: Bootstrap modal JavaScript dan Font Awesome.

## Kode UI (verbatim)
```php
<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="/berita/store" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Konten</label>
                    <textarea name="konten" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formEdit" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_berita" id="edit-id">
                <div class="mb-3"><label class="form-label">Judul</label>
                    <input type="text" name="judul" id="edit-judul" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Konten</label>
                    <textarea name="konten" id="edit-konten" class="form-control" required></textarea>
                </div>
                <div class="mb-3"><label class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="edit-kategori" class="form-control" required>
                </div>
                <div class="mb-3"><label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="edit-tanggal" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toast notification handling
    <?php if (session()->getFlashdata('success')): ?>
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = '<?= session()->getFlashdata('success') ?>';
        successToast.show();
        setTimeout(() => successToast.hide(), 3000);
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.getElementById('errorMessage').textContent = '<?= session()->getFlashdata('error') ?>';
        errorToast.show();
        setTimeout(() => errorToast.hide(), 3000);
    <?php endif; ?>
});

    // Search
    const searchInput = document.getElementById('search-input');
    const tableRows = document.querySelectorAll('#rekrutmen-table tbody tr');
    searchInput.addEventListener('keyup', function () {
        const searchText = this.value.toLowerCase();
        tableRows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(searchText) ? '' : 'none';
        });
    });

    // Sort
    document.getElementById('sort-filter').addEventListener('change', function () {
        const tbody = document.querySelector('#rekrutmen-table tbody');
        const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
        rows.sort((a, b) => {
            const aVal = new Date(a.cells[4].innerText);
            const bVal = new Date(b.cells[4].innerText);
            return this.value === 'newest' ? bVal - aVal : aVal - bVal;
        });
        rows.forEach(r => tbody.appendChild(r));
    });

    // Items per page
    document.getElementById('items-per-page-filter').addEventListener('change', function () {
        const perPage = this.value === 'all' ? tableRows.length : parseInt(this.value);
        tableRows.forEach((row, i) => {
            row.style.display = i < perPage ? '' : 'none';
        });
    });
    document.getElementById('items-per-page-filter').dispatchEvent(new Event('change'));

    // Export PDF
    document.getElementById('export-pdf-btn').addEventListener('click', () => printTableOnly('rekrutmen-table', 'Daftar Berita'));
    document.getElementById('export-excel-btn').addEventListener('click', () => exportTableToExcel('rekrutmen-table', 'Daftar_Berita'));

    // Isi data ke modal edit
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('formEdit').action = "/berita/update/" + this.dataset.id;
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-judul').value = this.dataset.judul;
            document.getElementById('edit-konten').value = this.dataset.konten;
            document.getElementById('edit-kategori').value = this.dataset.kategori;
            document.getElementById('edit-tanggal').value = this.dataset.tanggal;
        });
    });
</script>
```

## Variabel yang Dipakai
| Variabel | Sumber (controller/session) | Keterangan |
|---|---|---|
| `csrf_field()` | CI4 Security | Token CSRF |
| `$row[...]` | `$schedules` | Prefill form edit |
| `id_berita` | Database | Hidden key update |

## Form & Aksi
- Store: POST `/berita/store`.
- Update: POST `/berita/update/{id}` (controller menerima ID route).
- Delete: POST `/berita/delete/{id}`.
- Validasi controller: `judul` required max 100, `konten` required, `kategori` required, `tanggal` required valid_date.

## Struktur HTML Penting
- Modal tambah dan modal edit, input/textarea, footer Batal/Simpan/Update.

## Catatan A11y Saat Ini
- label for/id: label ada tetapi sebagian belum berpasangan dengan `for`.
- aria-*: tombol close modal memerlukan `aria-label`.
- role: modal perlu `role="dialog"` dan `aria-labelledby`.
- Heading hierarchy: modal title h5.

## Catatan Branding SSIP
- Tidak ada logo utama pada form.
- Wajib diganti saat porting: tidak, selain URL/teks target bila diperlukan.
