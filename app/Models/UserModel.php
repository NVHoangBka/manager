<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'user_name',
        'password',
        'full_name',
        'email',
        'role',
        'avatar',
        'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Tìm user theo username
    public function getByUsername($user_name)
    {
        return $this->where('user_name', $user_name)
                    ->where('status', 1)
                    ->first();
    }
    
    // Tìm user theo id
    public function getById($id)
    {
        return $this->find($id);
    }
    
    // Lấy tất cả user
    public function getAll()
    {
        return $this->findAll();
    }
}