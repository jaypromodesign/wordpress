<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Product_Handler {

    private $api_handler;

    public function __construct() {
        $this->api_handler = new WebJoint_API_Handler();
    }

    public function create_product($product_id) {
        $product = wc_get_product($product_id);

        if ($product) {
            $product_data = [
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => $product->get_price(),
                // Add any other product data you want to sync
            ];

            $this->api_handler->create_product($product_data);
        }
    }

    public function update_product($product_id) {
        $product = wc_get_product($product_id);

        if ($product) {
            $product_data = [
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => $product->get_price(),
                // Add any other product data you want to sync
            ];

            $this->api_handler->update_product($product_data);
        }
    }
}