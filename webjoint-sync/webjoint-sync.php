<?php
/*
Plugin Name: WebJoint Sync
Plugin URI: https://viralmagik.com/webjoint-sync
Description: A plugin to sync WooCommerce data with WebJoint
Version: 1.0
Author: Viral Magik
Author URI: https://viralmagik.com
License: GPL2
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WEBJOINT_SYNC_VERSION', '1.0');
define('WEBJOINT_SYNC_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(WEBJOINT_SYNC_PLUGIN_DIR . 'includes/class-webjoint-sync-api.php');
require_once(WEBJOINT_SYNC_PLUGIN_DIR . 'includes/class-webjoint-sync-woocommerce.php');
require_once(WEBJOINT_SYNC_PLUGIN_DIR . 'includes/class-webjoint-sync-settings.php');

function activate_webjoint_sync() {
    // Code to run on plugin activation
}

function deactivate_webjoint_sync() {
    // Code to run on plugin deactivation
}

register_activation_hook(__FILE__, 'activate_webjoint_sync');
register_deactivation_hook(__FILE__, 'deactivate_webjoint_sync');
