<?php
/*
Plugin Name: WebJoint Sync
Description: This plugin synchronizes data with the WebJoint API
Version: 1.0
Author: Your Name
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin paths for easy access
define('WEBJOINT_SYNC_PATH', plugin_dir_path(__FILE__));
define('WEBJOINT_SYNC_INC_PATH', WEBJOINT_SYNC_PATH . 'includes/');

// Load all the necessary files
require_once(WEBJOINT_SYNC_INC_PATH . 'admin-settings.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'api-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'cron-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'error-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'order-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'user-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'cart-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'product-handler.php');
require_once(WEBJOINT_SYNC_INC_PATH . 'data-mapper.php');

// Initialize our plugin
function webjoint_sync_init() {
    // Setting up custom intervals for wp-cron
    add_filter('cron_schedules', 'webjoint_sync_cron_intervals');
}

// This function adds custom intervals to wp-cron
function webjoint_sync_cron_intervals($schedules) {
    $schedules['every_minute'] = array(
            'interval' => 60,
            'display'  => __('Every Minute'),
        );
        $schedules['every_five_minutes'] = array(
            'interval' => 300,
            'display'  => __('Every 5 Minutes'),
        );
        $schedules['every_ten_minutes'] = array(
            'interval' => 600,
            'display'  => __('Every 10 Minutes'),
        );
        $schedules['every_fifteen_minutes'] = array(
            'interval' => 900,
            'display'  => __('Every 15 Minutes'),
        );
        $schedules['every_twenty_minutes'] = array(
            'interval' => 1200,
            'display'  => __('Every 20 Minutes'),
        );
        $schedules['every_twenty_five_minutes'] = array(
            'interval' => 1500,
            'display'  => __('Every 25 Minutes'),
        );
        $schedules['every_half_hour'] = array(
            'interval' => 1800,
            'display'  => __('Every 30 Minutes'),
        );
	$schedules['every_hour'] = array(
            'interval' => 3600,
            'display'  => __('Every 1 Hour'),
        );

    return $schedules;
}

// Hook our function into the init action
add_action('init', 'webjoint_sync_init');

// Plugin activation
function webjoint_sync_activate() {
    // Schedule synchronization
    webjoint_sync_schedule_event();
}
register_activation_hook(__FILE__, 'webjoint_sync_activate');

// Plugin deactivation
function webjoint_sync_deactivate() {
    // Unschedule synchronization
    webjoint_sync_unschedule_event();
}
register_deactivation_hook(__FILE__, 'webjoint_sync_deactivate');

?>