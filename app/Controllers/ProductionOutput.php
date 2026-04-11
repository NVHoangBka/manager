<?php
namespace App\Controllers;
use App\Models\ProductionOutputModel;
use App\Models\ProductModel;
use App\Models\WorkOrderModel;

class ProductionOutput extends AuthController
{
    protected $outputModel;
    protected $productModel;

    public function __construct()
    {
        $this->outputModel  = new ProductionOutputModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = $this->data;
        $data['title']   = 'Production Output';
        $data['page']    = 'production_output/index';
        $data['page_js'] = 'production_output.js';
        $data['outputs'] = $this->outputModel->getAll();
        $data['outputs_json'] = json_encode($data['outputs']);
        return view('templates/main', $data);
    }

    // API lưu dữ liệu từ JExcel
    public function save()
    {
        $rows = $this->request->getJSON(true);
        if (!$rows) return $this->response->setJSON(['status' => 'error', 'message' => 'No data']);

        foreach ($rows as $row) {
            if (!empty($row['id'])) {
                $this->outputModel->update($row['id'], [
                    'output_date' => $row['output_date'],
                    'good_qty'    => $row['good_qty'],
                    'defect_qty'  => $row['defect_qty'],
                    'shift'       => $row['shift'],
                ]);
            } else {
                $this->outputModel->insert([
                    'work_order_id' => $row['work_order_id'],
                    'product_id'    => $row['product_id'],
                    'output_date'   => $row['output_date'],
                    'good_qty'      => $row['good_qty'],
                    'defect_qty'    => $row['defect_qty'],
                    'shift'         => $row['shift'],
                ]);
            }
        }
        return $this->response->setJSON(['status' => 'success']);
    }

    // API xuất Excel
    public function export()
    {
        helper('url');

        require_once ROOTPATH . 'vendor/autoload.php';

        $outputs = $this->outputModel->getAll();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Production Output');

        // Header
        $headers = ['ID', 'Work Order', 'Product', 'Date', 'Good Qty', 'Defect Qty', 'Shift', 'Worker', 'Machine'];
        foreach ($headers as $i => $header) {
            $col = chr(65 + $i);
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $sheet->getStyle($col . '1')->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('FF333333');
            $sheet->getStyle($col . '1')->getFont()->getColor()
                  ->setARGB('FFFFFFFF');
        }

        // Data
        foreach ($outputs as $i => $row) {
            $r = $i + 2;
            $sheet->setCellValue('A' . $r, $row['id']);
            $sheet->setCellValue('B' . $r, $row['wo_number']);
            $sheet->setCellValue('C' . $r, $row['product_name']);
            $sheet->setCellValue('D' . $r, $row['output_date']);
            $sheet->setCellValue('E' . $r, $row['good_qty']);
            $sheet->setCellValue('F' . $r, $row['defect_qty']);
            $sheet->setCellValue('G' . $r, $row['shift']);
            $sheet->setCellValue('H' . $r, $row['worker_name']);
            $sheet->setCellValue('I' . $r, $row['machine_name']);

            // Màu xen kẽ
            if ($i % 2 == 0) {
                $sheet->getStyle('A'.$r.':I'.$r)->getFill()
                      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFF5F5F5');
            }
        }

        // Auto width
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border toàn bảng
        $lastRow = count($outputs) + 1;
        $sheet->getStyle('A1:I' . $lastRow)->getBorders()->getAllBorders()
              ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Xuất file
        $filename = 'production_output_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}