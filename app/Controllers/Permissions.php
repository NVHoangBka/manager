<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PermissionsModel;


class Permissions extends BaseController {
    
    protected $userModel;
    protected $permModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->permModel = new PermissionsModel();
    }

    private function loadPermission($page, $userId, $current_perm_ids) {
        $data = $this->data;
        $data['title']   = 'Permissions';
        $data['page']    = $page;
        $data['users']   = $this->userModel->find($userId);
        $data['all_permissions'] = $this->permModel->getAllPermissions();
        $data['current_perm_ids'] = $current_perm_ids;
                
        return view('templates/main', $data);
    }
    
    public function index() {
        return $this->loadPermission('permissions/index', null, null);
    }


    public function edit($userId)
    {
        $current_perm_ids = $this->userModel -> getUserPermissionIds($userId);
        
        return $this->loadPermission('permissions/index',$userId, $current_perm_ids);
    }
}