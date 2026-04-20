<?php
namespace App\Controllers\Api;

use App\Controllers\AuthController;
use App\Models\DashboardModel;

class DashboardApi extends AuthController {
    protected $dashboardModel;
    
    public function __construct() {
        $this->dashboardModel = new DashboardModel();
    }
    
    // GET ALL CARD
    public function getCards() {
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'new_orders'        => $this->dashboardModel->getTotalWorkOrders(),
                'bounce_rate'       => $this->dashboardModel->getDefectRate(),
                'user_registrations'=> $this->dashboardModel->getTotalUsers(),
                'products_length'   => $this->dashboardModel->getTotalProducts(),
                'pending_orders'    => $this->dashboardModel->getPendingOrders(),
            ]
        ]);
    }
    
    //GET ALL CHARTS
    public function getCharts() {
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'bar'      => $this->dashboardModel->getMonthlyOutput(),
                'doughnut' => $this->dashboardModel->getProductByCategory(),
                'line'     => $this->dashboardModel->getQualityTrend(),
                'pie'      => $this->dashboardModel->getRevenueByProduct()
            ]
        ]);
    }
}