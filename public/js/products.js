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
    
    // Preview nhiều ảnh mới
    $('#input-images').on('change', function() {
        $('#new-images-preview').empty();
        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            (function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#new-images-preview').append(
                        '<div class="mr-2 mb-2">' +
                        '<img src="' + e.target.result + '" width="80" height="80" ' +
                        'style="object-fit:cover;border-radius:6px;border:1px solid #ddd;">' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            })(files[i]);
        }
    });

    // Xóa ảnh
    $(document).on('click', '.btn-delete-image', function() {
        if (!confirm('Xóa ảnh này?')) return;
        var imgId = $(this).data('img-id');
        var wrap  = $('#img-wrap-' + imgId);
        $.ajax({
            url: baseUrl + 'products/delete-image/' + imgId,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.status === 'success') wrap.remove();
            }
        });
    });

    // Set ảnh chính
    $(document).on('click', '.btn-set-main', function() {
        var imgId     = $(this).data('img-id');
        var productId = $(this).data('product-id');
        $.ajax({
            url: baseUrl + 'products/set-main/' + productId + '/' + imgId,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.status === 'success') location.reload();
            }
        });
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
    
    // Tab active
    $('#productTabs .product-item').on('click', function() {
        $('#productTabs .product-item').removeClass('product-item-active');
        $(this).addClass('product-item-active');
    });
    
    function loadProduct(p) {
        var id       = $(p).data('id');
        var name     = $(p).data('name');
        var price    = $(p).data('price');
        var code     = $(p).data('code');
        var category = $(p).data('category');
        var size     = $(p).data('size');
        var status   = $(p).data('status');
        var image    = $(p).data('image');
        
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
            $('#detail-image-placeholder').removeClass('d-flex');
        } else {
            $('#detail-image-main, #detail-image-thumb').hide();
            $('#detail-image-placeholder').show();
            $('#detail-image-placeholder').addClass('d-flex');
        }
        
        $.ajax({
            url: baseUrl + 'products/info/' + id,
            method: 'GET',
            success: function(res) {
                if (res.status === 'success') {
                    $('#detail-orders').text(res.total_orders);
                    $('#detail-revenue').text('$' + res.revenue);
                    $('#detail-stock').text(res.stock);
                    
                    // Hiển thị ảnh
                    if (res.images && res.images.length > 0) {
                        var mainImg = res.images.find(function(i) { return i.is_main == 1; }) || res.images[0];
                        $('#detail-image-main').attr('src', mainImg.url).show();
                        $('#detail-image-placeholder').hide();

                        // Thumbnail gallery
                        var thumbs = '';
                        res.images.forEach(function(img) {
                            thumbs += '<img src="' + img.url + '" width="60" height="60" ' +
                                'class="image-thumb mr-2 mb-1" data-src="' + img.url + '" ' +
                                'style="object-fit:cover;border-radius:4px;cursor:pointer;' +
                                'border:' + (img.is_main ? '2px solid #007bff' : '1px solid #ddd') + ';">';
                        });
                        $('#detail-image-thumbs').html(thumbs);
                        $('#detail-image-gallery').show();
                    } else {
                        $('#detail-image-main').hide();
                        $('#detail-image-placeholder').show();
                        $('#detail-image-gallery').hide();
                    }
                    
                    loadOrderHistory(res.orders);
                    loadWarehouseStock(res.stock, res.produced, res.sold);
                }
            },
            error: function() {
                $('#detail-orders, #detail-revenue, #detail-stock').text('—');
            }
        });
    }
    
    // Click thumbnail → đổi ảnh chính
    $(document).on('click', '.image-thumb', function() {
        var src = $(this).data('src');
        $('#detail-image-main').attr('src', src);
        $('.image-thumb').css('border', '1px solid #ddd');
        $(this).css('border', '2px solid #007bff');
    });

    // Click product trong danh sách → active
    $('.product-items .product-item').on('click', function() {
        // Active item
        $('.product-items .product-item').removeClass('product-item-active');
        $(this).addClass('product-item-active');
        
        loadProduct(this);
    });
    
    // Auto click item đầu tiên khi load trang
    var firstItem = $('.product-items .product-item:first');
    if (firstItem.length) {
        firstItem.addClass('product-item-active');
        loadProduct(firstItem[0]);
    }
});
