<?php
namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = ['name', 'code', 'description', 'status'];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updateField = 'updated_at';
    
    public function getActiveDepartments() {
        return $this->where('status', 1)
                ->orderBy('name', 'ASC')
                ->findAll();
    }
}