<?php
/*
Plugin Name: WooJoint
Description: This is a plugin that connects WooCommerce to Webjoint.
Version: 1.0
Author: Viral Magik
Author URI: https://viralmagik.com
License: GPL2
*/

if (!defined('WPINC')) {
    die;
}

define('WEBJOINT_WOOCOMMERCE_PLUGIN_NAME', 'webjoint-woocommerce-plugin');
define('WEBJOINT_WOOCOMMERCE_PLUGIN_VERSION', '1.0');

require_once plugin_dir_path(__FILE__) . 'includes/class-webjoint-woocommerce-plugin.php';

function run_webjoint_woocommerce_plugin() {
    $plugin = new Webjoint_WooCommerce_Plugin();
    $plugin->run();
}

run_webjoint_woocommerce_plugin();