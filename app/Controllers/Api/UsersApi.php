<?php
namespace App\Controllers\Api;

use App\Controllers\AuthController;
use App\Models\UserModel;

class UsersApi extends AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Store user
    public function store()
    {
        $rules = [
            'user_name' => 'required|min_length[3]|is_unique[users.user_name]',
            'password'  => 'required|min_length[6]',
            'full_name' => 'required',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'role'      => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'user_name' => $this->request->getPost('user_name'),
            'password'  => md5($this->request->getPost('password')),
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'status'    => $this->request->getPost('status') ?? 1,
        ];

        $this->userModel->insert($data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Thêm người dùng thành công!'
        ]);
    }

    // Update user
    public function update($id)
    {
        $rules = [
            'full_name' => 'required',
            'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'      => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $updateData = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'status'    => $this->request->getPost('status') ?? 1,
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = md5($this->request->getPost('password'));
        }

        $this->userModel->update($id, $updateData);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Cập nhật người dùng thành công!'
        ]);
    }

    // Delete user
    public function delete($id)
    {
        if ($id == $this->session->get('user')['id']) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Bạn không thể xóa chính mình!'
            ]);
        }

        if ($this->userModel->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Xóa người dùng thành công!'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Xóa thất bại!'
        ]);
    }
}