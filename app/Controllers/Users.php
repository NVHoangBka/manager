<?php
namespace App\Controllers;

use App\Models\UserModel;

class Users extends AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    private function loadView($page, $user_edit = null) {
        $data = $this->data;
        $data['title']   = 'Users';
        $data['page']    = $page;
        $data['page_js'] = 'users.js';
        $data['users']   = $this->userModel->getAll();
        $data['user_edit'] = $user_edit;
        return view('templates/main', $data);
    }

    public function index()
    {
        return $this->loadView('users/index');
    }

    public function create()
    {
        return $this->loadView('users/index');

    }

    public function edit($id)
    {
        $userEdit = $this->userModel->getById($id);
        return $this->loadView('users/index', $userEdit);
    }
}