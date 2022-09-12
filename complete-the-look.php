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