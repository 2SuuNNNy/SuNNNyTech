<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('795164327909-4r0pv95j9ckcceggl9kub1k96fhq0bot.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/sunnnytech/google-callback.php');
$client->addScope('email');
$client->addScope('profile');

$login_url = $client->createAuthUrl();
header('Location: ' . $login_url);
