<?php

class Webjoint_WooCommerce_Plugin_Admin {

    private $plugin_name;
    private $version;
    private $option_name = 'webjoint_woocommerce_plugin';

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/webjoint-woocommerce-plugin-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/webjoint-woocommerce-plugin-admin.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_admin_menu() {
        add_options_page('Webjoint WooCommerce Plugin', 'Webjoint WooCommerce', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
    }

    public function display_plugin_setup_page() {
        include_once('partials/webjoint-woocommerce-plugin-admin-display.php');
    }

    public function options_update() {
        register_setting($this->plugin_name, $this->option_name, array($this, 'validate'));
    }

    public function validate($input) {
        $valid = array();
        $valid['api_key'] = sanitize_text_field($input['api_key']);
        $valid['facility_id'] = sanitize_text_field($input['facility_id']);
        return $valid;
    }

}