<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table      = 'product_images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'image', 'is_main', 'sort_order'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    public function getByProduct($productId)
    {
        return $this->where('product_id', $productId)
                    ->orderBy('is_main', 'DESC')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    public function getMainImage($productId)
    {
        return $this->where('product_id', $productId)
                    ->where('is_main', 1)
                    ->first();
    }

    public function setMain($productId, $imageId)
    {
        $this->where('product_id', $productId)->set('is_main', 0)->update();
        $this->update($imageId, ['is_main' => 1]);
    }
}