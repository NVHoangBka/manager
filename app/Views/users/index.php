<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-users"></i> Users</h4>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

<div class="row">
    <!--DATA TABLE-->
    <div class="col-12 col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h6 class="m-0">User List</h6>
                <button class="btn btn-sm btn-dark" id="btn-print">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
            <div class="card-body">
                <a href="<?= base_url('users/create')?>"
                    class="btn btn-sm btn-success float-right mb-2">
                    <i class="bi bi-plus-square"></i> Add
                </a>
                
                <div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover " style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th id="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr>
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
                                        <a href="<?= base_url('users/edit/' . $u['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                             <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('users/delete/' . $u['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this user?')">
                                             <i class="fas fa-trash"></i>
                                        </a>
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
    
    <!--Form-->
        <div class="col-12 col-lg-4 mt-4 mt-lg-0">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
               <h6 class="m-0" id="form-title">
                    <?= isset($user_edit) && $user_edit 
                    ? '<i class="fas fa-user-edit"></i> Edit User' 
                    : '<i class="fas fa-user-plus"></i> Add User' ?>
                </h6>
            </div>
            <div class="card-body">

                <?php if (isset($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" id="user-form"
                      action="<?= isset($user_edit) && $user_edit
                          ? base_url('users/update/' . $user_edit['id'])
                          : base_url('users/store') ?>">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>User Name <span class="text-danger">*</span></label>
                        <input type="text" name="user_name" id="f-user_name" class="form-control"
                               value="<?= $user_edit['user_name'] ?? old('user_name') ?>"
                               <?= isset($user_edit) && $user_edit ? 'readonly' : 'required' ?>>
                    </div>

                    <div class="form-group">
                        <label>Password
                            <small class="text-muted" id="pass-hint"></small>
                        </label>
                        <input type="password" name="password" id="f-password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" id="f-fullname" class="form-control" required
                               value="<?= $user_edit['full_name'] ?? old('full_name') ?>">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="f-email" class="form-control" required
                               value="<?= $user_edit['email'] ?? old('email') ?>">
                    </div>

                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select name="role" id="f-role" class="form-control" required>
                            <option value="user"  <?= ($user_edit['role'] ?? '') === 'user'  ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= ($user_edit['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="f-status" class="form-control">
                            <option value="1" <?= ($user_edit['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($user_edit['status'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i>
                        <span id="btn-text"><?= isset($user_edit) && $user_edit ? 'Update' : 'Save' ?></span>
                    </button>

                    <?php if (isset($user_edit) && $user_edit): ?>
                    <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-block mt-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>
</div>