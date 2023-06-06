<?php

if (!defined('WPINC')) {
    die;
}

class WebJoint_User_Handler {

    private $api_handler;

    public function __construct() {
        $this->api_handler = new WebJoint_API_Handler();
    }

    public function create_user($user_id) {
        $user = get_userdata($user_id);

        if ($user) {
            $user_data = [
                'id' => $user->ID,
                'username' => $user->user_login,
                'email' => $user->user_email,
                // Add any other user data you want to sync
            ];

            $this->api_handler->create_user($user_data);
        }
    }

    public function update_user($user_id) {
        $user = get_userdata($user_id);

        if ($user) {
            $user_data = [
                'id' => $user->ID,
                'username' => $user->user_login,
                'email' => $user->user_email,
                // Add any other user data you want to sync
            ];

            $this->api_handler->update_user($user_data);
        }
    }
}
