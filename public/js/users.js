/* global $ baseUrl */
$(document).ready(function() {

    // DataTable
    if ($('#users-table').length) {
        $('#users-table').DataTable({
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: { previous: "Prev", next: "Next" }
            },
            order: [[0, 'desc']]
        });
    }

    // Print button
    $('#btn-print').on('click', function() {
        printJS({
            printable: 'users-table',
            type: 'html',
            ignoreElements: ['#action'],
            style: 'table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px}'
        });
    });

    // ====================== FORM SUBMIT (Add & Update) ======================
    $('#user-form').on('submit', function(e) {
        e.preventDefault();

        var url = $(this).attr('action');
        var formData = $(this).serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    showAlert('success', res.message);
                    setTimeout(() => location.reload(), 800);
                } else {
                    showErrors(res.errors);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra. Vui lòng thử lại!');
            }
        });
    });

    // ====================== EDIT USER ======================
    $(document).on('click', '.btn-edit-user', function(e) {
        e.preventDefault();
        
        var id = $(this).closest('tr').data('id');
        var row = $(this).closest('tr');

        // Điền dữ liệu vào form
        $('#f-user_name').val(row.find('td:eq(1)').text().trim()).prop('readonly', true);
        $('#f-fullname').val(row.find('td:eq(2)').contents().filter(function(){ 
            return this.nodeType === 3; 
        }).text().trim());
        $('#f-email').val(row.find('td:eq(2) small').text().trim());
        $('#f-role').val(row.find('td:eq(3) .badge').text().trim().toLowerCase());
        $('#f-status').val(row.find('td:eq(4) .badge').text().trim() === 'Active' ? 1 : 0);

        // Thay đổi form thành mode Edit
        $('#user-form').attr('action', baseUrl + 'api/users/update/' + id);
        $('#form-title').html('<i class="fas fa-user-edit"></i> Edit User');
        $('#btn-submit').html('<i class="fas fa-save"></i> Update');
        $('#btn-cancel').show();
        $('#pass-hint').text('(Bỏ trống nếu không đổi mật khẩu)');
        
        // Scroll lên form
        $('html, body').animate({ scrollTop: $('.card.shadow').eq(1).offset().top - 20 }, 500);
    });

    // ====================== CANCEL EDIT ======================
    $('#btn-cancel').on('click', function() {
        resetForm();
    });

    // ====================== DELETE USER ======================
    $(document).on('click', '.btn-delete-user', function() {
        if (!confirm('Bạn có chắc chắn muốn xóa người dùng này?')) return;

        var btn = $(this);
        var id = btn.data('id');
        var row = btn.closest('tr');

        $.ajax({
            url: baseUrl + 'api/users/delete/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.status === 'success') {
                    row.fadeOut(400, function() { $(this).remove(); });
                    showAlert('success', res.message);
                } else {
                    showAlert('danger', res.message);
                }
            },
            error: function() {
                showAlert('danger', 'Xóa thất bại! Vui lòng thử lại.');
            }
        });
    });

    // ====================== HELPER FUNCTIONS ======================
    function showAlert(type, message) {
        $('#alert-container').html(`
            <div class="alert alert-${type} alert-dismissible fade show">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${message}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        `);
    }

    function showErrors(errors) {
        let html = '<div class="alert alert-danger"><ul class="mb-0">';
        $.each(errors, function(key, msg) {
            html += `<li>${msg}</li>`;
        });
        html += '</ul></div>';
        
        $('#user-form').find('.alert-danger').remove();
        $('#user-form').prepend(html);
    }

    function resetForm() {
        $('#user-form')[0].reset();
        $('#user-form').attr('action', baseUrl + 'api/users/store');
        $('#form-title').html('<i class="fas fa-user-plus"></i> Add New User');
        $('#btn-submit').html('<i class="fas fa-save"></i> Save');
        $('#btn-cancel').hide();
        $('#f-user_name').prop('readonly', false);
        $('#pass-hint').text('(Nhập nếu muốn đổi mật khẩu)');
        $('#alert-container').empty();
    }
});