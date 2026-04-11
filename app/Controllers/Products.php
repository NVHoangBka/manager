<?php
namespace App\Controllers;
use App\Models\ProductModel;


class Products extends AuthController
{
    protected $productModel;
    
    public function __construct() {
        $this-> productModel= new ProductModel();
    }
    
    private function loadView($product_edit = null, $errors = null){
        $data = $this->data;

        $data['title'] = 'Products';
        $data['page'] = 'products/index';
        $data['page_js'] = 'products.js';
        $data['products'] = $this->productModel->getAll();
        $data['product_edit'] = $product_edit;
        $data['errors'] = $errors;

        return view('templates/main', $data);
    }
    
    public function index() {
        return $this->loadView();
    }
    
     public function create() {
        return $this->loadView();
    }


    public function edit($id)
    {
        $product_edit = $this->productModel->getById($id);
        return $this->loadView($product_edit);
    }
    
    public function store()
    {
        $rules = [
            'code'  => 'required|is_unique[products.code]',
            'name'  => 'required',
            'image' => 'if_exist|uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->loadView(null, $errors);
        }
        
        $data = $this->getProductData();
        
        $this->productModel->insert($data);
        
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
            return $this->loadView($product, $errors);
        }
        
        $data = $this->getProductData($product['image']);

        $this->productModel->update($id, $data);

        return redirect()->to('products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function delete($id)
    {
        $product = $this->productModel->getById($id);
        
        if ($product['image'] && file_exists(FCPATH . 'uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['image']);
        }
        
        $this->productModel->delete($id);
        return redirect()->to('products')->with('success', 'Xóa sản phẩm thành công!');
    }

    private function getProductData($oldImage = null)
    {
        $imageName = $this->handleImageUpload($oldImage);

        return [
            'code'       => $this->request->getPost('code'),
            'name'       => $this->request->getPost('name'),
            'category'   => $this->request->getPost('category'),
            'size'       => $this->request->getPost('size'),
            'unit'       => $this->request->getPost('unit') ?? 'cái',
            'unit_price' => $this->request->getPost('unit_price') ?? 0,
            'image'      => $imageName,
            'status'     => $this->request->getPost('status') ?? 1,
        ];
    }
    
    
    private function handleImageUpload($oldImage = null)
    {
        $file = $this->request->getFile('image');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            if ($oldImage && file_exists(FCPATH.'uploads/products/'.$oldImage)) {
                unlink(FCPATH.'uploads/products/'.$oldImage);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH.'uploads/products/', $newName);

            return $newName;
        }

        return $oldImage;
    }
}