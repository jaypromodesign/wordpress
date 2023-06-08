<?php
class WebJoint_Sync_API {
    private $api_key;
    private $facility_id;
    private $api_url = 'https://app.webjoint.com/prod/api/';

    public function __construct($api_key, $facility_id) {
        $this->api_key = $api_key;
        $this->facility_id = $facility_id;
    }

    private function request($endpoint, $method = 'GET', $body = []) {
        $headers = [
            'x-api-key' => $this->api_key,
            'Content-Type' => 'application/json'
        ];

        $url = $this->api_url . $endpoint;
        if ($method === 'GET' && !empty($body)) {
            $url = add_query_arg($body, $url);
        }

        $response = ($method === 'GET') ? wp_remote_get($url, ['headers' => $headers]) : wp_remote_post($url, ['headers' => $headers, 'body' => json_encode($body)]);

        if (is_wp_error($response)) {
            return $response;
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    public function is_deliverable($address) {
        return $this->request('isDeliverable', 'POST', ['address' => $address]);
    }

    public function get_active_products($delivery_zones) {
        return $this->request('products/active', 'GET', ['delivery_zones' => $delivery_zones]);
    }

    public function add_to_cart($cart_id, $variant_id, $quantity) {
        return $this->request('addToCart', 'POST', ['cart_id' => $cart_id, 'variant_id' => $variant_id, 'quantity' => $quantity]);
    }

    public function create_cart($user_id) {
        return $this->request('createCart', 'POST', ['x-for-user-id' => $user_id]);
    }

    public function submit_order($cart_id) {
        return $this->request('submitOrder', 'POST', ['cart_id' => $cart_id]);
    }

    public function check_order_status($order_id) {
        return $this->request('checkOrderStatus', 'GET', ['order_id' => $order_id]);
    }
}
