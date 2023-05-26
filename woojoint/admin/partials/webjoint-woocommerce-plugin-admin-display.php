<?php

$options = get_option('webjoint_woocommerce_plugin');

?>

<div class="wrap">
    <h2>Webjoint WooCommerce Plugin</h2>
    <form method="post" action="options.php">
        <?php
            settings_fields('webjoint_woocommerce_plugin');
            do_settings_sections('webjoint_woocommerce_plugin');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">API Key:</th>
                <td>
                    <input type="text" id="api_key" name="webjoint_woocommerce_plugin[api_key]" value="<?php echo esc_attr($options['api_key']); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Facility ID:</th>
                <td>
                    <input type="text" id="facility_id" name="webjoint_woocommerce_plugin[facility_id]" value="<?php echo esc_attr($options['facility_id']); ?>" />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
