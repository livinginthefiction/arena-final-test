<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// require __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

$accountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$authToken = '114fa22706b0d7e8e12aac5a1118f920';
$twilioApiSecret = 'WG2WoP3ZlMWWtc3Y26zmj48BKgqyJLgK';
$twilioApiKey = 'SK1c0bb97c984adf294a31b511b4f2c752';

$twilioClient = new Client($accountSid, $authToken);
$_POST = json_decode(file_get_contents('php://input'), true);
$identity = $_POST['identity']; // Replace with actual user identity
$roomName = $_POST['room']; // Replace with desired room name

// Generate Access Token
$ttl = 60; // Time-to-live in seconds
$token = new AccessToken($accountSid, $twilioApiKey, $twilioApiSecret, $ttl, $identity);
$videoGrant = new VideoGrant();
$videoGrant->setRoom($roomName);
$token->addGrant($videoGrant);

// Create Room using Twilio REST API
$room = $twilioClient->video->v1->rooms($roomName)
                                ->fetch();

// // Create Participant using Twilio REST API
// $participant = $twilioClient->video->v1->rooms($room->sid)->participants
//                                                             ->create(['identity' => 'new_user_identity']);
//                                                             ->fetch();

echo json_encode([
    'token' => $token->toJWT(),
    // 'roomSid' => $room->sid,
    'roomName' => $room->uniqueName,
]);