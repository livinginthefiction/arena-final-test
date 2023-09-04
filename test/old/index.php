<?php

// Set error reporting level
error_reporting(E_ALL);
ini_set('display_errors', 0); // Turn off error display on the webpage
ini_set('log_errors', 1); // Enable error logging to a file

// Specify the error log file path
ini_set('error_log', 'error_log.txt'); // Change this path to your desired log file


require __DIR__ . '/vendor/autoload.php';
// require 'twilio-php/autoload.php';

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

// Twilio Account SID and Auth Token
$accountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$authToken = '29d72eeab3576a1563a149e1246009fa';

// Create a Twilio Access Token
$accessToken = new AccessToken($accountSid, $authToken, 3600, 'identity');

// Video Grant
$videoGrant = new VideoGrant();
$videoGrant->setRoom('shubhamm'); // Replace 'my-room' with your desired room name
$accessToken->addGrant($videoGrant);

// Generate the Access Token and send it to the frontend
echo json_encode(['token' => $accessToken->toJwt()]);
?>
