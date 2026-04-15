/* global $ */
$(document).ready(function() {

    // Hàm đọc cookie
    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    // Khôi phục trạng thái
    if (getCookie('sidebarCollapsed') === 'true') {
        $('#sidebar').addClass('collapsed');
        $('body').addClass('sidebar-collapsed');
        $('.toggle-icon').removeClass('bi-toggle-on').addClass('bi-toggle-off');
    }

    $('#sidebarToggle').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('body').toggleClass('sidebar-collapsed');

        let isCollapsed = $('#sidebar').hasClass('collapsed');
        document.cookie = 'sidebarCollapsed=' + isCollapsed + '; path=/; max-age=86400';

        let icon = $(this).find('.toggle-icon');
        if (isCollapsed) {
            icon.removeClass('bi-toggle-on').addClass('bi-toggle-off');
        } else {
            icon.removeClass('bi-toggle-off').addClass('bi-toggle-on');
        }
    });

    $('#sidebarClose').on('click', function() {
        $('#sidebar').toggleClass('collapsed');
        $('body').toggleClass('sidebar-collapsed');
    });
    
    // Sidebar dropdown
    $('.nav-item > div.d-flex').on('click', function() {
        var submenu = $(this).next('.menu-content');
        if (!submenu.length) return;

        var isOpen = !submenu.hasClass('d-none');

        // Đóng tất cả submenu khác
        $('.menu-content').addClass('d-none');
        $('.menu-arrow').removeClass('rotate-90');

        if (!isOpen) {
            submenu.removeClass('d-none');
            $(this).find('.menu-arrow').addClass('rotate-90');
        }
    });

    // Auto mở submenu nếu có item active bên trong
    $('.menu-content').each(function() {
        if ($(this).find('.sidebar-group-active').length) {
            $(this).removeClass('d-none');
            $(this).prev('.d-flex').find('.menu-arrow').addClass('rotate-90');
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();
});