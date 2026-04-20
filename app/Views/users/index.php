<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-users"></i> <?= lang('app.users') ?></h4>
</div>

<!-- Alert container -->
<div id="alert-container"></div>

<div class="row">
    <!--DATA TABLE-->
    <div class="col-12 col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h6 class="m-0"><?= lang('app.user_list') ?></h6>
                <button class="btn btn-sm btn-dark" id="btn-print">
                    <i class="fas fa-print"></i> <?= lang('app.print') ?>
                </button>
            </div>
            <div class="card-body">
                <a href="<?= base_url('users/create') ?>" 
                   class="btn btn-sm btn-success float-right mb-2" id="btn-add-new">
                    <i class="bi bi-plus-square"></i> <?= lang('app.add_user') ?>
                </a>
                
                <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th><?= lang('app.username') ?></th>
                                <th><?= lang('app.full_name') ?></th>
                                <th><?= lang('app.role') ?></th>
                                <th><?= lang('app.status') ?></th>
                                <th id="action"><?= lang('app.action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr data-id="<?= $u['id'] ?>">
                                <td><?= $u['id'] ?></td>
                                <td><?= esc($u['user_name']) ?></td>
                                <td>
                                    <?= esc($u['full_name']) ?><br>
                                    <small class="text-muted"><?= esc($u['email']) ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $u['role'] === 'admin' ? 'danger' : 'info' ?>">
                                        <?= $u['role'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $u['status'] ? 'success' : 'secondary' ?>">
                                        <?= $u['status'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td id="action" >
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-warning btn-edit-user"
                                                data-id="<?= $u['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-delete-user"
                                                data-id="<?= $u['id'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FORM -->
    <div class="col-12 col-lg-4 mt-4 mt-lg-0">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0" id="form-title">
                    <i class="fas fa-user-plus"></i> <?= lang('app.add_user') ?>
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" id="user-form" 
                      action="<?= base_url('api/users/store') ?>">
                    <?= csrf_field() ?>
                    
                    <input type="hidden" name="id" id="hidden-id" value="">

                    <div class="form-group">
                        <label><?= lang('app.username') ?> <span class="text-danger">*</span></label>
                        <input type="text" name="user_name" id="f-user_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><?= lang('app.password') ?> 
                        </label>
                        <input type="password" name="password" id="f-password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><?= lang('app.full_name') ?>  <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" id="f-fullname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><?= lang('app.email') ?>  <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="f-email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><?= lang('app.role') ?>  <span class="text-danger">*</span></label>
                        <select name="role" id="f-role" class="form-control" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= lang('app.status') ?> </label>
                        <select name="status" id="f-status" class="form-control">
                            <option value="1"><?= lang('app.active') ?> </option>
                            <option value="0"><?= lang('app.inactive') ?> </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" id="btn-submit">
                        <i class="fas fa-save"></i> <?= lang('app.save') ?>
                    </button>

                    <button type="button" class="btn btn-secondary btn-block mt-2" id="btn-cancel" style="display:none;">
                        <i class="fas fa-times"></i> <?= lang('app.cancel') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>