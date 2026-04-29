<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h6 class="m-0 font-weight-bold">
            <i class="fas fa-user-lock"></i> Phân quyền cho: <?= $user['full_name'] ?>
        </h6>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/permissions/update/'.$user['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <?php foreach($all_permissions as $p): ?>
                <div class="col-md-4 mb-3">
                    <div class="custom-control custom-switch border p-3 rounded shadow-sm">
                        <input type="checkbox" name="perms[]" value="<?= $p['id'] ?>" 
                               class="custom-control-input" id="p<?= $p['id'] ?>"
                               <?= in_array($p['id'], $current_perm_ids) ? 'checked' : '' ?>>
                        <label class="custom-control-label font-weight-bold" for="p<?= $p['id'] ?>">
                            <?= $p['perm_name'] ?>
                        </label>
                        <div class="small text-muted"><?= $p['perm_key'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <hr>
            <div class="text-right">
                <button type="submit" class="btn btn-success shadow-sm">
                    <i class="fas fa-save"></i> Lưu quyền hạn ngay
                </button>
            </div>
        </form>
    </div>
</div>