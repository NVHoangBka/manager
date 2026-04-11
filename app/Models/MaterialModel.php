<?php
namespace App\Models;
use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table      = 'materials';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code', 'name', 'type', 'unit',
        'stock_qty', 'min_stock', 'unit_cost', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    public function getAll()
    {
        return $this->findAll();
    }
}