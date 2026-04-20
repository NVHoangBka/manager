<?php
namespace App\Controllers\Api;

use App\Controllers\AuthController;
use App\Models\DashboardModel;

class PresentationsApi extends AuthController {
    protected $dashboardModel;
    
    public function __construct() {
        $this->dashboardModel = new DashboardModel();
    }
    
    public function getData() {
        // Quality Trend
        $qualityTrend = $this->dashboardModel->getQualityTrend();
        $chartQuality = [
            'categories'=> array_column($qualityTrend, 'month'),
            'series' => [
                ['name' => 'Passed', 'data' => array_map('intval', array_column($qualityTrend, 'passed'))],
                ['name' => 'Failed', 'data' => array_map('intval', array_column($qualityTrend, 'failed'))]
            ]
        ];
        
        // Revenue by Product
        $revenueData = $this->dashboardModel->getRevenueByProduct();
        $chartRevenue = array_map(fn($r) => ['value' => (int)$r['value'], 'name' => $r['name']], $revenueData);

        // Category
        $categoryData = $this->dashboardModel->getProductByCategory();
        $chartCategory = array_map(fn($r) => ['value' => (int)$r['value'], 'name' => $r['name']], $categoryData);

        // Monthly Output
        $monthlyOutput = $this->dashboardModel->getMonthlyOutput();
        $chartOutput = [
            'categories' => array_column($monthlyOutput, 'month'),
            'series' => [
                ['name' => 'Good', 'data' => array_map('intval', array_column($monthlyOutput, 'good_qty'))],
                ['name' => 'Defect', 'data' => array_map('intval', array_column($monthlyOutput, 'defect_qty'))],
            ]
        ];
        
        return $this->response->setJSON([
            'status' => 'success',
            'quality_trend' => $qualityTrend,
            'revenue_data'  => $revenueData,
            'category_data' => $categoryData,
            'monthly_output'=> $monthlyOutput,
            'chart_quality' => $chartQuality,
            'chart_revenue' => $chartRevenue,
            'chart_category'=> $chartCategory,
            'chart_output'  => $chartOutput
        ]);
    }
}