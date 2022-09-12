(function ($) {
    $(function () {
        $('body').click(function (e) {
            $('.wd_product_info').removeClass('wd_display_block');
        });

        $(document).on('click', '.wd_product', function (e) {
            e.stopPropagation();
            let id = $(this).attr('id');
            $('.wd_product_info').removeClass('wd_display_block');
            $(this).find('.wd_product_info').addClass('wd_display_block');
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
                        let html = '';
                        let has_link = $('.wd_recommender').data('link') > 0;
                        for (let item of data) {
                            if (has_link) {
                                html += '<a href="' + item.permalink + '">'
                            } else {
                                html += '<div class="wd_recommender_item_box" data-product-id="' + item.product_id + '">';
                            }
                            html += '<div class="wd_recommender_item">';
                            html += '<img src="' + item.image_src + '"/>';
                            html += '<span>' + item.price_html + '</span>';
                            html += '</div>';
                            if (has_link) {
                                html += '</a>';
                            } else {
                                html += '</div>';
                            }
                        }
                        $('.wd_recommender .wd_recommender_list').html(html);
                    }
                });
            }
        })

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

        $(document).on('click', '.wd_recommender .wd_recommender_item_box', function (e) {
            let product_id = $(this).data('product-id');
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
        });
    });
})(jQuery);