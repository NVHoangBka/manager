<?php
namespace App\Models;

use CodeIgniter\Model;

class DepartmentPermissionModel extends Model
{
    protected $table = 'department_permissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = ['department_id', 'module', 'permission', 'granted'];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updateField = 'updated_at';
    
    public function getPermissionsByDepartment($departmentId) {
        return $this->where('department_id', $departmentId)
                ->findAll();
    }
    
    public function hasPermission($departmentId, $module, $permission) {
        return $this->where('department_id', $departmentId)
                    ->where('module', $module)
                    ->where('permission', $permission)
                    ->where('granted', 1)
                    ->countAllResults() > 0;
    }
}