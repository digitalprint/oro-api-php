<?php
/*
 * Make sure to disable the display of errors in production code!
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/functions.php";

$apiEndpoint = 'YOUR_ENDPOINT';
$apiUser = 'YOUR_API_USER';

$clientId = 'YOUR_CLIENT_ID';
$clientSecret = 'YOUR_CLIENT_SECRET';

$oro = new \Digitalprint\Oro\Api\OroApiClient();
$oro->setApiEndpoint($apiEndpoint);
$oro->setUser($apiUser);

$res = $oro->authorization->create([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
]);

$oro->setAccessToken($res->access_token);
