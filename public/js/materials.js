/* global jspreadsheet, materialsData, $ */
$(document).ready(function() {
    
    var data = materialsData.map(function(r) {
        return [
            r.id, r.code, r.name, r.type,
            r.unit, r.stock_qty, r.min_stock,
            r.unit_cost, r.status
        ];
    });
    var table = jspreadsheet(document.getElementById('jexcel-materials'), {
        worksheets: [{
            data: data,
            columns: [
                { type: 'hidden',   title: 'ID' },
                { type: 'text',     title: 'Code',      width: 100 },
                { type: 'text',     title: 'Name',      width: 180 },
                { type: 'dropdown', title: 'Type',      width: 120,
                  source: ['fabric','stuffing','accessory','packaging','other'] },
                { type: 'text',     title: 'Unit',      width: 80  },
                { type: 'numeric',  title: 'Stock Qty', width: 100 },
                { type: 'numeric',  title: 'Min Stock', width: 100 },
                { type: 'numeric',  title: 'Unit Cost', width: 110 },
                { type: 'dropdown', title: 'Status',    width: 90,
                  source: [{id:'1', name:'Active'}, {id:'0', name:'Inactive'}] }
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
                id:        r[0],
                code:      r[1],
                name:      r[2],
                type:      r[3],
                unit:      r[4],
                stock_qty: r[5],
                min_stock: r[6],
                unit_cost: r[7],
                status:    r[8]
            };
        });

        $.ajax({
            url: baseUrl + 'materials/save',
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
});