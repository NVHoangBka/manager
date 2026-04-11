<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-chart-bar"></i> Presentation</h4>
    <button class="btn btn-sm btn-primary" id="btn-print">
        <i class="fas fa-print"></i> Print
    </button>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="presentationTabs">
    <li class="nav-item col-3 text-center">
        <a class="nav-link active" data-toggle="tab" href="#tab-quality">
            <i class="fas fa-check-circle"></i> Chất lượng theo tháng
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-revenue">
            <i class="fas fa-dollar-sign"></i> Doanh thu theo sản phẩm
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-category">
            <i class="fas fa-tags"></i> Sản phẩm theo category
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-output">
            <i class="fas fa-industry"></i> Sản lượng theo tháng
        </a>
    </li>
</ul>

<div class="tab-content mt-3" id="presentationTabContent">

    <!-- TAB 1: CHẤT LƯỢNG -->
    <div class="tab-pane fade show active" id="tab-quality">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0"><i class="fas fa-chart-line"></i> Biểu đồ chất lượng theo tháng</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-quality" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Bảng số liệu</h6>
                    </div>
                    <div class="card-body p-0" id="table-quality">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tháng</th>
                                    <th>Passed</th>
                                    <th>Failed</th>
                                    <th>Tỷ lệ lỗi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quality_trend as $q): ?>
                                <?php
                                    $total = $q['passed'] + $q['failed'];
                                    $rate  = $total > 0 ? round($q['failed'] / $total * 100, 1) : 0;
                                ?>
                                <tr>
                                    <td><?= $q['month'] ?></td>
                                    <td class="text-success font-weight-bold"><?= number_format($q['passed']) ?></td>
                                    <td class="text-danger font-weight-bold"><?= number_format($q['failed']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $rate > 10 ? 'danger' : ($rate > 5 ? 'warning' : 'success') ?>">
                                            <?= $rate ?>%
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: DOANH THU -->
    <div class="tab-pane fade" id="tab-revenue">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h6 class="m-0"><i class="fas fa-chart-pie"></i> Biểu đồ doanh thu theo sản phẩm</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-revenue" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Bảng số liệu</h6>
                    </div>
                    <div class="card-body p-0" id="table-revenue">
                        <table class="table table-bordered table-hover mb-0" >
                            <thead class="thead-dark">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalRevenue = array_sum(array_column($revenue_data, 'value'));
                                foreach ($revenue_data as $r):
                                    $pct = $totalRevenue > 0 ? round($r['value'] / $totalRevenue * 100, 1) : 0;
                                ?>
                                <tr>
                                    <td><?= esc($r['name']) ?></td>
                                    <td class="text-success font-weight-bold">
                                        <?= number_format($r['value']) ?> đ
                                    </td>
                                    <td>
                                        <div class="progress" style="height:16px;">
                                            <div class="progress-bar bg-success" style="width:<?= $pct ?>%">
                                                <?= $pct ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th>Tổng</th>
                                    <th colspan="2"><?= number_format($totalRevenue) ?> đ</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: CATEGORY -->
    <div class="tab-pane fade" id="tab-category">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-white">
                        <h6 class="m-0"><i class="fas fa-chart-pie"></i> Biểu đồ sản phẩm theo category</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-category" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Bảng số liệu</h6>
                    </div>
                    <div class="card-body p-0" id="table-category">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Category</th>
                                    <th>Sản lượng</th>
                                    <th>Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalCat = array_sum(array_column($category_data, 'value'));
                                foreach ($category_data as $c):
                                    $pct = $totalCat > 0 ? round($c['value'] / $totalCat * 100, 1) : 0;
                                ?>
                                <tr>
                                    <td><?= esc($c['name']) ?></td>
                                    <td class="font-weight-bold"><?= number_format($c['value']) ?></td>
                                    <td>
                                        <div class="progress" style="height:16px;">
                                            <div class="progress-bar bg-warning" style="width:<?= $pct ?>%">
                                                <?= $pct ?>%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th>Tổng</th>
                                    <th colspan="2"><?= number_format($totalCat) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: SẢN LƯỢNG -->
    <div class="tab-pane fade" id="tab-output">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h6 class="m-0"><i class="fas fa-chart-bar"></i> Biểu đồ sản lượng theo tháng</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-output" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Bảng số liệu</h6>
                    </div>
                    <div class="card-body p-0" id="table-output">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tháng</th>
                                    <th>Good</th>
                                    <th>Defect</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalGood   = 0;
                                $totalDefect = 0;
                                foreach ($monthly_output as $m):
                                    $total = $m['good_qty'] + $m['defect_qty'];
                                    $totalGood   += $m['good_qty'];
                                    $totalDefect += $m['defect_qty'];
                                ?>
                                <tr>
                                    <td><?= $m['month'] ?></td>
                                    <td class="text-success font-weight-bold"><?= number_format($m['good_qty']) ?></td>
                                    <td class="text-danger font-weight-bold"><?= number_format($m['defect_qty']) ?></td>
                                    <td class="font-weight-bold"><?= number_format($total) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th>Tổng</th>
                                    <th><?= number_format($totalGood) ?></th>
                                    <th><?= number_format($totalDefect) ?></th>
                                    <th><?= number_format($totalGood + $totalDefect) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var chartQuality  = <?= $chart_quality ?>;
    var chartRevenue  = <?= $chart_revenue ?>;
    var chartCategory = <?= $chart_category ?>;
    var chartOutput   = <?= $chart_output ?>;
</script>