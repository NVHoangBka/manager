<?php

namespace App\Controllers;

class AuthController extends BaseController {
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ){
        // Gọi initController của BaseController
        parent::initController($request, $response, $logger);

        // Kiểm tra đã login chưa
        if (!$this->session->get('logged_in')) {
         header('Location: ' . base_url('login'));
         exit;
        }
        
        // Cập nhật lại dữ liệu user
        $this->data['user'] = $this->session->get('user');
    }   
}