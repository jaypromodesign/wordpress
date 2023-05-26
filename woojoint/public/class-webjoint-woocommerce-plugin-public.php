<?php
if (!defined('WPINC')) {
    die;
}

class Webjoint_Woocommerce_Plugin_Public
{
    private $plugin_name;
  private $version;
  private $shortcodes;
  private $api;

  public function __construct( $plugin_name, $version ) {
    $options = get_option($plugin_name);
    $api_key = isset($options['api_key']) ? $options['api_key'] : '';
    $facility_id = isset($options['facility_id']) ? $options['facility_id'] : '';
    $this->api = new Webjoint_API($api_key, $facility_id);
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/webjoint-woocommerce-plugin-public.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/webjoint-woocommerce-plugin-public.js', array('jquery'), $this->version, false);
    }

    public function sync_user_to_webjoint($user_id)
    {
        $user_info = get_userdata($user_id);

        // Call the WebJoint API to create/update the user in WebJoint
        $this->api->post('/customers', [
            'username' => $user_info->user_login,
            'email' => $user_info->user_email,
            // add any other necessary fields here
        ]);
    }

    public function sync_order_to_webjoint($order_id)
    {
        $order = wc_get_order($order_id);

        // Call the WebJoint API to create/update the order in WebJoint
        $this->api->post('/orders', [
            'id' => $order->get_id(),
            'total' => $order->get_total(),
            // add any other necessary fields here
        ]);
    }

    public function sync_cart_to_webjoint()
    {
        $cart = WC()->cart->get_cart();

        // Call the WebJoint API to update the cart in WebJoint
        $this->api->post('/carts', [
            'items' => array_map(function ($item) {
                return [
                    'id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ];
            }, array_values($cart)),
        ]);
    }
}

add_action('user_register', array('Webjoint_Woocommerce_Plugin_Public', 'sync_user_to_webjoint'));
add_action('profile_update', array('Webjoint_Woocommerce_Plugin_Public', 'sync_user_to_webjoint'));
add_action('woocommerce_new_order', array('Webjoint_Woocommerce_Plugin_Public', 'sync_order_to_webjoint'));
add_action('woocommerce_cart_updated', array('Webjoint_Woocommerce_Plugin_Public', 'sync_cart_to_webjoint'));