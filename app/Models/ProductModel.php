<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected  $primaryKey = 'id';
    
    protected $allowedFields = [
        'code', 'name', 'category', 'size', 'unit', 'unit_price', 'image', 'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // ====================== BASIC QUERIES ======================
    public function getAll() {
        return $this ->findAll();
    }
    
    public function getById($id) {
        return $this->find($id);
    }
    
    public function getActive() {
        return $this -> where('status', 1) -> findAll();
    }
    
    // ====================== STATISTICS ======================
    public function getTotalOders($id)
    {
        return $this->db->table('sales_orders')
            ->where('product_id', $id)
            ->countAllResults();
}
    
    public function getRevenues($id)
    {
        return $this->db->table('sales_orders')
                ->selectSum('total_amount')
                ->where('product_id', $id)
                ->where('status !=', 'cancelled')
                ->get()->getRow()->total_amount ?? 0;
    }
    
    public function getProduced($id)
    {
        return $this->db->table('production_output')
                ->selectSum('good_qty')
                ->where('product_id', $id)
                ->get()->getRow()->good_qty ?? 0;
    }
    
    public function getSold($id) {
        return $this->db->table('sales_orders')
                ->selectSum('qty')
                ->where('product_id', $id)
                ->where('status', 'delivered')
                ->get()->getRow()-> qty ?? 0;
    }
    
    public function getOrders($id) {
        return $this->db->table('sales_orders so')
            ->select('so.order_number, so.qty, so.total_amount, so.status, so.order_date, c.name as customer_name')
            ->join('customers c', 'so.customer_id = c.id', 'left')
            ->where('so.product_id', $id)
            ->orderBy('so.order_date', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();
    }
    
}
