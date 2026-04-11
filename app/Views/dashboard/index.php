<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<div class="row">

    <!-- Card 1 -->
    <div class="col-xl-3 col-md-6 mb-4 text-white">
        <div class="card border-left-primary bg-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center ">
                    <div class="col mr-2 ">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">New Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($new_orders ?? 0) ?></div>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Bounce Rate</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bounce_rate ?? '0%' ?></div>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">User Registrations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($user_registrations ?? 0) ?></div>
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
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Products</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($products_length ?? 0) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Chất lượng theo tháng</h6>
            </div>
            <div class="card-body">
                <div id="line-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu theo sản phẩm</h6>
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
                <h6 class="m-0 font-weight-bold text-primary">Sản phẩm theo category</h6>
            </div>
            <div class="card-body">
                <div id="doughnut-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Sản lượng theo tháng</h6>
            </div>
            <div class="card-body">
                <div id="bar-chart" style="height:300px;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var chartBar      = <?= $chart_bar ?>;
    var chartDoughnut = <?= $chart_doughnut ?>;
    var chartLine     = <?= $chart_line ?>;
    var chartPie      = <?= $chart_pie ?>;
</script>
