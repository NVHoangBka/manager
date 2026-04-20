<h1 class="h3 mb-4 text-gray-800"><?= lang('app.dashboard') ?></h1>
<!-- Refresh Button -->
<div class="text-right my-3">
    <button id="btn-refresh" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-sync"></i> Refresh Data
    </button>
</div>
<!-- Alert Container -->
<div id="alert-container"></div>

<div class="row">
    <!-- Card 1 -->
    <div class="col-xl-3 col-md-6 mb-4 text-white">
        <div class="card border-left-primary bg-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center ">
                    <div class="col mr-2 ">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?= lang('app.new_orders') ?></div>
                        <div id="new-orders" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-xl-3 col-md-6 mb-4 text-white">
        <div class="card border-left-success bg-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?= lang('app.defect_rate') ?></div>
                        <div id="defect-rate" class="h5 mb-0 font-weight-bold text-gray-800">0%</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percent fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-xl-3 col-md-6 mb-4 text-white">
        <div class="card border-left-info bg-info  shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?= lang('app.active_users') ?></div>
                        <div id="active-users" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-xl-3 col-md-6 mb-4 text-white">
        <div class="card border-left-warning bg-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1"><?= lang('app.total_products') ?></div>
                        <div id="total-products" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= lang('app.quality_by_month') ?></h6>
            </div>
            <div class="card-body">
                <div id="line-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= lang('app.revenue_by_product') ?></h6>
            </div>
            <div class="card-body">
                <div id="pie-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary"><?= lang('app.products_by_category') ?></h6>
            </div>
            <div class="card-body">
                <div id="doughnut-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary"><?= lang('app.output_by_month') ?></h6>
            </div>
            <div class="card-body">
                <div id="bar-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
</div>


