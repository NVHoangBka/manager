<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-boxes"></i> Materials</h4>
    <div>
        <button class="btn btn-sm btn-success" id="btn-save">
            <i class="fas fa-save"></i> Save
        </button>
        <button class="btn btn-sm btn-primary ml-1" id="btn-add-row">
            <i class="fas fa-plus"></i> Add Row
        </button>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <div id="jexcel-materials"></div>
    </div>
</div>

<script>
    var materialsData = <?= $materials_json ?>;
</script>