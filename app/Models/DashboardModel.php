<?php
namespace App\Models;
use CodeIgniter\Model;


class DashboardModel extends Model {
    // Stat cards
    public function getTotalWorkOrders()
    {
        return $this->db->table('work_orders')->countAll();
    }

    public function getInProgressWorkOrders()
    {
        return $this->db->table('work_orders')
            ->where('status', 'in_progress')
            ->countAllResults();
    }

    public function getTotalGoodQty()
    {
        return $this->db->table('production_output')
            ->selectSum('good_qty')
            ->get()->getRow()->good_qty ?? 0;
    }

    public function getDefectRate()
    {
        $row = $this->db->table('production_output')
            ->select('SUM(good_qty) as good, SUM(defect_qty) as defect')
            ->get()->getRow();
        $total = ($row->good + $row->defect);
        if ($total == 0) return '0%';
        return round(($row->defect / $total) * 100, 1) . '%';
    }

    public function getTotalProducts()
    {
        return $this->db->table('products')
            ->where('status', 1)
            ->countAllResults();
    }
    
     public function getTotalUsers()
    {
        return $this->db->table('users')
            ->where('status', 1)
            ->countAllResults();
    }
    
    // Biểu đồ 1: Sản lượng theo tháng (Bar Chart)
    public function getMonthlyOutput()
    {
        $rows = $this->db->query("
            SELECT 
                DATE_FORMAT(output_date, '%b') as month,
                DATE_FORMAT(output_date, '%Y-%m') as month_key,
                SUM(good_qty) as good_qty,
                SUM(defect_qty) as defect_qty
            FROM production_output
            WHERE output_date >= DATE_SUB(NOW(), INTERVAL 7 MONTH)
            GROUP BY month_key, month
            ORDER BY month_key ASC
        ")->getResultArray();
        return $rows;
    }
    
    // Biểu đồ 2: Tỷ lệ sản phẩm theo category (Doughnut Chart)
    public function getProductByCategory()
    {
        return $this->db->query("
            SELECT 
                p.category as name,
                SUM(a.good_qty) as value
            FROM production_output a
            JOIN products p ON a.product_id = p.id
            GROUP BY p.category
            ORDER BY value DESC
        ")->getResultArray();
    }

    // Biểu đồ 3: Chất lượng theo work order (Line Chart)
    public function getQualityTrend()
    {
        return $this->db->query("
            SELECT 
                DATE_FORMAT(check_date, '%b') as month,
                DATE_FORMAT(check_date, '%Y-%m') as month_key,
                SUM(passed) as passed,
                SUM(failed) as failed
            FROM quality_checks
            WHERE check_date >= DATE_SUB(NOW(), INTERVAL 7 MONTH)
            GROUP BY month_key, month
            ORDER BY month_key ASC
        ")->getResultArray();
    }
    
    // Biểu đồ 4: Doanh thu theo tháng (Pie - top sản phẩm)
    public function getRevenueByProduct()
    {
        return $this->db->query("
            SELECT 
                p.name,
                SUM(a.total_amount) as value
            FROM sales_orders a
            JOIN products p ON a.product_id = p.id
            WHERE a.status != 'cancelled'
            GROUP BY p.id, p.name
            ORDER BY value DESC
            LIMIT 6
        ")->getResultArray();
    }
    
    // Stat cards thêm
    public function getPendingOrders()
    {
        return $this->db->table('sales_orders')
            ->where('status', 'pending')
            ->countAllResults();
    }

}