<?php
namespace App\Controllers;
use App\Models\MaterialModel;

class Materials extends AuthController
{
    protected $materialModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
    }

    public function index()
    {
        $data = $this->data;
        $data['title']         = 'Materials';
        $data['page']          = 'materials/index';
        $data['page_js']       = 'materials.js';
        $data['materials']     = $this->materialModel->getAll();
        $data['materials_json'] = json_encode($data['materials']);
        return view('templates/main', $data);
    }

    // API lưu dữ liệu từ JExcel
    public function save()
    {
        $rows = $this->request->getJSON(true);
        if (!$rows) return $this->response->setJSON(['status' => 'error', 'message' => 'No data']);

        foreach ($rows as $row) {
            if (!empty($row['id'])) {
                $this->materialModel->update($row['id'], [
                    'name'      => $row['name'],
                    'type'      => $row['type'],
                    'unit'      => $row['unit'],
                    'stock_qty' => $row['stock_qty'],
                    'min_stock' => $row['min_stock'],
                    'unit_cost' => $row['unit_cost'],
                    'status'    => $row['status'],
                ]);
            } else {
                $this->materialModel->insert([
                    'code'      => $row['code'],
                    'name'      => $row['name'],
                    'type'      => $row['type'],
                    'unit'      => $row['unit'],
                    'stock_qty' => $row['stock_qty'],
                    'min_stock' => $row['min_stock'],
                    'unit_cost' => $row['unit_cost'],
                    'status'    => $row['status'] ?? 1,
                ]);
            }
        }
        return $this->response->setJSON(['status' => 'success']);
    }
}