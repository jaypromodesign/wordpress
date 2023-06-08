<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WebJoint_Settings {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page(
            'WebJoint Settings',
            'WebJoint',
            'manage_options',
            'webjoint-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting('webjoint-settings', 'webjoint_api_key');
        register_setting('webjoint-settings', 'webjoint_facility_id');
        register_setting('webjoint-settings', 'webjoint_base_url');
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>WebJoint Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('webjoint-settings'); ?>
                <?php do_settings_sections('webjoint-settings'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">API Key</th>
                        <td><input type="text" name="webjoint_api_key" value="<?php echo esc_attr(get_option('webjoint_api_key')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Facility ID</th>
                        <td><input type="text" name="webjoint_facility_id" value="<?php echo esc_attr(get_option('webjoint_facility_id')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Base URL</th>
                        <td><input type="text" name="webjoint_base_url" value="<?php echo esc_attr(get_option('webjoint_base_url')); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

new WebJoint_Settings();
