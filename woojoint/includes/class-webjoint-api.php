<?php
class WebJoint_API {
    private $api_key;
    private $facility_id;
    private $base_url;

    public function __construct() {
        $this->api_key = get_option('webjoint_api_key');
        $this->facility_id = get_option('webjoint_facility_id');
        $this->base_url = 'https://app.webjoint.com/prod/api/';
    }

    private function make_request($method, $endpoint, $data = array()) {
        $url = $this->base_url . $endpoint . '?facilityId=' . $this->facility_id;
        $args = array(
            'method' => $method,
            'headers' => array(
                'x-api-key' => $this->api_key,
            ),
        );

        if ($method == 'GET') {
            $url = add_query_arg($data, $url);
        } else {
            $args['body'] = json_encode($data);
            $args['headers']['Content-Type'] = 'application/json';
        }

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        return json_decode(wp_remote_retrieve_body($response));
    }

    public function get($endpoint, $data = array()) {
        return $this->make_request('GET', $endpoint, $data);
    }

    public function post($endpoint, $data = array()) {
        return $this->make_request('POST', $endpoint, $data);
    }

    public function put($endpoint, $data = array()) {
        return $this->make_request('PUT', $endpoint, $data);
    }

    public function delete($endpoint, $data = array()) {
        return $this->make_request('DELETE', $endpoint, $data);
    }
}

