<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Twilio Video Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://sdk.twilio.com/js/video/releases/2.22.1/twilio-video.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                screens: {
                    'xs': '300px',                    
                    'sm': '600px',
                    'md': '768px',
                    'lg': '1024px',
                    'xl': '1240px',
                    '2xl': '1380px',
                }
            }
        }
    </script>
    <style>
        @keyframes vibrate {
            0% {transform: translateX(0);}
            20% {transform: translateX(-5px);}
            40% {transform: translateX(5px);}
            60% {transform: translateX(-5px);}
            80% {transform: translateX(5px);}
            100% {transform: translateX(0);}
        }

        @keyframes growShrink {
            0% {transform: scale(1);}
            50% {transform: scale(1.1);}
            100% {transform: scale(1);}
        }

        .animated-element {animation: vibrate 1s infinite, growShrink 2s infinite;}
    </style>
</head>
<body>
    <div class="container mx-auto">
    <header>
        <nav class="container px-4 md:px-6 lg:px-6 py-2.5 bg-white border-gray-200 border-b min-h-[10vh]">
            <div class="flex flex-wrap xs:justify-center sm:justify-between md:justify-between lg:justify-between items-center mx-auto max-w-screen-xl">
                <a href="/" class="flex items-center">
                    <span class="sm:text-center self-center">
                        <h2 class="font-bold text-xl text-[#002D74]">PixelTalk</h2>
                    </span>
                </a>
                <ul class="flex items-center lg:order-2">
                    <li class="text-gray-800 font-medium text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-1 capitalize text-[#002D74]">Welcome <?= session('user')['username'] ?>!</li>
                    <li class="text-white cursor-pointer bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2">
                        <a href="<?= base_url('login/logout'); ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container sm:px-2 md:px-6 lg:px-12 flex items-center min-w-screen min-h-[89vh]" style="font-family: 'Muli', sans-serif;">
        <div class="container ml-auto mr-auto flex sm:flex-row-reverse md: flex-row lg:flex-row flex-wrap items-start">
            <div class="w-full md:w-1/2 lg:w-1/2 pl-5 pr-5 mb-5 lg:pl-2 lg:pr-2">
                <div class="w-full pl-5 lg:pl-2 my-3">
                    <h2 class="font-bold text-xl text-[#002D74]">Remote</h2>
                </div>
                <div class="bg-white rounded-lg m-h-64 p-2">
                    <div class="mb-2" id="remote-video-container"></div>
                    <div class="rounded-lg p-4 bg-gray-100 flex flex-col">
                        <div id="remote-button" class="w-100">
                            <!-- <div class="mb-2 rounded-md" id="remote-video-container"></div> -->
                            <input type="text" id="jr" class="appearance-none block w-full bg-white-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="Enter Room Name">
                            <input type="text" id="idjr" value="<?= session('user')['username'] ?>" readonly class="appearance-none block w-full bg-white-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="Enter Room Name">
                            <input type="hidden" value="" class="form-control m-2" id="jrsessionid" aria-describedby="emailHelp">
                            <input type="hidden" value="" class="form-control m-2" id="roomSid" aria-describedby="emailHelp">
                            <div class="flex">
                                <button id="joinRoom" type="submit" class="animated-element relative bg-green-600 hover:bg-green-700 transition:hover:300 rounded-md px-4 py-2 text-white w-1/2 m-2">Accept Call
                                </button>
                                <!-- <button id="endRoom" type="submit" class="bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-white w-1/2 m-2">End Call</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full border-0 md:border-0 lg:border-l md:w-1/2 lg:w-1/2 pl-5 pr-5 mb-5 lg:pl-2 lg:pr-2">
                <div class="w-full pl-5 lg:pl-2 my-3">
                    <h2 class="font-bold text-xl text-[#002D74]">Local</h2>
                </div>
                <div class="bg-white rounded-lg m-h-64 p-2">
                    <div class="mb-2" id="local-video-container"></div>
                    <div class="rounded-lg p-4 bg-gray-100 flex flex-col">
                        <div id="local" class="w-100">
                            <!-- <div id="local-video-container" class="mb-2 rounded-md"></div> -->
                            <input id="nr" value="newroom" type="text" class="appearance-none block w-full bg-white-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="Enter Room Name">
                            <input type="text" readonly class="appearance-none block w-full bg-white-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="Enter Room Name" id="idnr" value="<?= session('user')['username'] ?>">
                            <select class="block w-full bg-white-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="caller" placeholder="Select User You Wish To Call">
                                <?php foreach ($usersExceptCurrent as $value) { ?>
                                    <option class="mb-2" value="<?= $value['userid'] ?>"><?= $value['username'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="flex">
                                <button id="newRoom" type="submit" class="bg-green-600 hover:bg-green-700 rounded-md px-4 py-2 text-white w-1/2 m-2">Call</button>
                                <button id="endRoom" type="submit" class="bg-red-600 hover:bg-red-700 rounded-md px-4 py-2 text-white w-1/2 m-2">End Call</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

   
</div>
<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function() {
        // Hide the elements by their IDs
        var remoteElement = document.getElementById('remote-button').style.display = 'none';
        var endRoomElement = document.getElementById('endRoom').style.display = 'none';
    });


    document.getElementById('newRoom').addEventListener('click', () => {
        let newRoomName = document.getElementById('nr').value;
        let participantIdentity = document.getElementById('idnr').value;
        let receiver = document.getElementById('caller').value;

        let localVideoContainer = document.getElementById('local-video-container');
        let remoteVideoContainer = document.getElementById('remote-video-container');

        fetch('/dashboard/createroom', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                identity: participantIdentity,
                room: newRoomName,
                receiver: receiver
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('endRoom').style.display = 'block';
            document.getElementById('roomSid').value=data.roomSid;
            const token = data.token;
            return Twilio.Video.createLocalVideoTrack().then(localVideoTrack => {
                localVideoContainer.appendChild(localVideoTrack.attach());

                return Twilio.Video.connect(token, {
                    name: newRoomName,
                    tracks: [localVideoTrack]
                });
            });
        })
        .then(room => {
            console.log(`Successfully joined room ${room.name}`);

            room.on('participantConnected', participant => {
                participant.tracks.forEach(track => {
                    if (track.isSubscribed) {
                        remoteVideoContainer.appendChild(track.attach());
                    }
                });

                participant.on('trackSubscribed', track => {
                    remoteVideoContainer.appendChild(track.attach());
                });
            });
        })
        .catch(error => {
            console.error(`Error joining room: ${error.message}`);
        });
    });
// =============================================
        document.getElementById('joinRoom').addEventListener('click', () => {
            let newRoomName = document.getElementById('jr').value;
            let joinparticipantIdentity = document.getElementById('idjr').value;
            let jrsessionid = document.getElementById('jrsessionid').value;

            let localVideoContainer = document.getElementById('local-video-container');
            let remoteVideoContainer = document.getElementById('remote-video-container');

            fetch('/dashboard/joinroom', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    identity: joinparticipantIdentity,
                    room: newRoomName,
                    sessionID: jrsessionid
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('endRoom').style.display = 'block';
                var countdown = 60; 
                var timer = setInterval(function() {countdown--;console.log('countdown:',countdown);if (countdown < 0) {clearInterval(timer);endroom();}}, 1000); 

                const token = data.token;

                return Twilio.Video.createLocalVideoTrack().then(localVideoTrack => {
                    localVideoContainer.appendChild(localVideoTrack.attach());

                    return Twilio.Video.connect(token, {
                        name: newRoomName,
                        tracks: [localVideoTrack]
                    });
                });
            })
            .then(room => {
                console.log(`Successfully joined room ${room.name}`);
                console.log('room',room);
                room.on('participantConnected', participants => {
                   console.log(`Participant connected:`,participants);
                    participant.tracks.forEach(track => {
                        if (track.isSubscribed) {
                            remoteVideoContainer.appendChild(track.attach());
                        }
                    });

                    participant.on('trackSubscribed', track => {
                        remoteVideoContainer.appendChild(track.attach());
                    });
                });
            })
            .catch(error => {
                console.error(`Error joining room: ${error.message}`);
            });
        });

// ======================================
    document.getElementById('endRoom').addEventListener('click', () => {endroom()});
    function endroom() {
        let roomSid = document.getElementById('roomSid').value;
        let jrsessionid = document.getElementById('jrsessionid').value;

        fetch('/dashboard/endroom', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                roomSid: roomSid,
                sessionID: jrsessionid
            })
        })
        .then(response => response.json())
        .then(data => {
            
        })
        .catch(error => {
            console.error(`Error: ${error.message}`);
        });
    }
// =================================================================
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('40f0f1503664d8977ab7', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('arenatest');
    channel.bind('call_event', function(data) {
        document.getElementById('jrsessionid').value=data.sessionID;
        document.getElementById('roomSid').value=data.roomSid;
        if (data.receiver== <?= session('user')['userid'] ?> ) {
         // data=JSON.parse(data);
            console.log(data);
            document.getElementById('remote-button').style.display = 'block';   
            document.getElementById('jr').value=data.roomname;
        }
        
    });
  </script>
</body>
</html>