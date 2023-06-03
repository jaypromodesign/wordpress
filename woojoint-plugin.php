<?php
/*
Plugin Name: Woojoint
Description: Connects WooCommerce to Webjoint using the Webjoint API
Version: 1.0
Author: Your Name Here
*/

// Setup Webjoint API endpoint URL
define( 'WEBJOINT_API_URL', 'https://app.webjoint.com/prod/api/' );

// Add settings page to WordPress admin menu
function cwpai_woojoint_add_settings_menu() {
    add_options_page( 'Woojoint Settings', 'Woojoint', 'manage_options', 'woojoint-settings', 'cwpai_woojoint_settings_page' );
}
add_action( 'admin_menu', 'cwpai_woojoint_add_settings_menu' );

// Build the HTML for the settings page
function cwpai_woojoint_settings_page() {
    // Check if user is allowed to manage options
    if( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    }

    // Save settings if form has been submitted
    if( isset( $_POST['woojoint_api_key'] ) ) {

        // Sanitize inputs and save to options
        update_option( 'woojoint_api_key', sanitize_text_field( $_POST['woojoint_api_key'] ) );
        update_option( 'woojoint_facility_id', sanitize_text_field( $_POST['woojoint_facility_id'] ) );
        update_option( 'woojoint_sync_interval', intval( $_POST['woojoint_sync_interval'] ) );

        // Schedule the sync job based on the selected interval
        $sync_interval = intval( $_POST['woojoint_sync_interval'] );
        if( $sync_interval > 0 ) {
            wp_schedule_event( time(), 'woojoint_sync', 'cwpai_woojoint_sync_data' );
        }
    }

    // Load saved options
    $api_key = get_option( 'woojoint_api_key', '' );
    $facility_id = get_option( 'woojoint_facility_id', '' );
    $sync_interval = get_option( 'woojoint_sync_interval', 0 );

    // Render the settings page
    ?>
    <div class="wrap">
        <h1>Woojoint settings</h1>
        <form method="post">
            <table class="form-table">
                <tbody>

                    <!-- Facility ID input -->
                    <tr>
                        <th scope="row">
                            <label for="woojoint_facility_id">Facility ID</label>
                        </th>
                        <td>
                            <input id="woojoint_facility_id" type="text" name="woojoint_facility_id" value="<?php echo esc_attr( $facility_id ); ?>" required>
                        </td>
                    </tr>

                    <!-- API Key input -->
                    <tr>
                        <th scope="row">
                            <label for="woojoint_api_key">API Key</label>
                        </th>
                        <td>
                            <input id="woojoint_api_key" type="text" name="woojoint_api_key" value="<?php echo esc_attr( $api_key ); ?>" required>
                        </td>
                    </tr>

                    <!-- Sync interval input -->
                    <tr>
                        <th scope="row">
                            <label for="woojoint_sync_interval">Sync Interval</label>
                        </th>
                        <td>
                            <select id="woojoint_sync_interval" name="woojoint_sync_interval" required>
                                <option value="0" <?php selected( $sync_interval, 0 ); ?>>Never</option>
                                <option value="60" <?php selected( $sync_interval, 60 ); ?>>Every Minute</option>
                                <option value="300" <?php selected( $sync_interval, 300 ); ?>>Every 5 minutes</option>
                                <option value="600" <?php selected( $sync_interval, 600 ); ?>>Every 10 minutes</option>
                                <option value="900" <?php selected( $sync_interval, 900 ); ?>>Every 15 minutes</option>
                                <option value="1200" <?php selected( $sync_interval, 1200 ); ?>>Every 20 minutes</option>
                                <option value="1500" <?php selected( $sync_interval, 1500 ); ?>>Every 25 minutes</option>
                                <option value="1800" <?php selected( $sync_interval, 1800 ); ?>>Every 30 minutes</option>
                                <option value="3600" <?php selected( $sync_interval, 3600 ); ?>>Hourly</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>
            <p><button class="button button-primary" type="submit">Save</button></p>
        </form>

        <!-- Manual sync button -->
        <form method="post">
            <input type="hidden" name="woojoint_sync_now" value="true">
            <p><button class="button" type="submit">Sync Now</button></p>
        </form>
    </div>
    <?php
}

// Schedule data sync job based on selected interval
function cwpai_woojoint_schedule_sync() {
    // Load sync interval from options
    $sync_interval = get_option( 'woojoint_sync_interval', 0 );

    // Only schedule job if interval is defined
    if( $sync_interval > 0 ) {
        $frequency = "woojoint_sync";
        wp_schedule_event( time(), $frequency, 'cwpai_woojoint_sync_data' );
    }

}
add_action( 'init', 'cwpai_woojoint_schedule_sync' );

// Setup data sync cron job
function cwpai_woojoint_sync_data() {
    // Get API Key and Facility ID from options
    $api_key = get_option( 'woojoint_api_key', '' );
    $facility_id = get_option( 'woojoint_facility_id', '' );

    // Sync customers
    // TODO: Implement

    // Sync products
    // TODO: Implement

    // Sync orders
    // TODO: Implement

    // Sync cart information
    // TODO: Implement
}

// Register shortcode for fetching data from Webjoint
function cwpai_woojoint_shortcode( $atts ) {
    // Get API Key and Facility ID from options
    $api_key = get_option( 'woojoint_api_key', '' );
    $facility_id = get_option( 'woojoint_facility_id', '' );

    // Default output
    $output = '<p>No data found.</p>';

    // Check if an endpoint type was specified
    if( isset( $atts['type'] ) ) {
        $endpoint = $atts['type'];
        // TODO: Implement fetching data from specified endpoint
    }

    return $output;
}
add_shortcode( 'webjoint', 'cwpai_woojoint_shortcode' ); 

// Setup sync cron schedule
function cwpai_woojoint_sync_cron_interval( $schedules ) {
    $schedules['woojoint_sync'] = array(
        'interval' => 60,
        'display' => 'Woojoint Data Sync',
    );
    return $schedules;
}
add_filter('cron_schedules', 'cwpai_woojoint_sync_cron_interval');

?>
