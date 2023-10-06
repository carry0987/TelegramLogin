<?php
namespace carry0987\TelegramLogin;

class User
{
    private $botUsername;

    function __construct($botUsername)
    {
        $this->botUsername = $botUsername;
    }

    public function getUserData()
    {
        if (isset($_COOKIE['tg_user'])) {
            $auth_data_json = urldecode($_COOKIE['tg_user']);
            $auth_data = json_decode($auth_data_json, true);
            return $auth_data;
        }
        return false;
    }
}
