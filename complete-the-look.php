<?php
/**
 * Plugin Name: Complete The Look
 * Plugin URI: https://www.shopeo.cn
 * Description: Complete the look.
 * Author: Shopeo
 * Version: 0.0.1
 * Author URI: https://www.shopeo.cn
 * License: GPL2+
 * Text Domain: complete-the-look
 * Domain Path: /languages
 * Requires at least: 5.9
 * Requires PHP: 5.6
 */

require_once 'vendor/autoload.php';

use Shopeo\CompleteTheLook\CompleteTheLookShortCode;
use Shopeo\CompleteTheLook\RecommenderSearch;

if (!defined('ABSPATH')) {
    exit();
}

if (!defined('COMPLETE_THE_LOOK_PLUGIN_FILE')) {
    define('COMPLETE_THE_LOOK_PLUGIN_FILE', __FILE__);
}

if (!defined('COMPLETE_THE_LOOK_PLUGIN_BASE')) {
    define('COMPLETE_THE_LOOK_PLUGIN_BASE', plugin_basename(COMPLETE_THE_LOOK_PLUGIN_FILE));
}

if (!defined('COMPLETE_THE_LOOK_PATH')) {
    define('COMPLETE_THE_LOOK_PATH', plugin_dir_path(COMPLETE_THE_LOOK_PLUGIN_FILE));
}

if (!function_exists('complete_the_look_active')) {
    function complete_the_look_active()
    {

    }
}

register_activation_hook(__FILE__, 'complete_the_look_active');


if (!function_exists('complete_the_look_deactive')) {
    function complete_the_look_deactive()
    {

    }
}
register_deactivation_hook(__FILE__, 'complete_the_look_deactive');

if (!function_exists('complete_the_look_load_textdomain')) {
    function complete_the_look_load_textdomain()
    {
        load_plugin_textdomain('complete-the-look', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}

add_action('init', 'complete_the_look_load_textdomain');

$complete_the_look_short_code = new CompleteTheLookShortCode();

if (!function_exists('complete_the_look_scripts')) {
    function complete_the_look_scripts()
    {
        $plugin_data = get_plugin_data(__FILE__);
        $version = '1.0.0';
        if (is_array($plugin_data) && array_key_exists('Version', $plugin_data)) {
            $version = $plugin_data['Version'];
        }
        wp_enqueue_style('complete-the-look-plugin-style', plugin_dir_url(__FILE__) . '/assets/app.css', array(), $version);
        wp_enqueue_script('complete-the-look-plugin-script', plugin_dir_url(__FILE__) . '/assets/app.js', array('jquery'), $version);
        wp_localize_script('complete-the-look-plugin-script', 'complete_the_look_plugin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}
add_action('wp_enqueue_scripts', 'complete_the_look_scripts');

if (!function_exists('wd_woocommerce_ajax_add_to_cart')) {
    function wd_woocommerce_ajax_add_to_cart()
    {
        $product_id = apply_filters('wd_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $passed_validation = apply_filters('wd_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);
        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity) && 'publish' === $product_status) {
            do_action('wd_woocommerce_ajax_added_to_cart', $product_id);
            if ('yes' === get_option('wd_woocommerce_cart_redirect_after_add')) {
                wc_add_to_cart_message(array($product_id => $quantity), true);
            }
        } else {
            $data = array(
                'error' => true,
                'product_url' => apply_filters('wd_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
            wp_send_json($data);
        }
        wp_die();
    }
}

add_action('wp_ajax_wd_woocommerce_ajax_add_to_cart', 'wd_woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_wd_woocommerce_ajax_add_to_cart', 'wd_woocommerce_ajax_add_to_cart');

if (!function_exists('wd_search_by_sku')) {
    function wd_search_by_sku()
    {
        $sku = $_POST['sku'];
        $search = new RecommenderSearch();
        $result = $search->search($sku);
        ob_start();
        ?>
        <ul class="products related">
            <?php
            foreach ($result as $item) {
                $post_object = get_post($item->product_id);
                setup_postdata($GLOBALS['post'] =& $post_object);
                wc_get_template_part('content', 'product');
            }
            ?>
        </ul>
        <?php
        wp_reset_postdata();
        $body = ob_get_contents();
        ob_end_clean();
        wp_send_json(array('html' => $body));
    }
}

add_action('wp_ajax_wd_search_by_sku', 'wd_search_by_sku');
add_action('wp_ajax_nopriv_wd_search_by_sku', 'wd_search_by_sku');

if (!function_exists('wd_product_by_id')) {
    function wd_product_by_id()
    {
        $product_id = $_POST['product_id'];
        $target_id = $_POST['target_id'];
        $product = new WC_Product($product_id);
        $body = '<div id="' . $target_id . '" class="wd_product" data-product-id="' . $product->get_id() . '" data-sku="' . $product->get_sku() . '">';
        $body .= $product->get_image();
        $body .= '<div class="wd_plus"><span>+</span></div>';
        $body .= '<div class="wd_product_info">';
        $body .= '<div class="wd_product_name">' . $product->get_name() . '</div>';
        $body .= '<div class="wd_product_image">' . $product->get_image() . '</div>';
        $body .= '<div class="wd_product_price">' . $product->get_price_html() . '</div>';
        $body .= '<div class="wd_product_cart_btn"><button class="wd_add_to_cart_btn" data-product-id="' . $product->get_id() . '" data-sku="' . $product->get_sku() . '">' . __('Add to cart', 'complete-the-look') . '</button></div>';
        $body .= '</div>';
        $body .= '</div>';
        wp_send_json(array('product' => $body));
    }
}

add_action('wp_ajax_wd_product_by_id', 'wd_product_by_id');
add_action('wp_ajax_nopriv_wd_product_by_id', 'wd_product_by_id');