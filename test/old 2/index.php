<?php
// Get the PHP helper library from https://twilio.com/docs/libraries/php
require __DIR__ . '/vendor/autoload.php'; // Loads the library
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

// Required for all Twilio access tokens
// To set up environmental variables, see http://twil.io/secure
$twilioAccountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$twilioApiKey = '29d72eeab3576a1563a149e1246009fa';
$twilioApiSecret = 'O1W8LmXokqJYzO4C7YVoyBeHjQZQgXDy';

// Required for Video grant
$roomName = 'cool room';
// An identifier for your app - can be anything you'd like
$identity = 'john_doe';

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $twilioAccountSid,
    $twilioApiKey,
    $twilioApiSecret,
    3600,
    $identity
);

// Create Video grant
$videoGrant = new VideoGrant();
$videoGrant->setRoom($roomName);

// Add grant to token
$token->addGrant($videoGrant);

// render token to string
echo $token->toJWT();