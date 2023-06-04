<?php
/**
 * Plugin Name: WebJoint Sync
 * Description: A plugin to sync data between WooCommerce and WebJoint.
 * Version: 1.0
 * Author: Your Name
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');

define('WEBJOINT_SYNC_PATH', plugin_dir_path(__FILE__));
define('WEBJOINT_SYNC_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once(WEBJOINT_SYNC_PATH . 'includes/admin-settings.php');
require_once(WEBJOINT_SYNC_PATH . 'includes/api-handler.php');
require_once(WEBJOINT_SYNC_PATH . 'includes/cron-handler.php');
require_once(WEBJOINT_SYNC_PATH . 'includes/error-handler.php');

// Enqueue admin JS
function webjoint_sync_enqueue_scripts() {
    wp_enqueue_script('webjoint-sync-admin', WEBJOINT_SYNC_URL . 'assets/js/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'webjoint_sync_enqueue_scripts');

// Activation and deactivation hooks
register_activation_hook(__FILE__, 'webjoint_sync_activation');
register_deactivation_hook(__FILE__, 'webjoint_sync_deactivation');

function webjoint_sync_activation() {
    // Initialize settings
    webjoint_sync_initialize_settings();

    // Set up initial cron job
    webjoint_sync_set_up_cron();
}

function webjoint_sync_deactivation() {
    // Clean up cron job
    webjoint_sync_clean_up_cron();
}
