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

    $('[data-toggle="tooltip"]').tooltip();
});