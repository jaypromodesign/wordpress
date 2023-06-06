<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_Error_Handler {

    private $log_file_path;

    public function __construct() {
        $upload_dir = wp_upload_dir();
        $this->log_file_path = $upload_dir['basedir'] . '/webjoint_errors.log';
    }

    public function log_error($message) {
        $date = new DateTime();
        $log_message = $date->format('Y-m-d H:i:s') . ' - ' . $message . "\n";
        file_put_contents($this->log_file_path, $log_message, FILE_APPEND);
    }

    public function display_errors() {
        $errors = '';

        if (file_exists($this->log_file_path)) {
            $errors = file_get_contents($this->log_file_path);
        }

        if ($errors) {
            echo '<div class="error">';
            echo '<p><strong>WebJoint Errors:</strong></p>';
            echo '<p>' . nl2br($errors) . '</p>';
            echo '</div>';
        }
    }
}

function webjoint_admin_notices() {
    $error_handler = new WebJoint_Error_Handler();
    $error_handler->display_errors();
}
add_action('admin_notices', 'webjoint_admin_notices');
