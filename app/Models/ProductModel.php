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
    
    public function getAll() {
        return $this ->findAll();
    }
    
    public function getById($id) {
        return $this->find($id);
    }
    
    public function getActive() {
        return $this -> wwhere('status', 1) -> findAll();
    }
}
