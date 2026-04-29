<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return redirect()->to('login');
    }

    public function login()
    {
        // Nếu đã login rồi
        if ($this->session->get('logged_in')) {
            return redirect()->to('dashboard');
        }

        $data['title'] = 'Login';

        if ($this->request->is('post')) {
            $username = $this->request->getPost('user_name');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('user_name', $username)
                              ->where('status', 1)
                              ->first();
            
    
            if ($user && $user['password'] === md5($password)) {
                $this->session->set([
                    'logged_in' => true,
                    'user'      => [
                        'id'        => $user['id'],
                        'user_name'  => $user['user_name'],
                        'full_name' => $user['full_name'],
                        'email'     => $user['email'],
                        'avatar'    => $user['avatar'],
                    ]
                ]);
                return redirect()->to('dashboard');
            } else {
                $data['error'] = 'Username hoặc password sai!';
            }
        }

        return view('auth/login', $data);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('login');
    }
}