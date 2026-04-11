/* global $ */
$(document).ready(function() {
    if ($('#products-table').length) {
        $('#products-table').DataTable({
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: { previous: "Prev", next: "Next" }
            }
        });
    }
    
    // Preview ảnh trước khi upload
    $('#input-image').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-preview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    
    // Print.js
    $('#btn-print').on('click', function() {
        printJS({
            printable: 'products-table',
            type: 'html',
            ignoreElements: ['action'],
            style: 'table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px}'
        });
    });
    
});
