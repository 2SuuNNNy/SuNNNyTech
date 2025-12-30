<?php
require_once 'vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('795164327909-4r0pv95j9ckcceggl9kub1k96fhq0bot.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/sunnnytech/google-callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $userData = $oauth->userinfo->get();

    $_SESSION['name'] = $userData->name;
    $_SESSION['email'] = $userData->email;

    header('Location: dashboard.php');
    exit;
}
