<?php
require dirname(__FILE__).'/../src/Authorize.php';
require dirname(__FILE__).'/../src/User.php';

$tgUser = new carry0987\TelegramLogin\User();
$tgAuth = new carry0987\TelegramLogin\Authorize('XXXXX:XXXXXX');
$tgAuth->setBotUsername('example_bot');

if (isset($_GET['logout'])) {
    $tgUser->clearUserData();
    header('Location: login_example.php');
}

$tg_user = $tgUser->getUserData();
if ($tg_user !== false) {
    if (isset($tg_user['username'])) {
        $html = "<h1>Hello, <a href=\"https://t.me/{$tg_user['username']}\">{$tg_user['first_name']} {$tg_user['last_name']}</a>!</h1>";
    } else {
        $html = "<h1>Hello, {$tg_user['first_name']} {$tg_user['last_name']}!</h1>";
    }
    if (isset($tg_user['photo_url'])) {
        $html .= "<img src=\"{$tg_user['photo_url']}\">";
    }
    $html .= "<p><a href=\"?logout=1\">Log out</a></p>";
} else {
    $bot_username = $tgAuth->getBotUsername();
    $html = <<<HTML
<h1>Hello, anonymous!</h1>
<script async src="https://telegram.org/js/telegram-widget.js?2" data-telegram-login="{$bot_username}" data-size="large" data-auth-url="https://example.com/check_authorization.php"></script>
HTML;
}

echo <<<HTML
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login Widget Example</title>
    </head>
    <body><center>{$html}</center></body>
</html>
HTML;
