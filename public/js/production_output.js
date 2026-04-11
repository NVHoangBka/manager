/* global jspreadsheet, XLSX, outputData, $ */
$(document).ready(function() {
    
    var importedData = [];

    var data = outputData.map(function(r) {
            return [
                r.id, r.wo_number, r.product_name,
                r.output_date, r.good_qty, r.defect_qty,
                r.shift, r.worker_name, r.machine_name
            ];
    });
    
    var table = jspreadsheet(document.getElementById('jexcel-output'), {
        tabs: true,
        toolbar: true,
        worksheets: [{
            data: data,
            columns: [
                { type: 'hidden',   title: 'ID' },
                { type: 'text',     title: 'Work Order',  width: 120, readOnly: true },
                { type: 'text',     title: 'Product',     width: 150, readOnly: true },
                { type: 'calendar', title: 'Date',        width: 110 },
                { type: 'numeric',  title: 'Good Qty',    width: 100 },
                { type: 'numeric',  title: 'Defect Qty',  width: 100 },
                { type: 'dropdown', title: 'Shift',       width: 110,
                  source: ['morning', 'afternoon', 'night'] },
                { type: 'text',     title: 'Worker',      width: 130, readOnly: true },
                { type: 'text',     title: 'Machine',     width: 130, readOnly: true }
            ],
            allowInsertRow: true,
            allowDeleteRow: true,
            search: true,
            pagination: 20
        }]
    });

    // Add row
    $('#btn-add-row').on('click', function() {
        table[0].insertRow();
    });

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var csrfName  = $('meta[name="csrf-name"]').attr('content');
    
    // Save
    $('#btn-save').on('click', function() {
        var data = table[0].getData();
        var rows = data.map(function(r) {
            return {
                id:          r[0],
                wo_number:   r[1],
                product_name:r[2],
                output_date: r[3],
                good_qty:    r[4],
                defect_qty:  r[5],
                shift:       r[6]
            };
        });

        $.ajax({
            url: baseUrl + 'production-output/save',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(rows),
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                if (res.status === 'success') {
                    alert('Saved successfully!');
                } else {
                    alert('Error: ' + res.message);
                }
            }
        });
    });
    
    $('#btn-import').on('click', function() {
        $('#input-excel-output').val('').click();
    });
    
        // Đọc file Excel
    $('#input-excel-output').on('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;

        var reader = new FileReader();
        reader.onload = function(e) {
            var data     = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });

            // Lấy sheet đầu tiên
            var sheetName = workbook.SheetNames[0];
            var sheet     = workbook.Sheets[sheetName];

            // Convert sang JSON
            var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            if (jsonData.length < 2) {
                alert('File Excel trống hoặc không có dữ liệu!');
                return;
            }

            // Lấy header row
            var headers = jsonData[0];
            // Lấy data rows
            var rows = jsonData.slice(1).filter(function(r) {
                return r.length > 0 && r[0];
            });

            importedData = rows;

            // Hiển thị preview
            showPreview(headers, rows);
            $('#modal-import').modal('show');
        };
        reader.readAsArrayBuffer(file);
    });
    
    // Hiển thị bảng preview
    function showPreview(headers, rows) {
        var html = '<table class="table table-bordered table-sm table-hover">';
        html += '<thead class="thead-dark"><tr>';
        html += '<th>#</th>';
        headers.forEach(function(h) {
            html += '<th>' + h + '</th>';
        });
        html += '</tr></thead><tbody>';

        rows.slice(0, 20).forEach(function(row, i) {
            html += '<tr>';
            html += '<td>' + (i + 1) + '</td>';
            row.forEach(function(cell) {
                html += '<td>' + (cell !== undefined ? cell : '') + '</td>';
            });
            html += '</tr>';
        });

        html += '</tbody></table>';

        if (rows.length > 20) {
            html += '<p class="text-muted">Hiển thị 20/' + rows.length + ' dòng</p>';
        }

        $('#import-preview').html(html);
    }

    // Confirm import → load vào jspreadsheet
    $('#btn-confirm-import').on('click', function() {
        if (!importedData.length) return;

        // Xóa data cũ trong bảng
        var currentRows = table[0].getData().length;
        for (var i = currentRows - 1; i >= 0; i--) {
            table[0].deleteRow(i);
        }

        // Thêm data mới
        importedData.forEach(function(row) {
            table[0].insertRow([
                '',         // id (trống = new record)
                row[0] || '', // work order
                row[1] || '', // product
                row[2] || '', // date
                row[3] || 0,  // good qty
                row[4] || 0,  // defect qty
                row[5] || 'morning', // shift
                '',           // worker
                ''           // machine
            ]);
        });

        $('#modal-import').modal('hide');
        alert('Import thành công ' + importedData.length + ' dòng! Nhấn Save để lưu vào database.');
    });
});