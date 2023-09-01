<?php
namespace App\Controllers;
// require __DIR__ . '/vendor/autoload.php';

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Pusher\Pusher;
use App\Models\VideoCallSessionModel;

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

        // Get the current user's ID from the session
        $currentUserId = $this->session->get('user')['userid'];

        // Load the UserModel
        $userModel = new \App\Models\UserModel();

        // Get the list of users except the current user
        $usersExceptCurrent = $userModel->getUsersExceptCurrent($currentUserId);

        // Pass the list of users to the view
        // echo json_encode($usersExceptCurrent);
        $data = [
            'usersExceptCurrent' => $usersExceptCurrent
        ];

        return view('dashboard', $data);
    }

    public function createroom() {
        // Include the autoload.php file
        require_once(APPPATH . '../vendor/autoload.php');
        $accountSid = config('Twilio')->accountSid;
        $authToken = config('Twilio')->authToken;
        $twilioApiSecret = config('Twilio')->twilioApiSecret;
        $twilioApiKey = config('Twilio')->twilioApiKey;

        $twilioClient = new Client($accountSid, $authToken);
        $_POST = json_decode(file_get_contents('php://input'), true);
        $identity = $_POST['identity']; 
        $roomName = $_POST['room']; 
        $receiver = $_POST['receiver']; 

        // $roomName = 'my-room'.uniqid(); 

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

        $app_id = config('Pusher')->app_id; 
        $app_key = config('Pusher')->key; 
        $app_secret = config('Pusher')->secret; 
        $app_cluster = config('Pusher')->cluster; 

        $videoCallSessionModel = new VideoCallSessionModel();
        $sessionID = $videoCallSessionModel->createSession($this->session->get('user')['userid'], $receiver);

        $pusher = new Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);

        $pusherData = array('roomname' => $room->uniqueName,'receiver' => $receiver,'sessionID' => $sessionID, );
        $pusher->trigger('arenatest', 'call_event', $pusherData);

        echo json_encode([
            'token' => $token->toJWT(),
            'roomSid' => $room->sid,
            'roomName' => $roomName,
            // 'participantSid' => $participant->sid
        ]);
    }

    public function joinroom() {
        // Include the autoload.php file
        require_once(APPPATH . '../vendor/autoload.php');
        $accountSid = config('Twilio')->accountSid;
        $authToken = config('Twilio')->authToken;
        $twilioApiSecret = config('Twilio')->twilioApiSecret;
        $twilioApiKey = config('Twilio')->twilioApiKey;
        
        $twilioClient = new Client($accountSid, $authToken);
        $_POST = json_decode(file_get_contents('php://input'), true);
        $identity = $_POST['identity']; // Replace with actual user identity
        $roomName = $_POST['room']; // Replace with desired room name
        $sessionID = $_POST['sessionID']; // Replace with desired room name

        // Generate Access Token
        $ttl = 60; // Time-to-live in seconds
        $token = new AccessToken($accountSid, $twilioApiKey, $twilioApiSecret, $ttl, $identity);
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $token->addGrant($videoGrant);

        // Create Room using Twilio REST API
        $room = $twilioClient->video->v1->rooms($roomName)
                                        ->fetch();

        $videoCallSessionModel = new VideoCallSessionModel();
        $videoCallSessionModel->startSession($sessionID);

        echo json_encode([
            'token' => $token->toJWT(),
            // 'roomSid' => $room->sid,
            'roomName' => $room->uniqueName,
        ]);
    }

    public function Pusher() {
        require_once(APPPATH . '../vendor/autoload.php');
        $app_id = config('app_id')->accountSid; 
        $app_key = config('key')->accountSid; 
        $app_secret = config('secret')->accountSid; 
        $app_cluster = config('cluster')->accountSid; 
        $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);
    }
}
