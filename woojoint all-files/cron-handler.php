<?php
// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');

class WebJoint_Cron_Handler {
    private $api_handler;

    public function __construct($api_handler) {
        $this->api_handler = $api_handler;
        add_action('init', array($this, 'schedule_crons'));
        add_action('webjoint_daily_sync', array($this, 'daily_sync'));
    }

    public function schedule_crons() {
        if (!wp_next_scheduled('webjoint_daily_sync')) {
            wp_schedule_event(time(), 'daily', 'webjoint_daily_sync');
        }
    }

    public function daily_sync() {
        // Load necessary data from WooCommerce
        $users = $this->get_wc_users();
        $products = $this->get_wc_products();
        $orders = $this->get_wc_orders();

        // Sync to Webjoint
        foreach ($users as $user) {
            $this->api_handler->create_user($user);
        }

        foreach ($products as $product) {
            $this->api_handler->create_product($product);
        }

        foreach ($orders as $order) {
            $this->api_handler->create_order($order);
        }
    }

    private function get_wc_users() {
        $customers = get_users(array('role' => 'customer'));
        return $customers;
    }

    private function get_wc_products() {
        $args = array(
            'status' => 'publish',
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $products = wc_get_products($args);
        return $products;
    }

    private function get_wc_orders() {
        $args = array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $orders = wc_get_orders($args);
        return $orders;
    }
}
