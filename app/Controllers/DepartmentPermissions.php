<?php
namespace App\Controllers;

use App\Models\DepartmentModel;
use App\Models\DepartmentPermissionModel;

class DepartmentPermissions extends AuthController
{
    protected $departmentModel;
    protected $permissionModel;
    
    public function __construct() {
        $this->departmentModel = new DepartmentModel();
        $this->permissionModel = new DepartmentPermissionModel();
    }
    
    public function index() {
        $data = $this->data;
        $data['title'] = "Department Permission";
        $data['page'] = 'permissions/department';
        $data['departments'] = $this->departmentModel->getActiveDepartments();
        
        $data['modules'] = [
            'production' => 'Production',
            'qc'         => 'QC',
            'warehouse'  => 'Ware House',
            'hr'         => 'HR',
            'accounting' => 'Accountion',
            'report'     => 'Report'
        ];
        
        $data['permissions'] = ['view', 'create', 'edit', 'delete'];
        
        return view('templates/main',$data);
    }


    public function get($departmentId) {
        $data = $this->permissionModel->getPermissionsByDepartment($departmentId);
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
    public function save() {
        $departmentId = $this->request->getPost('department_id');
        $items = $this->request->getPost('items');
        
        if(!$departmentId || empty($items)) {
            return $this->response->setJSON([
                'status'    => 'error',
                'message'   => 'Data error'
            ]);
        }
        
        $this->permissionModel->where('department_id', $departmentId)->delete();

        foreach ($items as $item) {
            $this->permissionModel->insert([
                'department_id' => $departmentId,
                'module'        => $item['module'],
                'permission'    => $item['permission'],
                'granted'       => 1
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Permission Data success!'
        ]);
    }
}