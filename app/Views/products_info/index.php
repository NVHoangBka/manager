<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-box"></i> <?= $title ?></h4>
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
                
    <div class="col-md-3">
        <div class="product-list shadow">
            <div class="product-header py-2 px-3 rounded-top bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0">
                    Product List
                </h6>
                <button class="btn btn-sm btn-dark" id="btn-print">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>

            <div class="product-body" style="height: 100vh">
                <div class="product-items pt-2">
                    <?php foreach ($products as $p): ?>
                        <div class="product-item item-hover border d-flex py-2 px-3"
                            style="cursor:pointer;"
                            data-id="<?= $p['id'] ?>"
                            data-name="<?= esc($p['name']) ?>"
                            data-price="<?= number_format($p['unit_price']) ?>"
                            data-code="<?= esc($p['code']) ?>"
                            data-category="<?= esc($p['category']) ?>"
                            data-size="<?= esc($p['size']) ?>"
                            data-status="<?= $p['status'] ?>"
                            data-image="<?= $p['image'] ? base_url('uploads/products/' . $p['image']) : '' ?>"
                        >
                            <div class="product-image">
                                <?php if ($p['image']): ?>
                                    <img src="<?= base_url('uploads/products/' . $p['image']) ?>"
                                         width="60" height="60"
                                         style="object-fit:cover;border-radius:4px;"
                                         alt="<?= esc($p['name']) ?>">
                                <?php else: ?>
                                    <div
                                        class="d-flex align-items-center justify-content-center rounded"
                                        style="width:60px;height:60px;background:var(--color-background-secondary);" >
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info pl-3">
                                <p class="product-name m-0 font-weight-bold" style="font-size: 18px"><?= esc($p['name']) ?></p>
                                <span class="procuct-price">
                                   price: $<?= number_format($p['unit_price']) ?>
                                </span>
                                <span class="procuct-size">
                                   - size: <?= esc($p['size']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="product-content shadow">
            <div class="product-header">
                <!-- Tabs -->
                <ul class="nav nav-tabs" id="productTabs">
                    <li class="col-3 text-center ">
                        <a class="nav-link product-item product-item-active text-body border product-item-active" data-toggle="tab" href="#tab-product-info">
                            <i class="bi bi-info-circle mr-1"></i> Product Info
                        </a>
                    </li>
                    <li class="col-3 text-center">
                        <a class="nav-link product-item text-body border" data-toggle="tab" href="#tab-order-history">
                            <i class="bi bi-clock-history"></i> Order History
                        </a>
                    </li>
                    <li class="col-3 text-center">
                        <a class="nav-link product-item text-body border" data-toggle="tab" href="#tab-warehose-stock">
                            <i class="fas fa-check-circle"></i> Warehouse & Stock
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tabs-content mt-3" style="height: 100vh">
                <!-- TAB 1: Product Info -->
                <div class="tab-pane fade show active" id="tab-product-info">
                    <div class="d-flex p-3">
                        <div class="product-image mr-4">
                            <div class="image-main">
                                <?php if ($p['image']): ?>
                                    <img src="<?= base_url('uploads/products/' . $p['image']) ?>"
                                         width="360" height="360"
                                         style="object-fit:cover;border-radius:4px;"
                                         alt="<?= esc($p['name']) ?>">
                                <?php else: ?>
                                    <div
                                        class="d-flex align-items-center justify-content-center rounded"
                                        style="width:360px;height:360px;background:var(--color-background-secondary);" >
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="image-select mt-4 d-flex justify-content-center gap-3">
                                <img class="image-item" src="<?= base_url('uploads/products/' . $p['image']) ?>"
                                    width="60" height="60"
                                    style="object-fit:cover;border-radius:4px;"
                                    alt="<?= esc($p['name']) ?>">
                                <img class="image-item" src="<?= base_url('uploads/products/' . $p['image']) ?>"
                                    width="60" height="60"
                                    style="object-fit:cover;border-radius:4px;"
                                    alt="<?= esc($p['name']) ?>">
                            </div>
                        </div>
                        <div style="flex:1">
                            <div>
                                <div class="font-weight-bold" style="font-size: 36px"><?= esc($p['name']) ?></div>                        
                                <div class="text-primary" style="font-size: 28px"><b>$<?= number_format($p['unit_price']) ?></b> </div>
                                <div style="font-size: 18px">
                                    <span class="badge badge-<?= $p['status'] ? 'success' : 'secondary' ?>">
                                        <?= $p['status'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <span><b>Code: </b><?= esc($p['code'])?></span>
                                    <span><b>Category: </b><?= esc($p['category'])?></span>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <!-- Card 1 -->
                                <div class="col-xl-4 col-md-6 mb-4 text-white">
                                    <div class="card border-left-primary bg-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center ">
                                                <div class="col mr-2 ">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Total Orders</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($total_orders ?? 0) ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-shopping-cart fa-2x text-gray-300" style="font-size: 36px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2 -->
                                <div class="col-xl-4 col-md-6 mb-4 text-white">
                                    <div class="card border-left-success bg-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Revenue</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $revenue ?? '0' ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="bi bi-currency-dollar text-gray-300" style="font-size: 36px"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 3 -->
                                <div class="col-xl-4 col-md-6 mb-4 text-white">
                                    <div class="card border-left-info bg-info  shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Stock</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 36px"><?= number_format($stock ?? 0) ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TAB 2: Order History -->
                <div class="tab-pane fade" id="tab-order-history">
                    <div id="order-history-content">
                        <p class="text-muted">Chọn sản phẩm để xem lịch sử đơn hàng.</p>
                    </div>
                </div>
                
                <!-- TAB 3: Warehouse & Stock -->
                <div class="tab-pane fade" id="tab-warehouse-stock">
                    <div id="warehouse-stock-content">
                        <p class="text-muted">Chọn sản phẩm để xem thông tin kho.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>