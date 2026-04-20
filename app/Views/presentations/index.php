<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-chart-bar"></i> Presentation</h4>
    <div> 
        <button class="btn btn-sm btn-primary" id="btn-print">
            <i class="fas fa-print"></i> Print
        </button>
        <button id="btn-refresh" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-sync"></i> Refresh All Charts
        </button>
    </div>
</div>

<div id="alert-container"></div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="presentationTabs">
    <li class="nav-item col-3 text-center">
        <a class="nav-link active" data-toggle="tab" href="#tab-quality">
            <i class="fas fa-check-circle"></i> Quality by Month
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-revenue">
            <i class="fas fa-dollar-sign"></i> Revenue by Product
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-category">
            <i class="fas fa-tags"></i> Products by Category
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-output">
            <i class="fas fa-industry"></i> Output by Month
        </a>
    </li>
</ul>

<div class="tab-content mt-3" id="presentationTabContent">

    <!-- TAB 1: QUALITY -->
    <div class="tab-pane fade show active" id="tab-quality">
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="m-0"><i class="fas fa-chart-line"></i> Monthly Quality Chart</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-quality" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Data Table</h6>
                    </div>
                    <div class="card-body p-0" id="table-quality">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Month</th>
                                    <th>Passed</th>
                                    <th>Failed</th>
                                    <th>Defect Rate</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
                        <h6 class="m-0"><i class="fas fa-chart-pie"></i> Revenue by Product Chart</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-revenue" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Data Table</h6>
                    </div>
                    <div class="card-body p-0" id="table-revenue">
                        <table class="table table-bordered table-hover mb-0" >
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Revenue</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot class="thead-dark">
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
                        <h6 class="m-0"><i class="fas fa-chart-pie"></i> Products by Category Chart</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-category" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Data Table</h6>
                    </div>
                    <div class="card-body p-0" id="table-category">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Category</th>
                                    <th>Output</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot class="thead-dark">
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
                        <h6 class="m-0"><i class="fas fa-chart-bar"></i> Monthly Output Chart</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart-output" style="height:320px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h6 class="m-0"><i class="fas fa-table"></i> Data Table</h6>
                    </div>
                    <div class="card-body p-0" id="table-output">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Month</th>
                                    <th>Good</th>
                                    <th>Defect</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot class="thead-dark">
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>