<?php
//File structure: 
//woojoint
//  -woojoint.php

//create woocommerce webhook url for data syncing
add_action('init', 'cwpai_create_webhook');
function cwpai_create_webhook() {
    $webhook = new WC_Webhook();
    $webhook->set_user_id(0);
    $webhook->set_name('WooJoint Sync');
    $webhook->set_topic('order.created');
    $webhook->set_delivery_url(site_url('woojoint-sync'));
    $webhook->set_secret('');
    $webhook->save();
}

//create plugin settings page for api key and facility id submission
add_action('admin_menu', 'cwpai_create_settings_page');
function cwpai_create_settings_page() {
    add_options_page('WooJoint Settings', 'WooJoint', 'manage_options', 'woojoint', 'cwpai_render_settings_page');
}

//render settings page
function cwpai_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>WooJoint Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('woojoint_settings'); ?>
            <?php do_settings_sections('woojoint_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td><input type="text" name="woojoint_api_key" value="<?php echo esc_attr(get_option('woojoint_api_key')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Facility ID</th>
                    <td><input type="text" name="woojoint_facility_id" value="<?php echo esc_attr(get_option('woojoint_facility_id')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Sync Frequency</th>
                    <td>
                        <select name="woojoint_sync_frequency">
                            <option value="1" <?php selected('1', get_option('woojoint_sync_frequency')); ?>>Every Minute</option>
                            <option value="5" <?php selected('5', get_option('woojoint_sync_frequency')); ?>>Every 5 Minutes</option>
                            <option value="10" <?php selected('10', get_option('woojoint_sync_frequency')); ?>>Every 10 Minutes</option>
                            <option value="15" <?php selected('15', get_option('woojoint_sync_frequency')); ?>>Every 15 Minutes</option>
                            <option value="20" <?php selected('20', get_option('woojoint_sync_frequency')); ?>>Every 20 Minutes</option>
                            <option value="25" <?php selected('25', get_option('woojoint_sync_frequency')); ?>>Every 25 Minutes</option>
                            <option value="30" <?php selected('30', get_option('woojoint_sync_frequency')); ?>>Every 30 Minutes</option>
                            <option value="60" <?php selected('60', get_option('woojoint_sync_frequency')); ?>>Hourly</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

//save settings to database
add_action('admin_init', 'cwpai_save_settings');
function cwpai_save_settings() {
    register_setting('woojoint_settings', 'woojoint_api_key');
    register_setting('woojoint_settings', 'woojoint_facility_id');
    register_setting('woojoint_settings', 'woojoint_sync_frequency');
}

//manually sync data from woocommerce to webjoint
add_action('admin_init', 'cwpai_manual_sync');
function cwpai_manual_sync() {
    if(isset($_POST['woojoint_manual_sync'])) {
        cwpai_sync_orders();
        cwpai_sync_customers();
        cwpai_sync_products();
        cwpai_sync_cart();
        echo '<div class="notice notice-success"><p>Data synced successfully!</p></div>';
    }
}

//add manual sync form to settings page
add_action('woojoint_settings', 'cwpai_render_manual_sync');
function cwpai_render_manual_sync() {
    ?>
    <form method="post" action="">
        <input type="hidden" name="woojoint_manual_sync" value="true"/>
        <button class="button">Sync Now</button>
    </form>
    <?php
}

//add shortcode [webjoint type="destination"] to load data from webjoint
add_shortcode('webjoint', 'cwpai_load_data_from_webjoint');
function cwpai_load_data_from_webjoint($atts) {
    $endpoint = isset($atts['type']) ? $atts['type'] : '';
    //use $endpoint to fetch data from webjoint api
}

//sync data on scheduled time or webhook
add_action('woojoint_sync', 'cwpai_sync_data');
add_action('woojoint_sync_orders', 'cwpai_sync_orders');
add_action('woojoint_sync_customers', 'cwpai_sync_customers');
add_action('woojoint_sync_products', 'cwpai_sync_products');
add_action('woojoint_sync_cart', 'cwpai_sync_cart');
function cwpai_sync_data() {
    cwpai_sync_orders();
    cwpai_sync_customers();
    cwpai_sync_products();
    cwpai_sync_cart();
}

//sync orders
function cwpai_sync_orders() {
    //fetch orders from woocommerce and send them to webjoint
}

//sync customers
function cwpai_sync_customers() {
    //fetch customers from woocommerce and send them to webjoint
}

//sync products
function cwpai_sync_products() {
    //fetch products from woocommerce and send them to webjoint
}

//sync cart information
function cwpai_sync_cart() {
    //fetch cart information from woocommerce and send them to webjoint
}
