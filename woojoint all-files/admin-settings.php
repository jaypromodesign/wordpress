<?php
// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');

// Add settings page
function webjoint_sync_add_settings_page() {
    add_options_page(
        'WebJoint Sync',
        'WebJoint Sync',
        'manage_options',
        'webjoint-sync',
        'webjoint_sync_render_settings_page'
    );
}
add_action('admin_menu', 'webjoint_sync_add_settings_page');

// Render settings page
function webjoint_sync_render_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['webjoint_sync_api_key']) && isset($_POST['webjoint_sync_facility_id']) && isset($_POST['webjoint_sync_sync_interval'])) {
        update_option('webjoint_sync_api_key', sanitize_text_field($_POST['webjoint_sync_api_key']));
        update_option('webjoint_sync_facility_id', sanitize_text_field($_POST['webjoint_sync_facility_id']));
        update_option('webjoint_sync_sync_interval', sanitize_text_field($_POST['webjoint_sync_sync_interval']));
        webjoint_sync_set_up_cron();
    }

    $apiKey = get_option('webjoint_sync_api_key', '');
    $facilityId = get_option('webjoint_sync_facility_id', '');
    $syncInterval = get_option('webjoint_sync_sync_interval', '');

    require_once(WEBJOINT_SYNC_PATH . 'includes/settings-page.php');
}

// Initialize settings
function webjoint_sync_initialize_settings() {
    add_option('webjoint_sync_api_key', '');
    add_option('webjoint_sync_facility_id', '');
    add_option('webjoint_sync_sync_interval', '');
}