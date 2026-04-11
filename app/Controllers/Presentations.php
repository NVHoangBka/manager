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

        // Tab 1: Chất lượng theo tháng
        $qualityTrend = $this->dashboardModel->getQualityTrend();
        $data['quality_trend']    = $qualityTrend;
        $data['chart_quality']    = json_encode([
            'categories' => array_column($qualityTrend, 'month'),
            'series' => [
                ['name' => 'Passed', 'data' => array_map('intval', array_column($qualityTrend, 'passed'))],
                ['name' => 'Failed', 'data' => array_map('intval', array_column($qualityTrend, 'failed'))],
            ]
        ]);

        // Tab 2: Doanh thu theo sản phẩm
        $revenueData = $this->dashboardModel->getRevenueByProduct();
        $data['revenue_data']  = $revenueData;
        $data['chart_revenue'] = json_encode(
            array_map(fn($r) => ['value' => (int)$r['value'], 'name' => $r['name']], $revenueData)
        );

        // Tab 3: Sản phẩm theo category
        $categoryData = $this->dashboardModel->getProductByCategory();
        $data['category_data']  = $categoryData;
        $data['chart_category'] = json_encode(
            array_map(fn($r) => ['value' => (int)$r['value'], 'name' => $r['name']], $categoryData)
        );

        // Tab 4: Sản lượng theo tháng
        $monthlyOutput = $this->dashboardModel->getMonthlyOutput();
        $data['monthly_output'] = $monthlyOutput;
        $data['chart_output']   = json_encode([
            'categories' => array_column($monthlyOutput, 'month'),
            'series' => [
                ['name' => 'Good',   'data' => array_map('intval', array_column($monthlyOutput, 'good_qty'))],
                ['name' => 'Defect', 'data' => array_map('intval', array_column($monthlyOutput, 'defect_qty'))],
            ]
        ]);

        return view('templates/main', $data);
    }
}