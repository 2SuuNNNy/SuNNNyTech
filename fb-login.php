<?php
require_once 'vendor/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '2081588038993422',
    'app_secret' => '0b774368c3f4f5e56d7d4c094a8fe50a',
    'default_graph_version' => 'v18.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email'];
$loginUrl = $helper->getLoginUrl('http://localhost/sunnnytech/fb-callback.php', $permissions);

header('Location: ' . $loginUrl);
exit;
