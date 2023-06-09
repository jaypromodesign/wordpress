<?php
require_once plugin_dir_path( __FILE__ ) . 'class-webjoint-api.php';

class Webjoint_Sync {
    private $webjoint_api;

    public function __construct() {
        $this->webjoint_api = new Webjoint_API();
    }

    public function sync_products() {
        $webjoint_products = $this->webjoint_api->get('products/active');
        // Loop through each product and update it in WooCommerce
        foreach ($webjoint_products as $product) {
            // Code to sync product with WooCommerce
        }
    }

    public function sync_cart($cart_id) {
        $webjoint_cart = $this->webjoint_api->get('cart/' . $cart_id);
        // Code to sync cart with WooCommerce
    }
}
