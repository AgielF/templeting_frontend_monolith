<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class BeritaController extends BaseController
{
    public function index(): string
    {
        $model = new BeritaModel();
        $berita = $model
            ->select('berita.*, users.nama AS penulis_nama')
            ->join('users', 'users.id = berita.penulis_id', 'left')
            ->orderBy('berita.created_at', 'DESC')
            ->paginate(10);

        return view('admin/berita/index', [
            'title' => 'Daftar Berita',
            'berita' => $berita,
            'pager' => $model->pager,
        ]);
    }

    public function create(): string
    {
        return view('admin/berita/form', [
            'title' => 'Tambah Berita',
            'mode' => 'create',
        ]);
    }

    public function store(): ResponseInterface
    {
        $penulisId = session('user_id');
        if (empty($penulisId)) {
            return redirect()->back()->with('error', 'Sesi pengguna tidak valid.');
        }

        $model = new BeritaModel();
        $data = $this->request->getPost();
        $data['penulis_id'] = $penulisId;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['judul'] ?? '');

        if (($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        if ($model->save($data)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function edit($id): string
    {
        $berita = (new BeritaModel())->find($id);
        if ($berita === null) {
            throw PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        return view('admin/berita/form', [
            'title' => 'Edit Berita',
            'mode' => 'edit',
            'berita' => $berita,
        ]);
    }

    public function update($id): ResponseInterface
    {
        $penulisId = session('user_id');
        if (empty($penulisId)) {
            return redirect()->back()->with('error', 'Sesi pengguna tidak valid.');
        }

        $model = new BeritaModel();
        $existing = $model->find($id);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['judul'] ?? '', (int) $id);

        if (($data['status'] ?? 'draft') === 'published' && empty($existing['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        } elseif (!empty($existing['published_at'])) {
            $data['published_at'] = $existing['published_at'];
        }

        if ($model->save($data)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diupdate.');
        }

        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function delete($id): ResponseInterface
    {
        $model = new BeritaModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        if ($model->delete($id)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Berita gagal dihapus.');
    }

    private function uniqueSlug(string $slug, string $judul, ?int $excludeId = null): string
    {
        $baseSlug = trim($slug) !== '' ? $slug : url_title($judul, '-', true);
        $candidate = $baseSlug;
        $suffix = 2;
        $model = new BeritaModel();

        while (true) {
            $query = $model->withDeleted()->where('slug', $candidate);
            if ($excludeId !== null) {
                $query->where('id !=', $excludeId);
            }
            if ($query->first() === null) {
                break;
            }
            $candidate = $baseSlug . '-' . $suffix++;
        }

        return $candidate;
    }
}