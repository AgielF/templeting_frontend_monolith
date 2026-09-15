# Home

## Sumber
- Path: `app/Views/home_view.php`
- Ukuran: 29 baris
- Asset yang di-link: asset yang dipanggil oleh section include.

## Kode UI (verbatim)
```php
<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<?= $this->include('sections/about_ssip') ?>

 <!-- TAMBAHKAN BARIS INI -->
<?= $this->include('sections/visi_misi') ?>


<main>
	<!-- Anda bisa menambahkan section berita di sini -->
	<?= $this->include('sections/jadwal_praktikum') ?>

	<!-- Section Berita -->
	<?= $this->include('sections/berita_kegiatan', ['berita_list' => $berita_list ?? []]) ?>

	<?php
		// Kirimkan variabel $fields ke dalam section 'topic'
		// Pastikan variabel $fields ada (didefinisikan di controller)
		if (isset($fields)) {
			echo $this->include('sections/topic', ['fields' => $fields]);
		}
	?>

   
</main>

<?= $this->include('layout/footer') ?>
```

## Variabel yang Dipakai
| Variabel | Sumber (controller/session) | Keterangan |
|---|---|---|
| `$berita_list` | `Home::getBeritaData()` | Lima berita terbaru |
| data visi/misi | `Home` controller | Konten landing |

## Form & Aksi
- Tidak ada form utama.

## Struktur HTML Penting
- Landing page dan section berita kegiatan.
- Komponen berulang berasal dari `sections/berita_kegiatan.php`.

## Catatan A11y Saat Ini
- label for/id: tidak berlaku untuk halaman tanpa form.
- aria-*: perlu audit pada carousel/interactive section.
- role: perlu semantik section/main.
- Heading hierarchy: cek urutan heading antar-section.

## Catatan Branding SSIP
- Nama SSIP/ITENAS dan logo kampus muncul melalui layout/section.
- Wajib diganti saat porting: ya untuk identitas kampus.
