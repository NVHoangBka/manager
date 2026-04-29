<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionsModel extends Model 
{
    protected $table            = 'permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    protected $allowedFields    = ['perm_key', 'perm_name'];
    
    public function getAllPermissions()
    {
        return $this->orderBy('perm_key', 'ASC')->findAll();
    }
    
    public function addPermission($key, $name)
    {
        return $this->insert([
            'perm_key' => $key,
            'perm_name' => $name
        ]);
    }
}