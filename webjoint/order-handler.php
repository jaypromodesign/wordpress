<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Order_Handler {

    private $api_handler;

    public function __construct() {
        $this->api_handler = new WebJoint_API_Handler();
    }

    public function create_order($order_id) {
        $order = wc_get_order($order_id);

        if ($order) {
            $order_data = [
                'id' => $order->get_id(),
                'status' => $order->get_status(),
                'total' => $order->get_total(),
                // Add any other order data you want to sync
            ];

            $this->api_handler->create_order($order_data);
        }
    }

    public function update_order($order_id) {
        $order = wc_get_order($order_id);

        if ($order) {
            $order_data = [
                'id' => $order->get_id(),
                'status' => $order->get_status(),
                'total' => $order->get_total(),
                // Add any other order data you want to sync
            ];

            $this->api_handler->update_order($order_data);
        }
    }
}
