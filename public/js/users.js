/* global $ */
$(document).ready(function() {
    if ($('#users-table').length) {
        $('#users-table').DataTable({
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: { previous: "Prev", next: "Next" }
            }
        });
    }
    
    // Print.js
    $('#btn-print').on('click', function() {
        printJS({
            printable: 'users-table',
            type: 'html',
            ignoreElements: ['action'],
            style: 'table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px}'
        });
    });
    
});
