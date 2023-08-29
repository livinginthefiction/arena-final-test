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
</head>
<body>
  <div class="container">
    <div class="row m-5">
    <div class="col-md-6">
      <h2>LOCAL</h2>
      <div id="local-video-container"></div>
      <input type="text" value="newRoom" class="form-control m-2" id="nr" aria-describedby="emailHelp">
      <input type="text" value="shubhamm" class="form-control m-2" id="idnr" aria-describedby="emailHelp">
      <button id="newRoom" type="submit" class="btn btn-primary m-2">Submit</button>
    </div>
    <div class="col-md-6">
      <h2>REMOTE</h2>
      <div id="remote-video-container"></div>
      <input type="text" value="newRoom" class="form-control m-2" id="jr" aria-describedby="emailHelp">
      <input type="text" value="arena" class="form-control m-2" id="idjr" aria-describedby="emailHelp">
      <button id="joinRoom" type="submit" class="btn btn-primary m-2">Submit</button>
    </div>
  </div>
  </div>
<script type="text/javascript">
        document.getElementById('newRoom').addEventListener('click', () => {
            let newRoomName = document.getElementById('nr').value;
            let participantIdentity = document.getElementById('idnr').value;

            let localVideoContainer = document.getElementById('local-video-container');
            let remoteVideoContainer = document.getElementById('remote-video-container');

            fetch('/dashboard/createroom.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    identity: participantIdentity,
                    room: newRoomName
                })
            })
            .then(response => response.json())
            .then(data => {
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

        document.getElementById('joinRoom').addEventListener('click', () => {
            let newRoomName = document.getElementById('jr').value;
            let joinparticipantIdentity = document.getElementById('idjr').value;

            let localVideoContainer = document.getElementById('local-video-container');
            let remoteVideoContainer = document.getElementById('remote-video-container');

            fetch('/dashboard/join-room.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    identity: joinparticipantIdentity,
                    room: newRoomName
                })
            })
            .then(response => response.json())
            .then(data => {
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