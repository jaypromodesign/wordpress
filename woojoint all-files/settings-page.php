
<?php
// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="" method="post">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="webjoint_sync_api_key">API Key</label></th>
                <td>
                    <input name="webjoint_sync_api_key" type="text" id="webjoint_sync_api_key" value="<?php echo esc_attr($apiKey); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="webjoint_sync_facility_id">Facility ID</label></th>
                <td>
                    <input name="webjoint_sync_facility_id" type="text" id="webjoint_sync_facility_id" value="<?php echo esc_attr($facilityId); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="webjoint_sync_sync_interval">Sync Interval (in minutes)</label></th>
                <td>
                    <input name="webjoint_sync_sync_interval" type="number" id="webjoint_sync_sync_interval" value="<?php echo esc_attr($syncInterval); ?>" class="regular-text">
                </td>
            </tr>
        </table>

        <?php submit_button('Save Settings'); ?>
    </form>
</div>