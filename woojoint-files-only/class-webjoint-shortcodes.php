<?php

class Webjoint_Shortcodes {

    private $api;

    public function __construct(Webjoint_API $api) {
        $this->api = $api;
        $this->register_shortcodes();
    }

    public function register_shortcodes() {
        add_shortcode('webjoint', array($this, 'display_webjoint_data'));
    }

    public function display_webjoint_data($atts = [], $content = null) {
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $webjoint_atts = shortcode_atts(['endpoint' => ''], $atts);
        $endpoint = $webjoint_atts['endpoint'];

        if (!$endpoint) {
            return '';
        }

        $data = $this->api->get($endpoint);
        if (!$data) {
            return '';
        }

        // Format the data as needed for display
        $output = '<div>';
        foreach ($data as $key => $value) {
            $output .= '<p><strong>' . esc_html($key) . ':</strong> ' . esc_html($value) . '</p>';
        }
        $output .= '</div>';

        return $output;
    }

}