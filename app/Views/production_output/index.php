<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-industry"></i> Production Output</h4>
    <div>
        <button class="btn btn-sm btn-success" id="btn-save">
            <i class="fas fa-save"></i> Save
        </button>
        <button class="btn btn-sm btn-primary ml-1" id="btn-add-row">
            <i class="fas fa-plus"></i> Add Row
        </button>
        <a href="<?= base_url('production-output/export') ?>" class="btn btn-sm btn-warning ml-1">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        <button class="btn btn-sm btn-info ml-1" id="btn-import">
            <i class="fas fa-file-upload"></i> Import Excel
        </button>
        <input type="file" id="input-excel-output" accept=".xlsx,.xls,.csv" style="display:none;">
    </div>
</div>

<!-- Modal preview trước khi import -->
<div class="modal fade" id="modal-import" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-file-excel"></i> Preview Import Data</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    File Excel cần có đúng thứ tự cột:
                    <strong>Work Order | Product | Date | Good Qty | Defect Qty | Shift</strong>
                </div>
                <div id="import-preview" class="table-responsive"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn-confirm-import">
                    <i class="fas fa-check"></i> Confirm Import
                </button>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body p-0">
        <div id="jexcel-output"></div>
    </div>
</div>

<script>
    var outputData = <?= $outputs_json ?>;
</script>