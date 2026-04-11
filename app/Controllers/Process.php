<?php
namespace App\Controllers;
use App\Models\ProcessModel;

class Process extends AuthController
{
    protected $processModel;

    public function __construct()
    {
        $this->processModel = new ProcessModel();
    }

    public function index()
    {
        $data = $this->data;
        $data['title']   = 'Process Flow';
        $data['page']    = 'process/index';
        $data['page_js'] = 'process.js';

        // Lấy data cho 4 loại quy trình
        foreach (['production', 'quality', 'order', 'sewing'] as $type) {
            $nodes = $this->processModel->getNodes($type);
            $edges = $this->processModel->getEdges($type);

            // Format cho Cytoscape
            $elements = [];
            foreach ($nodes as $n) {
                $elements[] = [
                    'data' => [
                        'id'    => $n['node_id'],
                        'db_id' => $n['id'],
                        'number'=> $n['number'],
                        'label' => $n['label'],
                        'type'  => $n['node_type'],
                        'color' => $n['color'],
                        'role'   => 'label'
                    ],
                    'position' => [
                        'x' => (int)$n['position_x'],
                        'y' => (int)$n['position_y'],
                    ]
                ];
                // node số (ô vàng)
                if($type === 'sewing' && $n['number']) {
                    $elements[] = [
                        'data' => [
                            'id'     => $n['node_id'].'_num',
                            'label'  => $n['number'],
                            'role'   => 'number',
                            'db_id' => $n['id']
                        ],
                        'position' => [
                            'x' => (int)$n['number_x'],
                            'y' => (int)$n['number_y']
                        ]
                    ];
                }
            }
            
            foreach ($edges as $e) {
                $elements[] = [
                    'data' => [
                        'id'     => 'e_' . $e['id'],
                        'db_id'  => $e['id'],
                        'source' => $e['source'],
                        'target' => $e['target'],
                        'label'  => $e['label'],
                        'etype'  => $e['etype']
                    ]
                ];
            }
            $data['elements_' . $type] = json_encode($elements);
        }

        return view('templates/main', $data);
    }
    
    //Add node
    public function addNode()
    {
        $input = $this->request->getJSON(true);
        $data = $this->processModel->insertNode([
            'process_type' => $input['process_type'],
            'node_id'      => $input['node_id'],
            'number'       => $input['number'],
            'label'        => $input['label'],
            'node_type'    => $input['node_type'],
            'color'        => $input['color'],
            'position_x'   => $input['position_x'],
            'position_y'   => $input['position_y'],
            'number_x'     => $input['number_x'] ?? $input['position_x'] - 90,
            'number_y'     => $input['number_y'] ?? $input['position_y'],
        ]);
        
        return $this->response->setJSON(['status' => 'success', 'id' => $data]);
    }
    
    //update node
    public function updateNode($id)
    {
        $input = $this->request->getJSON(true);
        $data = [
            'label'      => $input['label'],
            'number'     => $input['number'],
            'node_type'  => $input['node_type'],
            'color'      => $input['color'],
            'position_x' => $input['position_x'],
            'position_y' => $input['position_y'],
        ];
        $this->processModel->updateNode($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    // delete node
    public function deleteNode($id)
    {
        $this->processModel->deleteNode($id);
        return $this->response->setJSON(['status' => 'success']);
    }
    
    //Add edge
    public function addEdge()
    {
        $input = $this->request->getJSON(true);
        $data = $this->processModel->insertEdge([
            'process_type' => $input['process_type'],
            'source'       => $input['source'],
            'target'       => $input['target'],
            'etype'        => $input['etype'] ?? 'vertical',
            'label'        => $input['label'] ?? '',
        ]);
        return $this->response->setJSON(['status' => 'success', 'id' => $data]);
    }
    
    // delete edge
    public function deleteEdge($id)
    {
        $this->processModel->deleteEdge($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    //lưu vị trí node sau khi kéo thả
    public function savePosition($id)
    {
        $input = $this->request->getJSON(true);
        $x = $input['x'];
        $y = $input['y'];
        
        if($input['type'] === 'number'){
            $this->processModel->saveNumberPosition($id, $x, $y);
        }else{
            $this->processModel->saveLabelPosition($id, $x, $y);
        }
        return $this->response->setJSON(['status' => 'success']);
    }

}