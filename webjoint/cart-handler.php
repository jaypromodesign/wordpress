<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Cart_Handler {

    private $api_handler;

    public function __construct() {
        $this->api_handler = new WebJoint_API_Handler();
    }

    public function sync_cart() {
        $cart = WC()->cart->get_cart();

        foreach ($cart as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];

            if ($product) {
                $product_data = [
                    'id' => $product->get_id(),
                    'name' => $product->get_name(),
                    'quantity' => $cart_item['quantity'],
                    // Add any other product data you want to sync
                ];

                $this->api_handler->push_product($product_data);
            }
        }
    }
}
