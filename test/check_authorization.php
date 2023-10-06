<?php
require dirname(__FILE__).'/../src/Authorize.php';
require dirname(__FILE__).'/../src/User.php';

use carry0987\TelegramLogin as TelegramLogin;

$tg_login = new TelegramLogin\Authorize('XXXXX:XXXXXX');

try {
    $auth_data = $tg_login->checkAuthorization($_GET);
    $tg_user = new TelegramLogin\User();
    $tg_user->saveUserData($auth_data);
} catch (Exception $e) {
    die ($e->getMessage());
}

header('Location: login_example.php');
