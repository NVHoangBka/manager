<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-project-diagram"></i> Process Flow</h4>
    <div>
        <button class="btn btn-sm btn-success" id="btn-add-node">
            <i class="fas fa-plus"></i> Add Node
        </button>
        <button class="btn btn-sm btn-warning ml-1" id="btn-add-edge">
            <i class="fas fa-link"></i> Add Edge
        </button>
        <button class="btn btn-sm btn-outline-warning ml-1" id="btn-edgehandle">
            <i class="fas fa-bezier-curve"></i> Edge Handle
        </button>
        <button class="btn btn-sm btn-secondary" id="btn-fit">
            <i class="fas fa-compress-arrows-alt"></i> Fit
        </button>
        <button class="btn btn-sm btn-primary ml-1" id="btn-print">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="processTabs">
    <li class="nav-item col-3 text-center">
        <a class="nav-link active" data-toggle="tab" href="#tab-sewing">
            <i class="fas fa-cut"></i> Quy trình may
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-production">
            <i class="fas fa-industry"></i> Quy trình sản xuất
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-quality">
            <i class="fas fa-check-circle"></i> Kiểm tra chất lượng
        </a>
    </li>
    <li class="nav-item col-3 text-center">
        <a class="nav-link" data-toggle="tab" href="#tab-order">
            <i class="fas fa-shopping-cart"></i> Xử lý đơn hàng
        </a>
    </li>
</ul>

<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="tab-sewing">
        <div class="card shadow">
            <div class="card-body p-0">
                <div id="cy-sewing" style="height:650px;width:100%;background:#f8f9fa;"></div>
            </div>
        </div>
    </div>
    
    <div class="tab-pane fade" id="tab-production">
        <div class="card shadow">
            <div class="card-body p-0">
                <div id="cy-production" style="height:600px;width:100%;background:#f8f9fa;"></div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-quality">
        <div class="card shadow">
            <div class="card-body p-0">
                <div id="cy-quality" style="height:600px;width:100%;background:#f8f9fa;"></div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-order">
        <div class="card shadow">
            <div class="card-body p-0">
                <div id="cy-order" style="height:600px;width:100%;background:#f8f9fa;"></div>
            </div>
        </div>
    </div>

</div>

<!-- Legend -->
<div class="card shadow mt-2">
    <div class="card-body py-2 d-flex align-items-center flex-wrap gap-3">
        <span class="mr-3"><span style="display:inline-block;width:14px;height:14px;background:#28a745;border-radius:50%;"></span> Start/End</span>
        <span class="mr-3"><span style="display:inline-block;width:14px;height:14px;background:#007bff;border-radius:50%;"></span> Process</span>
        <span class="mr-3"><span style="display:inline-block;width:14px;height:14px;background:#ffc107;border-radius:50%;"></span> Decision</span>
        <span class="mr-3"><span style="display:inline-block;width:14px;height:14px;background:#dc3545;border-radius:50%;"></span> Error</span>
        <span class="text-muted ml-3" style="font-size:12px;">
            <i class="fas fa-info-circle"></i>
            Double click = sửa node | Right click = xóa | Kéo thả = di chuyển
        </span>
    </div>
</div>

<!-- Modal Add/Edit Node -->
<div class="modal fade" id="modal-node" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modal-node-title">
                    <i class="fas fa-plus"></i> Add Node
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="node-db-id">
                <input type="hidden" id="node-cy-id">
                <input type="hidden" id="node-pos-x">
                <input type="hidden" id="node-pos-y">
                
                <div class="form-group">
                    <label>Number </label>
                    <textarea id="node-number" class="form-control" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    <label>Label <span class="text-danger">*</span></label>
                    <textarea id="node-label" class="form-control" rows="2" required></textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Node Type</label>
                            <select id="node-type" class="form-control">
                                <option value="process">Process</option>
                                <option value="decision">Decision</option>
                                <option value="start">Start</option>
                                <option value="end">End</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Color</label>
                            <div class="d-flex flex-wrap gap-1">
                                <?php foreach([
                                    '#007bff' => 'Process',
                                    '#28a745' => 'Start/End',
                                    '#ffc107' => 'Decision',
                                    '#dc3545' => 'Error',
                                    '#17a2b8' => 'Info',
                                    '#6f42c1' => 'Purple',
                                    '#fd7e14' => 'Orange',
                                    '#5b9bd5' => 'Blue',
                                    '#20c997' => 'Success Light',
                                    '#6610f2' => 'Indigo',
                                    '#e83e8c' => 'Pink',
                                    '#6c757d' => 'Secondary',
                                    '#343a40' => 'Dark',
                                    '#adb5bd' => 'Gray',
                                    '#0dcaf0' => 'Cyan',
                                    '#198754' => 'Green Dark',
                                    '#ff6b6b' => 'Soft Red',
                                    '#ffd43b' => 'Soft Yellow',
                                ] as $hex => $name): ?>
                                <div class="color-option mr-1 mb-1"
                                     data-color="<?= $hex ?>"
                                     title="<?= $name ?>"
                                     style="width:28px;height:28px;background:<?= $hex ?>;border-radius:4px;cursor:pointer;border:2px solid transparent;">
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="node-color" value="#007bff">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn-save-node">
                    <i class="fas fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Edge -->
<div class="modal fade" id="modal-edge" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-link"></i> Add Edge</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>From Node (Source)</label>
                    <select id="edge-source" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>To Node (Target)</label>
                    <select id="edge-target" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label>Label (tuỳ chọn)</label>
                    <input type="text" id="edge-label" class="form-control" placeholder="Nhập label...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="btn-save-edge">
                    <i class="fas fa-save"></i> Add Edge
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Context Menu -->
<div id="cy-context-menu" style="display:none;position:fixed;z-index:9999;background:#fff;border:1px solid #ddd;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.15);min-width:150px;">
    <div class="context-item" id="ctx-edit" style="padding:8px 16px;cursor:pointer;">
        <i class="fas fa-edit text-warning"></i> Edit
    </div>
    <div class="context-item" id="ctx-delete" style="padding:8px 16px;cursor:pointer;color:#dc3545;">
        <i class="fas fa-trash"></i> Delete
    </div>
</div>

<script>
    var elementsSewing     = <?= $elements_sewing ?>;
    var elementsProduction = <?= $elements_production ?>;
    var elementsQuality    = <?= $elements_quality ?>;
    var elementsOrder      = <?= $elements_order ?>;
</script>