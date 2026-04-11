/* global $ */
$(document).ready(function() {

    // Click product trong danh sách → active
    $('.product-items .product-item').on('click', function() {
        // Active item
        $('.product-items .product-item').removeClass('product-item-active');
        $(this).addClass('product-item-active');

        var id       = $(this).data('id');
        var name     = $(this).data('name');
        var price    = $(this).data('price');
        var code     = $(this).data('code');
        var category = $(this).data('category');
        var size     = $(this).data('size');
        var status   = $(this).data('status');
        var image    = $(this).data('image');

        // Cập nhật thông tin ngay
        $('#detail-name').html('<b>' + name + '</b>');
        $('#detail-price').text('$' + price);
        $('#detail-code').text(code || '—');
        $('#detail-category').text(category || '—');
        $('#detail-size').text(size || '—');
        $('#detail-status')
            .text(status == 1 ? 'Active' : 'Inactive')
            .removeClass('badge-success badge-secondary')
            .addClass(status == 1 ? 'badge-success' : 'badge-secondary');

        // Ảnh
        if (image) {
            $('#detail-image-main').attr('src', image).show();
            $('#detail-image-thumb').attr('src', image).show();
            $('#detail-image-placeholder').hide();
        } else {
            $('#detail-image-main, #detail-image-thumb').hide();
            $('#detail-image-placeholder').show();
        }
    });

    // Tab active
    $('#productTabs .product-item').on('click', function() {
        $('#productTabs .product-item').removeClass('product-item-active');
        $(this).addClass('product-item-active');
    });

});