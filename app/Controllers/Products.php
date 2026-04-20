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
    
    public function getInfoList() {
        return $this->loadView('products_info/index');
    }
}
