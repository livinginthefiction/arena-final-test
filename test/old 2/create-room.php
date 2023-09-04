<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// require __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

$accountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$authToken = '45c886ff1cf1ee9495a56d96b891770e';
$twilioApiSecret = 'SaSCKht2PDdDUGTVus7YcxGAelvwlKd2';
$twilioApiKey = 'SKbaa05d49eb2ce8544b8286b86e62032a';

$twilioClient = new Client($accountSid, $authToken);

$identity = 'shubhamn'; // Replace with actual user identity
$roomName = 'my-room'.uniqid(); // Replace with desired room name

// Generate Access Token
$ttl = 60; // Time-to-live in seconds
$token = new AccessToken($accountSid, $twilioApiKey, $twilioApiSecret, $ttl, $identity);
$videoGrant = new VideoGrant();
$videoGrant->setRoom($roomName);
$token->addGrant($videoGrant);

// Create Room using Twilio REST API
$room = $twilioClient->video->v1->rooms->create([
    'uniqueName' => $roomName
]);

// // Create Participant using Twilio REST API
// $participant = $twilioClient->video->v1->rooms($room->sid)->participants
//                                                             ->create(['identity' => 'new_user_identity']);
//                                                             ->fetch();

echo json_encode([
    'token' => $token->toJWT(),
    'roomSid' => $room->sid,
    'roomName' => $roomName,
    // 'participantSid' => $participant->sid
]);