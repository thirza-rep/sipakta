<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new \Google\Client();
$client->setClientId($_ENV['GOOGLE_DRIVE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_DRIVE_CLIENT_SECRET']);
$result = $client->fetchAccessTokenWithRefreshToken($_ENV['GOOGLE_DRIVE_REFRESH_TOKEN']);
print_r($result);
