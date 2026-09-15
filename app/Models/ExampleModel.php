<?php
namespace App\Models;
use CodeIgniter\Model;
class ExampleModel extends Model
{
    protected $table = 'examples';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'status'];
    protected $useTimestamps = true;
    protected $validationRules = ['title' => 'required|min_length[3]|max_length[200]'];
}
