<?php
class WebJoint_Sync_WooCommerce {
    public function __construct() {}

    public function get_products() {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );
        $loop = new WP_Query($args);
        $products = array();
        while ($loop->have_posts()) : $loop->the_post();
            global $product;
            array_push($products, $product);
        endwhile;
        wp_reset_query();
        return $products;
    }

    public function get_customers() {
        $users = get_users('role=customer');
        return $users;
    }

    public function get_cart($user_id) {
        $cart = get_user_meta($user_id, '_woocommerce_persistent_cart', true);
        return $cart;
    }
}
