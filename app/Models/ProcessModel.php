<?php
namespace App\Models;
use CodeIgniter\Model;

class ProcessModel extends Model
{
    public function getNodes($type)
    {
        return $this->db->table('process_nodes')
            ->where('process_type', $type)
            ->get()->getResultArray();
    }
    
    public function insertNode($data)
    {
        $this->db->table('process_nodes')->insert($data);
        return $this->db->insertID();
    }
    
    public function updateNode($id, $data)
    {
        return $this->db->table('process_nodes')
                ->where('id', $id)
                ->update($data);
    }
    
    public function deleteNode($id) {
        return $this->db->table('process_nodes')->where('id', $id)->delete();
    }


    public function getEdges($type)
    {
        return $this->db->table('process_edges')
            ->where('process_type', $type)
            ->get()->getResultArray();
    }
    
     public function insertEdge($data)
    {
        $this->db->table('process_edges')->insert($data);
        return $this->db->insertID();
    }
    
    public function updateEdge($id, $data)
    {
        return $this->db->table('process_edges')
                ->where('id', $id)
                ->update($data);
    }
    
    public function deleteEdge($id) {
        return $this->db->table('process_edges')->where('id', $id)->delete();
    }


    public function saveLabelPosition($id, $x, $y)
    {
        return $this->db->table('process_nodes')
            ->where('id', $id)
            ->update([
                'position_x' => $x,
                'position_y' => $y
            ]);
    }

    public function saveNumberPosition($id, $x, $y)
    {
        return $this->db->table('process_nodes')
            ->where('id', $id)
            ->update([
                'number_x' => $x,
                'number_y' => $y
            ]);
    }
}