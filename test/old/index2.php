<?php
// Get the PHP helper library from twilio.com/docs/php/install
require __DIR__ . '/vendor/autoload.php';
// use Twilio\Jwt\AccessToken;
// use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

// Required for all Twilio access tokens
$twilioAccountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$token = '29d72eeab3576a1563a149e1246009fa';
// $twilioApiKey = 'SK13a87a00c6c8d34ec669ced434f13930';
// // $twilioApiKey = ;
// $twilioApiSecret = 'O1W8LmXokqJYzO4C7YVoyBeHjQZQgXDy';


// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
// $sid = getenv("TWILIO_ACCOUNT_SID");
// $token = getenv("TWILIO_AUTH_TOKEN");
$twilio = new Client($twilioAccountSid, $token);

$room = $twilio->video->v1->rooms
                          ->create(["uniqueName" => "DailyStandup4"]);

print_r($room);
