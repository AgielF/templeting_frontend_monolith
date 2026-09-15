<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'judul',
        'slug',
        'konten',
        'kategori',
        'gambar',
        'status',
        'penulis_id',
        'published_at',
    ];
    protected $dateFormat = 'datetime';

    protected $validationRules = [
        'judul' => 'required|min_length[3]|max_length[200]',
        'slug' => 'required|max_length[220]|is_unique[berita.slug,id,{id}]',
        'konten' => 'required|min_length[10]',
        'kategori' => 'required|max_length[50]',
        'status' => 'required|in_list[draft,published]',
        'penulis_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'judul' => 'Judul wajib diisi, 3-200 karakter',
        'slug' => 'Slug wajib, harus unik',
        'konten' => 'Konten wajib, minimal 10 karakter',
        'kategori' => 'Kategori wajib diisi, maksimal 50 karakter',
        'status' => 'Status wajib draft atau published',
        'penulis_id' => 'Penulis wajib berupa ID pengguna yang valid',
    ];

    public function getPublished(int $limit = 10): array
    {
        return $this->where('status', 'published')
            ->orderBy('published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getByKategori(string $kategori): array
    {
        return $this->where('kategori', $kategori)->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $result = $this->where('slug', $slug)->first();

        return $result === null ? null : $result;
    }
}