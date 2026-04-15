<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\ProductImageModel;


class Products extends AuthController
{
    protected $productModel;
    protected $imageModel;
    
    public function __construct() {
        $this-> productModel= new ProductModel();
        $this->imageModel   = new ProductImageModel();
    }
    
    private function loadView($page, $product_edit = null, $errors = null){
        $data = $this->data;
        $data['title']          = 'Products';
        $data['page']           = $page;
        $data['page_js']        = 'products.js';
        $data['products']       = $this->productModel->getAll();
        $data['product_edit']   = $product_edit;
        $data['errors']         = $errors;
        
        // Lấy ảnh của sản phẩm đang edit
        if($product_edit) {
            $data['product_images'] = $this->imageModel->getByProduct($product_edit['id']);
        } else {
            $data['product_images'] = [];
        }

        return view('templates/main', $data);
    }
    
    public function index() {
        return $this->loadView('products/index');
    }
    
    public function create() {
        return $this->loadView('products/index');
    }

    public function edit($id)
    {
        $product_edit = $this->productModel->getById($id);
        return $this->loadView('products/index', $product_edit);
    }
    
    public function store()
    {
        $rules = [
            'code'  => 'required|is_unique[products.code]',
            'name'  => 'required',
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->loadView('products/index',null, $errors);
        }
        
        $data = $this->getProductData();
        $productId = $this->productModel->insert($data, true);
        $this->uploadMultipleImages($productId);
        
        return redirect()->to('products')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update($id)
    {
        $product = $this->productModel->getById($id);
        $rules = [
            'name'  => 'required',
        ];
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->loadView('products/index',$product, $errors);
        }
        
        $data = $this->getProductData($product['image']);
        $this->productModel->update($id, $data);
        $this->uploadMultipleImages($id);

        return redirect()->to('products')->with('success', 'Cập nhật sản phẩm thành công!');
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
        return redirect()->to('products')->with('success', 'Xóa sản phẩm thành công!');
    }
    
    public function deleteImage($id)
    {
        $img = $this->imageModel->find($id);

        if ($img) {
            if (file_exists(FCPATH.'uploads/products/'.$img['image'])) {
                unlink(FCPATH.'uploads/products/'.$img['image']);
            }
            $this->imageModel->delete($id);
        }

        return redirect()->back()->with('success', 'Đã xóa ảnh!');
    }
    
    // Set ảnh chính
    public function setMainImage($productId, $imageId)
    {
        $this->imageModel->setMain($productId, $imageId);
        return $this->response->setJSON(['status' => 'success']);
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
            'image'      => $oldImage,
            'status'     => $this->request->getPost('status') ?? 1,
        ];
    }
    
    private function uploadMultipleImages($productId)
    {
        $files = $this->request->getFileMultiple('images');
        if (empty($files)) {
            log_message('debug', "No files uploaded for product ID: " . $productId);
            return;
        }

        $existingCount = $this->imageModel->where('product_id', $productId)->countAllResults();
        $isFirst = ($existingCount === 0);
        $sortOrder = $existingCount + 1;

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {

                $newName = $file->getRandomName();

                try {
                    $file->move(FCPATH . 'uploads/products/', $newName);

                    $data = [
                        'product_id' => (int)$productId,
                        'image'      => $newName,
                        'is_main'    => $isFirst ? 1 : 0,
                        'sort_order' => (int)$sortOrder,
                    ];

                    $this->imageModel->insert($data);

                    if ($isFirst) {
                        $this->productModel->update($productId, ['image' => $newName]);
                        $isFirst = false;
                    }

                    $sortOrder++;

                    log_message('debug', "Upload thành công ảnh: " . $newName . " | sort_order = " . ($sortOrder - 1));

                } catch (\Exception $e) {
                    log_message('error', "Upload failed: " . $e->getMessage());
                }
            }
        }
    }

    public function getInfoList() {
        return $this->loadView('products_info/index');
    }
    
    public function getInfo($id) {
        $product = $this->productModel->getById($id);
        if (!$product) {
            return $this->response->setJSON(['status' => 'error']);
        }

        // Lấy tất cả ảnh
        $images = $this->imageModel->getByProduct($id);
        $imageUrls = array_map(function($img) {
                return [
                    'id'        => $img['id'],
                    'url'       => base_url('uploads/products/'. $img['image']),
                    'is_main'   => $img['is_main'],     
                ];
        }, $images);
        
        $totalOrders = $this->productModel->getTotalOders($id);
        $revenue = $this->productModel->getRevenues($id);
        $produced = $this->productModel->getProduced($id);
        $sold = $this->productModel->getSold($id);
        $orders = $this->productModel->getOrders($id);

        return $this->response->setJSON([
            'status'       => 'success',
            'total_orders' => $totalOrders,
            'revenue'      => number_format($revenue),
            'stock'        => max(0, $produced - $sold),
            'produced'     => (int)$produced,
            'sold'         => (int)$sold,
            'orders'       => $orders,
            'images'       => $imageUrls,
        ]);
    }
}