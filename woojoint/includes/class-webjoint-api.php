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
        $url = $this->base_url . $endpoint;
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'FacilityID' => $this->facility_id
            )
        );
        $response = wp_remote_get($url, $args);
        if (is_wp_error($response)) {
            return false;
        }
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    // Add similar methods for POST, PUT, DELETE requests if needed
}