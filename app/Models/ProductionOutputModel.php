<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductionOutputModel extends Model
{
    protected $table      = 'production_output';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'work_order_id', 'product_id', 'output_date',
        'good_qty', 'defect_qty', 'shift', 'worker_id', 'machine_id'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    
    public function getAll() {
        return $this->db->query("
            SELECT po.*, p.name as product_name, w.wo_number,
                   wk.full_name as worker_name, m.name as machine_name
            FROM production_output po
            LEFT JOIN products p ON po.product_id = p.id
            LEFT JOIN work_orders w ON po.work_order_id = w.id
            LEFT JOIN workers wk ON po.worker_id = wk.id
            LEFT JOIN machines m ON po.machine_id = m.id
            ORDER BY po.output_date DESC
        ")->getResultArray();
    }
}

