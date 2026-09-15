<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index(): ResponseInterface|string
    {
        $user = $this->getCurrentUser();
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        return view('admin/dashboard', [
            'title' => 'Profil Pengguna',
            'user' => $user,
            'role_name' => $this->getRoleName($user['role_id'] ?? null),
        ]);
    }

    public function profile(): ResponseInterface|string
    {
        $user = $this->getCurrentUser();
        if ($user instanceof ResponseInterface) {
            return $user;
        }

        return view('auth/profile', [
            'title' => 'Profil Saya',
            'user' => $user,
            'role_name' => $this->getRoleName($user['role_id'] ?? null),
        ]);
    }

    public function updateProfile(): ResponseInterface
    {
        $userId = session('user_id');
        if (empty($userId)) {
            return redirect()->to('/login');
        }

        $data = $this->request->getPost(['nama', 'nomor', 'no_telp', 'jurusan', 'password']);
        $errors = [];
        if (trim((string) ($data['nama'] ?? '')) === '' || strlen(trim((string) $data['nama'])) < 3) {
            $errors['nama'] = 'Nama wajib diisi minimal 3 karakter.';
        }
        if (trim((string) ($data['nomor'] ?? '')) === '') {
            $errors['nomor'] = 'Nomor wajib diisi.';
        }
        if (($data['password'] ?? '') !== '' && strlen($data['password']) < 6) {
            $errors['password'] = 'Password minimal 6 karakter.';
        }
        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $model = new UserModel();
        $updateData = [
            'id' => $userId,
            'nama' => trim($data['nama']),
            'nomor' => trim($data['nomor']),
            'no_telp' => trim((string) ($data['no_telp'] ?? '')),
            'jurusan' => trim((string) ($data['jurusan'] ?? '')),
        ];
        if (($data['password'] ?? '') !== '') {
            $updateData['password'] = $data['password'];
        }

        if (!$model->save($updateData)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        $updatedUser = $model->find($userId);
        session()->set([
            'user' => $updatedUser,
            'nama' => $updatedUser['nama'],
            'nomor' => $updatedUser['nomor'],
        ]);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    private function getCurrentUser(): array|ResponseInterface
    {
        $userId = session('user_id');
        $user = empty($userId) ? null : (new UserModel())->find($userId);
        if ($user === null) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return $user;
    }

    private function getRoleName(?int $roleId): string
    {
        if ($roleId === null) {
            return '-';
        }

        $role = (new RoleModel())->find($roleId);
        return $role['role_name'] ?? '-';
    }
}
