<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Cron_Handler {

    private $sync_interval;

    public function __construct() {
        $this->sync_interval = get_option('webjoint_sync_interval', 'hourly');
    }

    public function setup_cron() {
        if (!wp_next_scheduled('webjoint_sync_event')) {
            wp_schedule_event(time(), $this->sync_interval, 'webjoint_sync_event');
        }
    }

    public function remove_cron() {
        if (wp_next_scheduled('webjoint_sync_event')) {
            wp_clear_scheduled_hook('webjoint_sync_event');
        }
    }

    public function run_sync() {
        // Add your synchronization logic here
        // This function will be called at the interval specified in $this->sync_interval
    }
}

add_action('wp', array('WebJoint_Cron_Handler', 'setup_cron'));
add_action('webjoint_sync_event', array('WebJoint_Cron_Handler', 'run_sync'));
