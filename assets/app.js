(function ($) {
    $(function () {
        $('body').click(function (e) {
            $('.wd_product_info').removeClass('wd_display_block');
        });

        $(document).on('click', '.wd_product', function (e) {
                e.stopPropagation();
                let id = $(this).attr('id');
                if ($('.wd_recommender').length > 0) {
                    $('.wd_recommender').data('target', id);
                    let sku = $(this).data('sku');
                    let data = {
                        action: 'wd_search_by_sku',
                        sku: sku,
                    };
                    $.ajax({
                        url: complete_the_look_plugin_ajax.ajax_url,
                        type: 'POST',
                        data: data,
                        success: function (data) {
                            $('.wd_recommender .wd_recommender_list').html(data.html);
                        }
                    });
                }
            }
        );

        $(document).on('click', '.wd_add_to_cart_btn', function (e) {
            e.preventDefault();
            let $this = $(this);
            let product_id = $(this).data('product-id');
            let data = {
                action: 'wd_woocommerce_ajax_add_to_cart',
                product_id: product_id,
                quantity: 1
            };
            $.ajax({
                url: complete_the_look_plugin_ajax.ajax_url,
                type: 'POST',
                data: data,
                beforeSend: function (response) {

                },
                complete: function (response) {

                },
                success: function (response) {

                }
            })
        });

        $(document).on('click', '.wd_recommender.click-active .wd_recommender_list a.woocommerce-loop-product__link', function (e) {
            e.stopPropagation();
            let product_id = $(this).parent('.product').find('.add_to_cart_button').data('product_id');
            let target_id = $('.wd_recommender').data('target');
            let target = $('#' + target_id);
            let data = {
                action: 'wd_product_by_id',
                product_id: product_id,
                target_id: target_id,
            };
            $.ajax({
                url: complete_the_look_plugin_ajax.ajax_url,
                type: 'POST',
                data: data,
                success: function (data) {
                    target.parent('div').html(data.product);
                }
            });
            return false;
        });

        $(document).on('mouseleave', '.wd_product', function () {
            $('.wd_plus').removeClass('wd_display_block');
        });

        $(document).on('mouseenter', '.wd_product', function () {
            $('.wd_plus').removeClass('wd_display_block');
            $(this).find('.wd_plus').addClass('wd_display_block');
        });

        $(document).on('click', '.wd_plus', function (e) {
            e.stopPropagation();
            $('.wd_product_info').removeClass('wd_display_block');
            $(this).parent('.wd_product').find('.wd_product_info').addClass('wd_display_block');
        });
    });
})(jQuery);