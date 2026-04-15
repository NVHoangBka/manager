<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-box"></i> Products</h4>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
                
    <!--Table-->
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0">
                    Product List
                </h6>
                <button class="btn btn-sm btn-dark" id="btn-print">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="products-table" class="table table-bordered table-hover" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th id="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p): ?>
                            <tr>
                                <td>
                                    <?= $p['id']?>
                                </td>
                                <td>
                                    <?php if ($p['image']): ?>
                                        <img src="<?= base_url('uploads/products/' . $p['image']) ?>"
                                             width="50" height="50"
                                             style="object-fit:cover;border-radius:4px;"
                                             alt="<?= esc($p['name']) ?>">
                                    <?php else: ?>
                                        <div
                                            class="d-flex align-items-center justify-content-center rounded"
                                            style="width:50px;height:50px;background:var(--color-background-secondary);" >
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($p['code']) ?></td>
                                <td><?= esc($p['name']) ?></td>
                                <td><?= esc($p['category']) ?></td>
                                <td><?= esc($p['size']) ?></td>
                                <td>$<?= number_format($p['unit_price']) ?></td>
                                <td>
                                    <span class="badge badge-<?= $p['status'] ? 'success' : 'secondary' ?>">
                                        <?= $p['status'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td id="action">
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('products/edit/' . $p['id']) ?>"
                                            class="btn btn-sm btn-warning">
                                             <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('products/delete/' . $p['id']) ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Xóa sản phẩm này?')">
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
    
      <!--FORM-->
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0">
                    <?= isset($product_edit) && $product_edit
                        ? '<i class="fas fa-edit"></i> Edit Product'
                        : '<i class="fas fa-plus"></i> Add Product' ?>
                </h6>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"
                        action="<?= isset($product_edit) && $product_edit
                            ? base_url('products/update/' . $product_edit['id'])
                            : base_url('products/store') ?>">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label>Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control"
                               value="<?= $product_edit['code'] ?? old('code') ?>"
                               <?= isset($product_edit) && $product_edit ? 'readonly' : 'required' ?>>
                    </div>

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                               value="<?= $product_edit['name'] ?? old('name') ?>">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">-- Select --</option>
                            <?php foreach(['Gấu','Thỏ','Mèo','Voi','Khác'] as $cat): ?>
                                <option value="<?= $cat ?>"
                                    <?= ($product_edit['category'] ?? '') === $cat ? 'selected' : '' ?>>
                                    <?= $cat ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text" name="size" class="form-control"
                                       placeholder="30cm"
                                       value="<?= $product_edit['size'] ?? old('size') ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="unit" class="form-control"
                                       value="<?= $product_edit['unit'] ?? 'cái' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Unit Price ($)</label>
                        <input type="number" name="unit_price" class="form-control"
                               value="<?= $product_edit['unit_price'] ?? 0 ?>">
                    </div>

                    <div class="form-group">
                        <label>Image</label>
                        <!-- Preview ảnh hiện tại -->
                        <?php if(!empty($product_images)): ?>
                        <div class="d-flex flex-wrap mb-2" id ="current-images">
                            <?php foreach ($product_images as $img): ?>
                            <div class="mr-2 mb-2 position-relative image-item-wrap" id="img-wrap-<?= $img['id']?>">
                                <img src="<?= base_url('uploads/products/' . $img['image']) ?>"
                                    width="80" height="80"
                                    style="object-fit:cover;border-radius:6px;border:<?= $img['is_main'] ? '3px solid #007bff' : '1px solid #ddd' ?>;"
                                    title="<?= $img['is_main'] ? 'Main image' : 'Click to set main' ?>">

                                <!-- Nút set main -->
                                <?php if (!$img['is_main']): ?>
                                <button type="button"
                                        class="btn btn-xs btn-primary btn-set-main position-absolute"
                                        style="top:2px;left:2px;font-size:9px;padding:1px 4px;"
                                        data-img-id="<?= $img['id'] ?>"
                                        data-product-id="<?= $product_edit['id'] ?>">
                                    ★
                                </button>
                                <?php else: ?>
                                <span class="position-absolute badge badge-primary"
                                      style="top:2px;left:2px;font-size:9px;">Main</span>
                                <?php endif; ?>

                                <!-- Nút xóa ảnh -->
                                <button type="button"
                                        class="btn btn-xs btn-danger btn-delete-image position-absolute"
                                        style="top:2px;right:2px;font-size:9px;padding:1px 4px;"
                                        data-img-id="<?= $img['id'] ?>">
                                    ✕
                                </button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Upload ảnh mới -->
                        <input type="file" 
                               name="images[]" 
                               multiple
                               class="form-control-file" 
                               id="input-images"
                               accept="image/jpg,image/jpeg,image/png">
                        
                        <small class="text-muted">JPG, PNG — có thể chọn nhiều ảnh</small>

                        <!-- Preview ảnh mới chọn -->
                        <div class="d-flex flex-wrap mt-2" id="new-images-preview"></div>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?= ($product_edit['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($product_edit['status'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-save"></i>
                        <?= isset($product_edit) && $product_edit ? 'Update' : 'Save' ?>
                    </button>

                    <?php if (isset($product_edit) && $product_edit): ?>
                        <a href="<?= base_url('products') ?>" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>
</div>