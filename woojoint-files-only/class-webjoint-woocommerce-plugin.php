<?php

require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-webjoint-api.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-webjoint-shortcodes.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-webjoint-woocommerce-plugin-admin.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-webjoint-woocommerce-plugin-public.php';

class Webjoint_WooCommerce_Plugin {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = WEBJOINT_WOOCOMMERCE_PLUGIN_NAME;
        $this->version = WEBJOINT_WOOCOMMERCE_PLUGIN_VERSION;
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies() {
    $options = get_option($this->plugin_name);
    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
    $facility_id = isset($options['facility_id']) ? $options['facility_id'] : '';
    $this->loader = new Webjoint_API($api_key, $facility_id);
}

    private function define_admin_hooks() {
        $plugin_admin = new Webjoint_WooCommerce_Plugin_Admin($this->plugin_name, $this->version);
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_scripts'));
        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
        add_action('admin_init', array($plugin_admin, 'options_update'));
    }

    public function run() {
        $plugin_public = new Webjoint_WooCommerce_Plugin_Public($this->plugin_name, $this->version);
        $plugin_shortcode = new Webjoint_Shortcodes($this->loader);
    }

}