<?php
/*
Plugin Name: WebJoint WooCommerce Sync
Plugin URI: https://viralmagik.com/
Description: This plugin syncs WooCommerce data with WebJoint.
Version: 1.0.0
Author: Viral Magik
Author URI: https://viralmagik.com/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: webjoint-woocommerce-sync
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define constants
define( 'WEBJOINT_WOOCOMMERCE_SYNC_VERSION', '1.0.0' );
define( 'WEBJOINT_WOOCOMMERCE_SYNC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include the necessary files
require_once( WEBJOINT_WOOCOMMERCE_SYNC_PLUGIN_DIR . 'includes/class-webjoint-settings.php' );
require_once( WEBJOINT_WOOCOMMERCE_SYNC_PLUGIN_DIR . 'includes/class-webjoint-api.php' );
require_once( WEBJOINT_WOOCOMMERCE_SYNC_PLUGIN_DIR . 'includes/class-webjoint-sync.php' );

// Register activation and deactivation hooks
register_activation_hook( __FILE__, 'webjoint_woocommerce_sync_activate' );
register_deactivation_hook( __FILE__, 'webjoint_woocommerce_sync_deactivate' );

function webjoint_woocommerce_sync_activate() {
    // Here you can add code that should run when the plugin is activated, such as creating database tables or scheduling events
}

function webjoint_woocommerce_sync_deactivate() {
    // Here you can add code that should run when the plugin is deactivated, such as unscheduling events
}