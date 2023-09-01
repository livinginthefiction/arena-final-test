<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Twilio Video Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://sdk.twilio.com/js/video/releases/2.22.1/twilio-video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        /* Keyframes animation for vibrate effect */
        @keyframes vibrate {
            0% {transform: translateX(0);}
            20% {transform: translateX(-5px);}
            40% {transform: translateX(5px);}
            60% {transform: translateX(-5px);}
            80% {transform: translateX(5px);}
            100% {transform: translateX(0);}
        }

        /* Keyframes animation for grow & shrink effect */
        @keyframes growShrink {
            0% {transform: scale(1);}
            50% {transform: scale(1.1);}
            100% {transform: scale(1);}
        }

        /* Apply both animations to the same element */
        .animated-element {
            animation: vibrate 1s infinite, growShrink 2s infinite; /* Adjust durations as needed */
        }
    </style>
</head>
<body>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <!-- <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg> -->
        <span class="fs-4">Video Calling App</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="nav-link">Welcome <?= session('user')['username'] ?>!</a></li>
        <li class="nav-item"><a href="<?= base_url('login/logout'); ?>" class="nav-link active" aria-current="page">Logout</a></li>
      </ul>
    </header>

    <div class="row m-5">
    <div id="local" class="col-md-6">
        <h2>LOCAL</h2>
        <div id="local-video-container"></div>
        <input type="text" value="newRoom" class="form-control m-2" id="nr" aria-describedby="emailHelp">
        <input type="text" value="<?= session('user')['username'] ?>" class="form-control m-2" id="idnr" aria-describedby="emailHelp">
        <select class="form-select m-2" id="caller" aria-label="Default select example">
            <?php foreach ($usersExceptCurrent as $value) { print_r($value);?>
                <option value="<?= $value['userid'] ?>"><?= $value['username'] ?></option>
            <?php } ?>
        </select>
      <button id="newRoom" type="submit" class="btn btn-success w-100 m-2">Call</button>
      <button id="endRoom" type="submit" class="btn btn-danger w-100 m-2">End Call</button>
    </div>
    <div id="remote" class="col-md-6">
        <h2>REMOTE</h2>
        <div id="remote-video-container"></div>
        <div id="remote-button">
            <input type="text" class="form-control m-2" id="jr" aria-describedby="emailHelp">
            <input type="text" value="<?= session('user')['username'] ?>" class="form-control m-2" id="idjr" aria-describedby="emailHelp">
            <input type="hidden" value="" class="form-control m-2" id="jrsessionid" aria-describedby="emailHelp">
            <button id="joinRoom" type="submit" class="btn btn-success w-100 m-2 animated-element">Accept Call</button>
      </div>
      
    </div>
  </div>
  </div>
<script type="text/javascript">
    // $(document).ready(function(){
    //     $("#remote").hide();
    //     $("#endRoom").hide();
    // });

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
                var timer = setInterval(function() {countdown--;if (countdown < 0) {clearInterval(timer);endcall(jrsessionid);}}, 1000); 

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
    document.getElementById('joinRoom').addEventListener('click', () => {
            let newRoomName = document.getElementById('jr').value;
            let jrsessionid = document.getElementById('jrsessionid').value;

            fetch('/dashboard/endroom', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    room: newRoomName,
                    sessionID: jrsessionid
                })
            })
            .then(response => response.json())
            .then(data => {
                
            })
            .catch(error => {
                console.error(`Error: ${error.message}`);
            });
        });

// =================================================================
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('40f0f1503664d8977ab7', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('arenatest');
    channel.bind('call_event', function(data) {
        document.getElementById('jrsessionid').value=data.sessionID;
        if (data.receiver== <?= session('user')['userid'] ?> ) {
         // data=JSON.parse(data);
            console.log(data);
            document.getElementById('remote-button').style.display = 'block';   
            document.getElementById('jr').value=data.roomname;
        }
        
    });
  </script>

<script type="text/javascript">
// Get a reference to the video container
//  var roomName;
// const videoContainer = document.getElementById('video-container');
// const videoContainer = document.getElementById('video-container-2');
// // Fetch an access token from your server using your Twilio credentials
// fetch('create-room.php', {
//     method: 'POST',
//     headers: {
//         'Content-Type': 'application/json'
//     },
//     body: JSON.stringify({
//         identity: 'shubhamn', // Replace with a unique identity for the user
//         room: roomName
//     })
// })
// .then(response => response.json())
// .then(data => {
//     const token = data.token;
//     const roomName = data.roomName;

//     // Create a local video track
//     return Twilio.Video.createLocalVideoTrack().then(localVideoTrack => {
//         // Add the local video track to the video container
//         videoContainer.appendChild(localVideoTrack.attach());

//         // Join a room
//         return Twilio.Video.connect(token, {
//             name: roomName,
//             tracks: [localVideoTrack]
//         });
//     });
// })
// .then(room => {
//     console.log(`Successfully joined room ${room.name}`);

//     // Attach remote participants' tracks to the video container
//     room.on('participantConnected', participant => {
//         participant.tracks.forEach(track => {
//             if (track.isSubscribed) {
//                 videoContainer.appendChild(track.attach());
//             }
//         });

//         participant.on('trackSubscribed', track => {
//             videoContainer.appendChild(track.attach());
//         });
//     });
// })
// .catch(error => {
//     console.error(`Error joining room: ${error.message}`);
// });
</script>

</body>
</html>