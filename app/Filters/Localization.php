<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Localization implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Kiểm tra session 'lang' mà bạn đã đặt trong Controller Language
        $lang = $session->get('lang') ?? config('App')->defaultLocale;

        // Thiết lập ngôn ngữ cho toàn bộ hệ thống trong request này
        service('language')->setLocale($lang);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}