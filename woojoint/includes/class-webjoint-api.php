<?php

class Webjoint_API {

    private $api_key;
    private $facility_id;
    private $base_url = 'https://app.webjoint.com/prod/api/';

    public function __construct($api_key, $facility_id) {
        $this->api_key = $api_key;
        $this->facility_id = $facility_id;
    }

    public function get($endpoint) {
        return $this->request('GET', $endpoint);
    }

    public function post($endpoint, $body = array()) {
        return $this->request('POST', $endpoint, $body);
    }

    public function delete($endpoint) {
        return $this->request('DELETE', $endpoint);
    }

    private function request($method, $endpoint, $body = array()) {
        $url = $this->base_url . $endpoint;

        $args = array(
            'method' => $method,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'FacilityID' => $this->facility_id
            )
        );

        if (!empty($body)) {
            $args['body'] = $body;
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}