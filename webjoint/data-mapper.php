<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Data_Mapper {

    public function map_product_data($product) {
        return array(
            'id' => $product->get_id(),
            'name' => $product->get_name(),
            'description' => $product->get_description(),
            'price' => $product->get_price(),
            // add more fields as needed
        );
    }

    public function map_user_data($user) {
        return array(
            'id' => $user->ID,
            'email' => $user->user_email,
            'username' => $user->user_login,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            // add more fields as needed
        );
    }

    public function map_order_data($order) {
        $mapped_order_data = array(
            'id' => $order->get_id(),
            'order_number' => $order->get_order_number(),
            'status' => $order->get_status(),
            'date_created' => $order->get_date_created()->date('Y-m-d H:i:s'),
            'total' => $order->get_total(),
            // add more fields as needed
        );

        $mapped_order_items = array();
        foreach ($order->get_items() as $item_id => $item) {
            $mapped_order_items[] = array(
                'product_id' => $item->get_product_id(),
                'quantity' => $item->get_quantity(),
                'subtotal' => $item->get_subtotal(),
                // add more fields as needed
            );
        }

        $mapped_order_data['items'] = $mapped_order_items;

        return $mapped_order_data;
    }
}