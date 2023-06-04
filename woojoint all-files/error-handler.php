<?php
// Prevent direct file access
defined('ABSPATH') or die('Direct script access denied.');

class WebJoint_Error_Handler {
    private $log_file;

    public function __construct() {
        // Define the path to the log file
        $upload_dir = wp_upload_dir();
        $this->log_file = $upload_dir['basedir'] . '/webjoint_errors.log';
    }

    public function log_error($message) {
        // If the log file doesn't exist, create it
        if (!file_exists($this->log_file)) {
            file_put_contents($this->log_file, '');
        }

        // Add a timestamp to the error message
        $message = date('Y-m-d H:i:s') . ' - ' . $message;

        // Write the error message to the log file
        file_put_contents($this->log_file, $message . PHP_EOL, FILE_APPEND);
    }
}
