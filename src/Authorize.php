<?php
namespace carry0987\TelegramLogin;

class Authorize
{
    private $botToken;
    private $botUsername;

    function __construct($botToken)
    {
        $this->botToken = $botToken;
    }

    public function setBotUsername($botUsername)
    {
        $this->botUsername = $botUsername;
    }

    public function getBotUsername()
    {
        return $this->botUsername;
    }

    public function checkAuthorization($auth_data)
    {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', $this->botToken, true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        if (strcmp($hash, $check_hash) !== 0) {
            throw new \Exception('Data is NOT from Telegram');
        }
        if ((time() - $auth_data['auth_date']) > 86400) {
            throw new \Exception('Data is outdated');
        }
        return $auth_data;
    }

    public function saveUserData($auth_data)
    {
        $auth_data_json = json_encode($auth_data);
        setcookie('tg_user', $auth_data_json);
    }

    public function clearUserData()
    {
        setcookie('tg_user', '');
    }
}
