<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_API_Handler {

    private $api_key;
    private $facility_id;
    private $api_url;

    public function __construct() {
        $this->api_key = get_option('api_key');
        $this->facility_id = get_option('facility_id');
        $this->api_url = 'https://app.webjoint.com/prod/api/'; // Replace with actual API URL
    }

    private function send_request($endpoint, $method, $data = []) {
        $url = $this->api_url . $endpoint;
        $args = [
            'method' => $method,
            'headers' => [
                'x-api-key' => $this->api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($data),
        ];

        $response = wp_remote_request($url, $args);
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = json_decode(wp_remote_retrieve_body($response), true);

        if ($response_code >= 400) {
            // Handle error. You may want to throw an exception or return an error value
        }

        return $response_body;
    }

    public function create_user($user_data) {
        $endpoint = 'users'; // Replace with actual endpoint
        $method = 'POST';

        return $this->send_request($endpoint, $method, $user_data);
    }

    public function update_user($user_id, $user_data) {
        $endpoint = 'users/' . $user_id; // Replace with actual endpoint
        $method = 'PUT';

        return $this->send_request($endpoint, $method, $user_data);
    }

    public function create_order($order_data) {
        $endpoint = 'orders'; // Replace with actual endpoint
        $method = 'POST';

        return $this->send_request($endpoint, $method, $order_data);
    }

    public function push_cart($cart_data) {
        $endpoint = 'carts'; // Replace with actual endpoint
        $method = 'POST';

        return $this->send_request($endpoint, $method, $cart_data);
    }

    public function push_product($product_data) {
        $endpoint = 'products'; // Replace with actual endpoint
        $method = 'POST';

        return $this->send_request($endpoint, $method, $product_data);
    }
}
