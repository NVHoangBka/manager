let currentDepartmentId = null;

$(document).ready(function() {
    // Click chọn bộ phận
    $('.department-item').on('click', function(e) {
        e.preventDefault();
        
        $('.department-item').removeClass('item-active');
        $(this).addClass('item-active');
        
        currentDepartmentId = $(this).data('id');
        const deptName = $(this).data('name');
        
        $('#selected-department').text('Phân quyền cho: ' + deptName);
        $('#btn-save-permission').prop('disabled', false);
        loadPermissions(currentDepartmentId);
    });

    // Lưu phân quyền
    $('#btn-save-permission').on('click', function() {
        savePermissions();
    });
});

function loadPermissions(departmentId) {
    $.get(baseUrl + 'department-permissions/get/' + departmentId, function(res) {
        if (res.status === 'success') {
            renderPermissionTable(res.data);
        }
    });
}

function renderPermissionTable(existingPerms) {
    let html = `<table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Module</th>`;
    
    permissions.forEach(perm => {
        html += `<th class="text-center">${perm}</th>`;
    });
    html += `</tr></thead><tbody>`;

    Object.keys(modules).forEach(module => {
        html += `<tr>
            <td><strong>${modules[module]}</strong></td>`;
        
        permissions.forEach(perm => {
            const isChecked = existingPerms.some(p => 
                p.module === module && p.permission === perm
            );
            
            html += `
                <td class="text-center">
                    <input type="checkbox" class="perm-checkbox" 
                           data-module="${module}" 
                           data-permission="${perm}" 
                           ${isChecked ? 'checked' : ''}>
                </td>`;
        });
        html += `</tr>`;
    });

    html += `</tbody></table>`;
    $('#permission-area').html(html);
}

function savePermissions() {
    let items = [];
    
    $('.perm-checkbox:checked').each(function() {
        items.push({
            module: $(this).data('module'),
            permission: $(this).data('permission')
        });
    });

    $.post(baseUrl + 'department-permissions/save', {
        department_id: currentDepartmentId,
        items: items
    }, function(res) {
        if (res.status === 'success') {
            alert('✅ Phân quyền đã được lưu thành công!');
        } else {
            alert('❌ Lỗi: ' + res.message);
        }
    }, 'json');
}