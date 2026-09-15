<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function attemptLogin()
    {
        $nomor    = $this->request->getPost('nomor');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('nomor', $nomor)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Nomor atau password salah');
        }

        // Set session — key 'user' untuk AuthFilter, plus key lain untuk view
        session()->set([
            'user'      => $user,          // untuk AuthFilter
            'user_id'   => $user['id'],
            'nomor'     => $user['nomor'],
            'nama'      => $user['nama'],
            'role_id'   => $user['role_id'],
            'logged_in' => true,           // untuk header
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
