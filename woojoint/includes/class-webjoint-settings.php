<?php
class WebJoint_Settings {
    public function __construct() {
        add_action('admin_menu', array($this, 'create_settings_page'));
        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
    }

    public function create_settings_page() {
        add_menu_page('WebJoint Settings', 'WebJoint Settings', 'manage_options', 'webjoint-settings', array($this, 'settings_page_markup'));
    }

    public function settings_page_markup() {
        ?>
        <div class="wrap">
            <h1>WebJoint Settings</h1>
            <form method="POST" action="options.php">
                <?php
                    settings_fields('webjoint_settings');
                    do_settings_sections('webjoint_settings');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function setup_sections() {
        add_settings_section('webjoint_api_section', 'API Settings', array($this, 'section_callback'), 'webjoint_settings');
    }

    public function section_callback($arguments) {
        echo 'Enter your WebJoint API details below:';
    }

    public function setup_fields() {
        $fields = array(
            array(
                'uid' => 'webjoint_api_key',
                'label' => 'API Key',
                'section' => 'webjoint_api_section',
                'type' => 'text',
            ),
            array(
                'uid' => 'webjoint_facility_id',
                'label' => 'Facility ID',
                'section' => 'webjoint_api_section',
                'type' => 'text',
            ),
            array(
                'uid' => 'webjoint_company_id',
                'label' => 'Company ID',
                'section' => 'webjoint_api_section',
                'type' => 'text',
            ),
        );

        foreach($fields as $field) {
            add_settings_field($field['uid'], $field['label'], array($this, 'field_callback'), 'webjoint_settings', $field['section'], $field);
            register_setting('webjoint_settings', $field['uid']);
        }
    }

    public function field_callback($arguments) {
        $value = get_option($arguments['uid']);
        printf('<input name="%s" id="%s" type="%s" value="%s" />', $arguments['uid'], $arguments['uid'], $arguments['type'], $value);
    }
}

new WebJoint_Settings();
