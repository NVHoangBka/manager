<?php

namespace App\Controllers;
use App\Models\DashboardModel;

class Dashboard extends AuthController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    
    public function index()
    {
        $data = $this->data;
        $data['title'] = 'Dashboard';
        $data['page']    = 'dashboard/index';
        $data['page_js'] = 'dashboard.js';
      
        return view('templates/main', $data);
    }
}