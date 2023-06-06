<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Create custom plugin settings menu
add_action('admin_menu', 'webjoint_sync_create_menu');

function webjoint_sync_create_menu() {
    // Create new top-level menu
    add_menu_page('WebJoint Sync Settings', 'WebJoint Sync', 'administrator', __FILE__, 'webjoint_sync_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    // Call register settings function
    add_action('admin_init', 'register_webjoint_sync_settings');
}

function register_webjoint_sync_settings() {
    // Register settings with validation callbacks
    register_setting('webjoint-sync-settings-group', 'api_key', 'validate_api_key');
    register_setting('webjoint-sync-settings-group', 'facility_id', 'validate_facility_id');
    register_setting('webjoint-sync-settings-group', 'sync_interval', 'validate_sync_interval');
}

// Validation functions
function validate_api_key($input) {
    // Replace this with your actual API key validation logic
    if (/* validation fails */) {
        add_settings_error('api_key', 'api_key_error', 'Invalid API Key');
        return get_option('api_key');
    }
    return $input;
}

function validate_facility_id($input) {
    // Replace this with your actual Facility ID validation logic
    if (/* validation fails */) {
        add_settings_error('facility_id', 'facility_id_error', 'Invalid Facility ID');
        return get_option('facility_id');
    }
    return $input;
}

function validate_sync_interval($input) {
    $allowed_values = array('60', '300', '600', '900', '1200', '1500', '1800', '3600');
    if (!in_array($input, $allowed_values)) {
        add_settings_error('sync_interval', 'sync_interval_error', 'Invalid Sync Interval');
        return get_option('sync_interval');
    }
    return $input;
}

function webjoint_sync_settings_page() {
?>
<div class="wrap">
<h1>WebJoint Sync</h1>

<form method="post" action="options.php">
    <?php settings_fields('webjoint-sync-settings-group'); ?>
    <?php do_settings_sections('webjoint-sync-settings-group'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">API Key</th>
        <td><input type="text" name="api_key" value="<?php echo esc_attr(get_option('api_key')); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Facility ID</th>
        <td><input type="text" name="facility_id" value="<?php echo esc_attr(get_option('facility_id')); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Sync Interval</th>
        <td>
            <select name="sync_interval">
                <option value="60" <?php selected(get_option('sync_interval'), '60'); ?>>Every Minute</option>
                <option value="300" <?php selected(get_option('sync_interval'), '300'); ?>>Every 5 Minutes</option>
                <option value="600" <?php selected(get_option('sync_interval'), '600'); ?>>Every 10 Minutes</option>
                <option value="900" <?php selected(get_option('sync_interval'), '900'); ?>>Every 15 Minutes</option>
		<option value="1200" <?php selected(get_option('sync_interval'), '1200'); ?>>Every 20 Minutes</option>
                <option value="1500" <?php selected(get_option('sync_interval'), '1500'); ?>>Every 25 Minutes</option>
                <option value="1800" <?php selected(get_option('sync_interval'), '1800'); ?>>Every 30 Minutes</option>
                <option value="3600" <?php selected(get_option('sync_interval'), '3600'); ?>>Every Hour</option>
            </select>
        </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>
    <input name="webjoint_sync_now" type="submit" class="button-primary" value="Sync Now">
</form>
</div>
<?php
}

// Handle "Sync Now" button press
add_action('admin_init', 'webjoint_sync_now');

function webjoint_sync_now() {
    if(isset($_POST['webjoint_sync_now'])) {
        // Call your function that triggers immediate sync here.
        // This is just a placeholder. Please replace it with your actual sync function.
        $result = do_immediate_sync();
        if ($result === true) {
            add_action('admin_notices', 'sync_now_success_notice');
        } else {
            add_action('admin_notices', 'sync_now_error_notice');
        }
    }
}

function do_immediate_sync() {
    // Replace this function with your actual immediate sync function
    // This is a placeholder
    return true;
}

// Admin notices for "Sync Now"
function sync_now_success_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e('Data sync completed successfully!', 'sample-text-domain'); ?></p>
    </div>
    <?php
}

function sync_now_error_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e('Data sync failed. Please try again.', 'sample-text-domain'); ?></p>
    </div>
    <?php
}
?>
