<?php

session_start();
$c = require_once '_config.php';

/**
 * USER DENY REQUEST
 */

if ( ! empty($_GET['error'])) {
    die($_GET['error'].': '.$_GET['error_description']);
}
/**
 * USER ALLOW REQUEST
 */
if( ! function_exists('curl_version')) {
    die('CURL extension required');
}

if (empty($_GET['code']))  {
    die('Invalid code');
}

// state - optional param
if (empty($_GET['state'])) {
    die('Invalid state');
}

if (session_id() != $_GET['state']) {
    die('Invalid session id. Probably the user has logged out');
}

$ch = curl_init($c['provider'].'/oauth/access_token?'.http_build_query(array('code' => $_GET['code'], 'client_secret' => $c['client_secret'], 'client_id' => $c['client_id'])));
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

if ( ! $request_token = curl_exec($ch)) {
    die('Request Error');
}

$response_token = json_decode($request_token, TRUE);

if ( ! empty($response_token['error']))
{
    die($response_token['error'].': '.$response_token['error_description']);
}
else
{
    $_SESSION['vipparcel_access'] = array(
        'access_token' => $response_token['access_token'],
        'expires_in'   => $response_token['expires_in'],
        'user_id'      => $response_token['user_id'],
    );

    header('Location: '.$c['script_url']);
}