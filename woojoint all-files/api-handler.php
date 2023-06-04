<?php
// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');

class WebJoint_API_Handler {
    private $api_key;
    private $facility_id;
    private $api_url;

    public function __construct($api_key, $facility_id) {
        $this->api_key = $api_key;
        $this->facility_id = $facility_id;
        $this->api_url = "https://app.webjoint.com/prod/api/";
    }

    private function make_request($endpoint, $method = 'GET', $body = []) {
        $url = $this->api_url . $endpoint . "?facilityId=" . $this->facility_id;
        $args = array(
            'method' => $method,
            'headers' => array(
                'x-api-key' => $this->api_key,
                'Content-Type' => 'application/json'
            )
        );

        if (!empty($body)) {
            $args['body'] = json_encode($body);
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $body = wp_remote_retrieve_body($response);

        return json_decode($body, true);
    }

    // User related methods
    public function create_user($user_data) {
        return $this->make_request('/customers', 'POST', $user_data);
    }

    // Product related methods
    public function create_product($product_data) {
        return $this->make_request('/products', 'POST', $product_data);
    }

    // Order related methods
    public function create_order($order_data) {
        return $this->make_request('/orders', 'POST', $order_data);
    }

    // Cart related methods
    public function create_cart($cart_data) {
        return $this->make_request('/carts', 'POST', $cart_data);
    }

    public function update_cart($cart_id, $cart_data) {
        return $this->make_request("/carts/{$cart_id}", 'PUT', $cart_data);
    }
}
