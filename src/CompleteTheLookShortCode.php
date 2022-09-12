<?php

namespace Shopeo\CompleteTheLook;

use WC_Product;

class CompleteTheLookShortCode
{
    public function __construct()
    {
        add_shortcode('complete-the-look', array($this, 'render'));
    }

    private function get_product_by_sku($sku)
    {
        global $wpdb;
        $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));
        if ($product_id) {
            return new WC_Product($product_id);
        } else {
            return null;
        }
    }

    public function render($atts = [], $content = null)
    {
        $id = $atts['id'];
        $pid = $atts['pid'];
        $sku = $atts['sku'];
        $product = null;
        if ($pid && !$sku) {
            $product = new WC_Product($pid);
        }
        if ($sku && !$pid) {
            $product = $this->get_product_by_sku($sku);
        }

        $body = '<div id="' . $id . '" class="wd_product" data-product-id="' . $product->get_id() . '" data-sku="' . $product->get_sku() . '">';
        $body .= $product->get_image();
        $body .= '<div class="wd_product_info">';
        $body .= '<div class="wd_product_name">' . $product->get_name() . '</div>';
        $body .= '<div class="wd_product_image">' . $product->get_image() . '</div>';
        $body .= '<div class="wd_product_price">' . $product->get_price_html() . '</div>';
        $body .= '<div class="wd_product_cart_btn"><button class="wd_add_to_cart_btn" data-product-id="' . $product->get_id() . '" data-sku="' . $product->get_sku() . '">' . __('Add to cart', 'complete-the-look') . '</button></div>';
        $body .= '</div>';
        $body .= '</div>';
        return $body;
    }
}