<?php
require __DIR__ . '/vendor/autoload.php';
namespace App\Controllers;

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;

class Dashboard extends BaseController {
    protected $session;

    public function __construct() {
        $this->session = session();
    }

    public function index() {
        // Check if the 'user' session is set
        if (!$this->session->has('user')) {
            return redirect()->to(base_url());
        }

        return view('dashboard');
    }

    public function createroom() {
        // Check if the 'user' session is set
        if (!$this->session->has('user')) {
            return redirect()->to(base_url());
        }

        return view('dashboard');
    }

    public function createroom() {
        $accountSid = 'AC9878dd41e790434ac30ea586ce3d87a0';
        $authToken = '45c886ff1cf1ee9495a56d96b891770e';
        $twilioApiSecret = 'SaSCKht2PDdDUGTVus7YcxGAelvwlKd2';
        $twilioApiKey = 'SKbaa05d49eb2ce8544b8286b86e62032a';

        $twilioClient = new Client($accountSid, $authToken);
        $_POST = json_decode(file_get_contents('php://input'), true);
        $identity = $_POST['identity']; // Replace with actual user identity
        $roomName = $_POST['room']; // Replace with desired room name
        // $roomName = 'my-room'.uniqid(); // Replace with desired room name

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

        echo json_encode([
            'token' => $token->toJWT(),
            'roomSid' => $room->sid,
            'roomName' => $roomName,
            // 'participantSid' => $participant->sid
        ]);
    }

    public function joinroom() {
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
    }
}
