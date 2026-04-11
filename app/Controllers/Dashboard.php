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
        
        // Stat cards
        $data['new_orders']         = $this->dashboardModel->getTotalWorkOrders();
        $data['bounce_rate']        = $this->dashboardModel->getDefectRate();
        $data['user_registrations'] = $this->dashboardModel->getTotalUsers();
        $data['products_length']    = $this->dashboardModel->getTotalProducts();

        
        // Biểu đồ Bar — sản lượng theo tháng
        $monthlyOutput = $this->dashboardModel->getMonthlyOutput();
        $data['chart_bar'] = json_encode([
            'categories' => array_column($monthlyOutput, 'month'),
            'series' => [
                [
                    'name' => 'Good',
                    'data' => array_map('intval', array_column($monthlyOutput, 'good_qty'))
                ],
                [
                    'name' => 'Defect',
                    'data' => array_map('intval', array_column($monthlyOutput, 'defect_qty'))
                ],
            ]
        ]);
        
        // Biểu đồ Doughnut — sản phẩm theo category
        $categoryData = $this->dashboardModel->getProductByCategory();
        $data['chart_doughnut'] = json_encode(
            array_map(function($row) {
                return ['value' => (int)$row['value'], 'name' => $row['name']];
            }, $categoryData)
        );
            
        // Biểu đồ Line — chất lượng theo tháng
        $qualityTrend = $this->dashboardModel->getQualityTrend();
        $data['chart_line'] = json_encode([
            'categories' => array_column($qualityTrend, 'month'),
            'series' => [
                [
                    'name' => 'Passed',
                    'data' => array_map('intval', array_column($qualityTrend, 'passed'))
                ],
                [
                    'name' => 'Failed',
                    'data' => array_map('intval', array_column($qualityTrend, 'failed'))
                ],
            ]
        ]);
        
        // Biểu đồ Pie — doanh thu theo sản phẩm
        $revenueData = $this->dashboardModel->getRevenueByProduct();
        $data['chart_pie'] = json_encode(
            array_map(function($row) {
                return ['value' => (int)$row['value'], 'name' => $row['name']];
            }, $revenueData)
        );

        
        return view('templates/main', $data);
    }
}