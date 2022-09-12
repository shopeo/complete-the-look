(function ($) {
    $(function () {
        $('.wd_product').click(function (e) {
            $('.wd_product_info').removeClass('wd_display_block');
            $(this).find('.wd_product_info').addClass('wd_display_block');
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
    });
})(jQuery);