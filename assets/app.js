(function ($) {
    $(function () {
        $('.wd_product').click(function (e) {
            $('.wd_product_info').removeClass('wd_display_block');
            $(this).find('.wd_product_info').addClass('wd_display_block');
        });

        $('.wd_add_to_cart_btn').click(function (e) {
            e.preventDefault();

        });
    });
})(jQuery);