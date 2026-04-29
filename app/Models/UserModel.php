<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model 
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'user_name',
        'password',
        'full_name',
        'email',
        'role',
        'avatar',
        'status'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Tìm user theo username
    public function getByUsername($user_name)
    {
        return $this->where('user_name', $user_name)
                    ->where('status', 1)
                    ->first();
    }
    
    // Tìm user theo id
    public function getById($id)
    {
        return $this->find($id);
    }
    
    // Lấy tất cả user
    public function getAll()
    {
        return $this->findAll();
    }
    
    // --- Permissions ---

    /**
     * get UserPermissionIDs
     */
    public function getUserPermissionIds($userId)
    {
        $res = $this->db->table('user_permissions')
                        ->where('user_id', $userId)
                        ->get()
                        ->getResultArray();
        
        // Trả về mảng chỉ chứa ID: [1, 5, 10]
        return array_column($res, 'permission_id');
    }

    /**
     * get UserPermissionKeys
     */
    public function getUserPermissionKeys($userId)
    {
        return $this->db->table('user_permissions')
                        ->select('permissions.perm_key')
                        ->join('permissions', 'permissions.id = user_permissions.permission_id')
                        ->where('user_id', $userId)
                        ->get()
                        ->getResultArray();
    }

    /**
     * updatePermissions
     */
    public function syncPermissions($userId, $permissionIds)
    {
        // Sử dụng Transaction để đảm bảo nếu lỗi thì không mất dữ liệu cũ
        $this->db->transStart();

        // 1. Xóa toàn bộ quyền hiện tại của user này
        $this->db->table('user_permissions')->where('user_id', $userId)->delete();

        // 2. Nếu có chọn quyền mới thì mới chèn vào
        if (!empty($permissionIds) && is_array($permissionIds)) {
            $insertData = [];
            foreach ($permissionIds as $pId) {
                $insertData[] = [
                    'user_id'       => $userId,
                    'permission_id' => $pId
                ];
            }
            $this->db->table('user_permissions')->insertBatch($insertData);
        }

        $this->db->transComplete();
        return $this->db->transStatus();
    }
    
}