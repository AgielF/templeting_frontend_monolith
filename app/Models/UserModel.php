<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['nomor', 'nama', 'no_telp', 'jurusan', 'password', 'role_id'];
    protected $validationRules = [
        'nomor' => 'required|max_length[50]|is_unique[users.nomor,id,{id}]',
        'nama' => 'required|min_length[3]|max_length[100]',
        'no_telp' => 'permit_empty|max_length[20]',
        'jurusan' => 'permit_empty|max_length[100]',
        'role_id' => 'required|integer',
    ];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password']) && $data['data']['password'] !== '') {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_BCRYPT,
                ['cost' => 12]
            );
        } else {
            unset($data['data']['password']);
        }

        return $data;
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
}