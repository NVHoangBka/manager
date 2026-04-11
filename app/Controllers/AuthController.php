<?php

namespace App\Controllers;

class AuthController extends BaseController {
    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ){
        parent::initController($request, $response, $logger);

         // Chưa login thì về trang login
        if (!$this->session->get('logged_in')) {
         header('Location: ' . base_url('login'));
         exit;
        }
        $this->data['user'] = $this->session->get('user');
    }   
}