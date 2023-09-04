<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'vendor/autoload.php'; // Include the Twilio PHP library

use Twilio\Rest\Client;

$accountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
$authToken = '45c886ff1cf1ee9495a56d96b891770e';

$client = new Client($accountSid, $authToken);

echo $roomSid = $_GET['roomSid']; // Get the room SID from the frontend

$client->video->v1->rooms($roomSid)->update('completed');

?>
