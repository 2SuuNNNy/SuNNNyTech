<?php
require_once 'vendor/autoload.php';
session_start();

$fb = new \Facebook\Facebook([
    'app_id' => '2081588038993422',
    'app_secret' => '0b774368c3f4f5e56d7d4c094a8fe50a',
    'default_graph_version' => 'v18.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (Exception $e) {
    echo 'FB Login Error: ' . $e->getMessage();
    exit;
}

if (!isset($accessToken)) {
    echo 'Error getting access token';
    exit;
}

$response = $fb->get('/me?fields=id,name,email', $accessToken);
$user = $response->getGraphUser();

// Save user info in session (or database)
$_SESSION['name'] = $user['name'];
$_SESSION['email'] = $user['email'];

header('Location: dashboard.php');
exit;
