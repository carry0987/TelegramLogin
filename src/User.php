<?php
namespace carry0987\TelegramLogin;

class User
{
    public function __construct()
    {
    }

    private function checkUserData()
    {
        if (isset($_COOKIE['tg_user'])) {
            $auth_data_json = urldecode($_COOKIE['tg_user']);
            $auth_data = json_decode($auth_data_json, true);
            return $auth_data;
        }
        return false;
    }

    public function getUserData(bool $convert_html_chars = true)
    {
        $result = array();
        $tg_user = $this->checkUserData();
        if ($tg_user !== false) {
            $result['first_name'] = $convert_html_chars ? htmlspecialchars($tg_user['first_name']) : $tg_user['first_name'];
            $result['last_name'] = $convert_html_chars ? htmlspecialchars($tg_user['last_name']) : $tg_user['last_name'];
            if (isset($tg_user['username'])) {
                $result['username'] = $convert_html_chars ? htmlspecialchars($tg_user['username']) : $tg_user['username'];
            }
            if (isset($tg_user['photo_url'])) {
                $result['photo_url'] = $convert_html_chars ? htmlspecialchars($tg_user['photo_url']) : $tg_user['photo_url'];
            }
        }

        return count($result) > 0 ? $result : false;
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
