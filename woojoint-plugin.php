<?php
// Plugin Name: Woojoint

// Define plugin directory path and uri
define( 'WJ_DIRECTORY_PATH', plugin_dir_path( __FILE__ ) );
define( 'WJ_DIRECTORY_URI', plugin_dir_url( __FILE__ ) );

// Add plugin scripts
function cwpai_add_plugin_scripts() {
    // Add JS script
    wp_enqueue_script( 'woojoint-js', WJ_DIRECTORY_URI . 'js/woojoint.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'cwpai_add_plugin_scripts' );

// Add plugin settings page
function cwpai_add_plugin_settings_page() {
    add_menu_page(
        'Woojoint Settings',
        'Woojoint',
        'manage_options',
        'woojoint-settings',
        'cwpai_render_settings_page'
    );
}
add_action( 'admin_menu', 'cwpai_add_plugin_settings_page' );

// Render plugin settings page
function cwpai_render_settings_page() {
    ?>
    <div class="wrap">
        <h2>Woojoint Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'woojoint-settings-group' ); ?>
            <?php do_settings_sections( 'woojoint-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API Key</th>
                    <td><input type="text" name="woojoint_api_key" value="<?php echo esc_attr( get_option( 'woojoint_api_key' ) ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Facility ID</th>
                    <td><input type="text" name="woojoint_facility_id" value="<?php echo esc_attr( get_option( 'woojoint_facility_id' ) ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Sync Frequency</th>
                    <td>
                        <select name="woojoint_sync_frequency">
                            <option value="1">Every minute</option>
                            <option value="5">Every 5 minutes</option>
                            <option value="10">Every 10 minutes</option>
                            <option value="15">Every 15 minutes</option>
                            <option value="20">Every 20 minutes</option>
                            <option value="25">Every 25 minutes</option>
                            <option value="30">Every 30 minutes</option>
                            <option value="60">Hourly</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
            <input type="hidden" name="action" value="woojoint_sync_data" />
            <?php wp_nonce_field( 'woojoint_sync_data_nonce', 'security' ); ?>
            <p><input type="submit" value="Sync Now" class="button button-primary"/></p>
        </form>
    </div>
    <?php
}

// Register plugin settings
function cwpai_register_plugin_settings() {
    register_setting( 'woojoint-settings-group', 'woojoint_api_key' );
    register_setting( 'woojoint-settings-group', 'woojoint_facility_id' );
    register_setting( 'woojoint-settings-group', 'woojoint_sync_frequency' );
}
add_action( 'admin_init', 'cwpai_register_plugin_settings' );

// Sync data with WebJoint every X minutes
function cwpai_sync_data_interval() {
    // Get WebJoint API Key and Facility ID from options
    $api_key = get_option( 'woojoint_api_key' );
    $facility_id = get_option( 'woojoint_facility_id' );
    
    // Check if API Key and Facility ID are set
    if ( $api_key && $facility_id ) {
        // Sync Customers/Users
        cwpai_sync_customers_users( $api_key, $facility_id );
        // Sync Products
        cwpai_sync_products( $api_key, $facility_id );
        // Sync Orders
        cwpai_sync_orders( $api_key, $facility_id );
        // Sync Cart Information
        cwpai_sync_cart_information( $api_key, $facility_id );
    }
}
// Schedule cron job to sync data with WebJoint
$sync_frequency = get_option( 'woojoint_sync_frequency' );
if ( $sync_frequency ) {
    $sync_frequency_in_seconds = $sync_frequency * 60;
    wp_schedule_event( time(), $sync_frequency_in_seconds, 'cwpai_sync_data_interval' );
}

// Sync data with WebJoint manually
function cwpai_sync_data_manual() {
    // Check if nonce is set
    if ( isset( $_REQUEST['security'] ) && wp_verify_nonce( $_REQUEST['security'], 'woojoint_sync_data_nonce' ) ) {
        // Get WebJoint API Key and Facility ID from options
        $api_key = get_option( 'woojoint_api_key' );
        $facility_id = get_option( 'woojoint_facility_id' );
    
        // Check if API Key and Facility ID are set
        if ( $api_key && $facility_id ) {
            // Sync Customers/Users
            cwpai_sync_customers_users( $api_key, $facility_id );
            // Sync Products
            cwpai_sync_products( $api_key, $facility_id );
            // Sync Orders
            cwpai_sync_orders( $api_key, $facility_id );
            // Sync Cart Information
            cwpai_sync_cart_information( $api_key, $facility_id );
        }
    }
}
add_action( 'wp_ajax_woojoint_sync_data', 'cwpai_sync_data_manual' );

// Sync Customers/Users
function cwpai_sync_customers_users( $api_key, $facility_id ) {
    // TODO: Add logic to sync customers/users with WebJoint API
}
// Sync Products
function cwpai_sync_products( $api_key, $facility_id ) {
    // TODO: Add logic to sync products with WebJoint API
}
// Sync Orders
function cwpai_sync_orders( $api_key, $facility_id ) {
    // TODO: Add logic to sync orders with WebJoint API
}
// Sync Cart Information
function cwpai_sync_cart_information( $api_key, $facility_id ) {
    // TODO: Add logic to sync cart information with WebJoint API
}

// Add shortcode [webjoint]
function cwpai_webjoint_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'type' => 'products',
        'other_parameter' => ''
    ), $atts );
    
    // TODO: Add logic to retrieve data from WebJoint API based on shortcode parameters
}
add_shortcode( 'webjoint', 'cwpai_webjoint_shortcode' );
