<?php
// If uninstall is not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

// Remove options added by the plugin
delete_option( 'webjoint_api_key' );
delete_option( 'webjoint_facility_id' );
delete_option( 'webjoint_company_id' );
