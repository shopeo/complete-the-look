(function ($) {
    $(function () {
        $('body').click(function (e) {
            $('.wd_product_info').removeClass('wd_display_block');
        });
        $('.wd_product').click(function (e) {
            e.stopPropagation();
            let id = $(this).id;
            $('.wd_product_info').removeClass('wd_display_block');
            $(this).find('.wd_product_info').addClass('wd_display_block');
            if ($('.wd_recommender').length > 0) {
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
                        console.log(data);
                        let html = '';
                        $('.wd_recommender').data('target', id);
                        let has_link = $('.wd_recommender').data('link') > 0;
                        for (let item of data) {
                            if (has_link) {
                                html += '<a href="' + item.permalink + '">'
                            } else {
                                html += '<div class="wd_recommender_item_box" data-product-id="' + item.product_id + '">';
                            }

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
        });

        $('.wd_add_to_cart_btn').click(function (e) {
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

        if ($('.wd_recommender').length > 0) {
            $('.wd_recommender .wd_recommender_item_box').click(function (e) {

            });
        }
    });
})(jQuery);