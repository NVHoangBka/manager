<?php
namespace App\Controllers\Api;

use App\Controllers\AuthController;
use App\Models\ProductModel;
use App\Models\ProductImageModel;

class ProductsApi extends AuthController {
    protected $productModel;
    protected $imageModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->imageModel   = new ProductImageModel();
    }
    
    private function getProductData($oldImage = null)
    {

        return [
            'code'       => $this->request->getPost('code'),
            'name'       => $this->request->getPost('name'),
            'category'   => $this->request->getPost('category'),
            'size'       => $this->request->getPost('size'),
            'unit'       => $this->request->getPost('unit') ?? 'cái',
            'unit_price' => $this->request->getPost('unit_price') ?? 0,
            'status'     => $this->request->getPost('status') ?? 1,
        ];
    }
    
    private function uploadMultipleImages($productId)
    {
        $files = $this->request->getFileMultiple('images');
        if (!$files || count($files) === 0) return;
        
        $count = $this->imageModel->where('product_id', $productId)->countAllResults();
        $isFirst = ($count === 0);

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(FCPATH . 'uploads/products/', $name);
                
                $data = [
                    'product_id' => $productId,
                    'image'      => $name,
                    'is_main'    => $isFirst ? 1 : 0,
                    'sort_order' => $count,
                ];
                
                $this->imageModel->insert($data);

                if ($isFirst) {
                    $this->productModel->update($productId, ['image' => $name]);
                    $isFirst = false;
                }
                $count++;
            }
        }
    }
    
    // ==================== STORE PRODUCT ====================
    public function store() {
        $rules = [
            'code' => 'required|is_unique[products.code]',
            'name' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $data = $this->getProductData();
        
        $productId = $this->productModel->insert($data, true);
        
        $this->uploadMultipleImages($productId);
        
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Thêm sản phẩm thành công!',
            'id'      => $productId
        ]);
    }
    
    public function update($id) {
        $rules = ['name' => 'required'];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $data = $this->getProductData();
        
        $this->productModel->update($id, $data);
        $this->uploadMultipleImages($id);
        
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Cập nhật sản phẩm thành công!'
        ]);
    }
    
    


    // Lấy thông tin chi tiết sản phẩm (đang dùng trong JS)
    public function getInfo($id)
    {
        $product = $this->productModel->getById($id);
        if (!$product) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found']);
        }

        $images = $this->imageModel->getByProduct($id);
        $imageUrls = array_map(function($img) {
            return [
                'id'       => $img['id'],
                'url'      => base_url('uploads/products/' . $img['image']),
                'is_main'  => (int)$img['is_main'],
            ];
        }, $images);

        $data = [
            'status'        => 'success',
            'total_orders'  => $this->productModel->getTotalOders($id),
            'revenue'       => number_format($this->productModel->getRevenues($id)),
            'stock'         => max(0, $this->productModel->getProduced($id) - $this->productModel->getSold($id)),
            'produced'      => (int)$this->productModel->getProduced($id),
            'sold'          => (int)$this->productModel->getSold($id),
            'orders'        => $this->productModel->getOrders($id),
            'images'        => $imageUrls,
        ];

        return $this->response->setJSON($data);
    }

    // Set mainImage
    public function setMainImage($productId, $imageId)
    {
        $this->imageModel->setMain($productId, $imageId);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    public function delete($id)
    {
        $product = $this->productModel->getById($id);
        
        // Xóa tất cả ảnh
        $images = $this->imageModel->getByProduct($id);
                
        foreach($images as $img){
            if (file_exists(FCPATH . 'uploads/products/' . $img['image'])) {
                unlink(FCPATH . 'uploads/products/' . $img['image']);
            }
        }
        $this->imageModel->where('product_id', $id)->delete();
        
        // Xóa ảnh cũ trong products.image
        if ($product['image'] && file_exists(FCPATH . 'uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['image']);
        }
        
        $this->productModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    // delete Image 
    public function deleteImage($id)
    {
        $img = $this->imageModel->find($id);
        if ($img) {
            if (file_exists(FCPATH . 'uploads/products/' . $img['image'])) {
                unlink(FCPATH . 'uploads/products/' . $img['image']);
            }
            $this->imageModel->delete($id);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Image not found']);
    }
}