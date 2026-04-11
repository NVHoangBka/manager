<?php
namespace App\Controllers;
use App\Models\UserModel;

class Users extends AuthController
{
    protected $userModel;
    
    public function __construct() {
        $this->userModel= new UserModel();
    }
    
    // Danh sách users
    public function index() {
        $data = $this->data;
        $data['title'] = 'Users';
        $data['page'] = 'users/index';
        $data['page_js'] = 'users.js';
        $data['users'] = $this->userModel->getAll();
        return view('templates/main', $data);
    }
    
    // Form thêm user
    public function create() {
        $data = $this->data;
        $data['title'] = 'Users';
        $data['page']  = 'users/index';
        $data['page_js']   = 'users.js';
        $data['users']     = $this->userModel->getAll();
        $data['user_edit'] = null;
        return view('templates/main', $data);
    }
    
    // Lưu user mới
    public function store() {
        $rules = [
            'user_name' => 'required|min_length[3]|is_unique[users.user_name]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'role'     => 'required',
        ];
        
        if (!$this->validate($rules)) {
            $data = $this->data;
            $data['title']     = 'Add User';
            $data['page']      = 'users/form';
            $data['user_edit'] = null;
            $data['errors']    = $this->validator->getErrors();
            return view('templates/main', $data);
        }
        
        $this->userModel->insert([
            'user_name'  => $this->request->getPost('user_name'),
            'password'  => md5($this->request->getPost('password')),
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'status'    => $this->request->getPost('status') ?? 1,
        ]);
        
        return redirect()->to('users')->with('success', 'User added successfully!');
    }

    // Form sửa user
    public function edit($id){
        $data = $this->data;
        $data['title']     = 'Users';
        $data['page']      = 'users/index';
        $data['page_js']   = 'users.js';
        $data['users']     = $this->userModel->getAll();
        $data['user_edit'] = $this->userModel->getById($id);
        return view('templates/main', $data);
    }
    
    // Cập nhật user
    public function update($id)
    {
        $rules = [
            'full_name' => 'required',
            'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'      => 'required',
        ];

        if (!$this->validate($rules)) {
            $data = $this->data;
            $data['title']     = 'Edit User';
            $data['page']      = 'users/form';
            $data['user_edit'] = $this->userModel->getById($id);
            $data['errors']    = $this->validator->getErrors();
            return view('templates/main', $data);
        }

        $updateData = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'status'    => $this->request->getPost('status') ?? 1,
        ];

        // Chỉ update password nếu có nhập
        if ($this->request->getPost('password')) {
            $updateData['password'] = md5($this->request->getPost('password'));
        }

        $this->userModel->update($id, $updateData);
        return redirect()->to('users')->with('success', 'User updated successfully!');
    }
    
     // Xóa user
    public function delete($id)
    {
        // Không cho xóa chính mình
        if ($id == $this->data['user']['id']) {
            return redirect()->to('users')->with('error', 'Cannot delete yourself!');
        }
        $this->userModel->delete($id);
        return redirect()->to('users')->with('success', 'User deleted successfully!');
    }

}