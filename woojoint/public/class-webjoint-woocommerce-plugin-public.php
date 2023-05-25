<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

class Webjoint_Woocommerce_Plugin_Public {

    private $plugin_name;
    private $version;
    private $shortcodes;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->shortcodes = $shortcodes;
    }

    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/webjoint-woocommerce-plugin-public.css', array(), $this->version, 'all' );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/webjoint-woocommerce-plugin-public.js', array( 'jquery' ), $this->version, false );
    }

    public function sync_user_to_webjoint($user_id) {
        $user_info = get_userdata($user_id);
        // Here you would call the WebJoint API to create/update the user in WebJoint
    }

    public function sync_order_to_webjoint($order_id) {
        $order = wc_get_order($order_id);
        // Here you would call the WebJoint API to create/update the order in WebJoint
    }

    public function sync_cart_to_webjoint() {
        $cart = WC()->cart->get_cart();
        // Here you would call the WebJoint API to update the cart in WebJoint
    }
}

add_action('user_register', array('Webjoint_Woocommerce_Plugin_Public', 'sync_user_to_webjoint'));
add_action('profile_update', array('Webjoint_Woocommerce_Plugin_Public', 'sync_user_to_webjoint'));
add_action('woocommerce_new_order', array('Webjoint_Woocommerce_Plugin_Public', 'sync_order_to_webjoint'));
add_action('woocommerce_cart_updated', array('Webjoint_Woocommerce_Plugin_Public', 'sync_cart_to_webjoint'));
