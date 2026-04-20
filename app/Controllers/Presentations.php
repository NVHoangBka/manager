<?php
namespace App\Controllers;
use App\Models\DashboardModel;

class Presentations extends AuthController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        $data = $this->data;
        $data['title']   = 'Presentations';
        $data['page']    = 'presentations/index';
        $data['page_js'] = 'presentation.js';

        return view('templates/main', $data);
    }
}