<?php

    include('backend/userlogin-register.php');

    $meeting_id = "";

    if(isset($_GET['meeting_id']))
    {
        $meeting_id = $_GET['meeting_id'];
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Telcon</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>

<body>

    <input type="hidden" class="myname" value="<?php echo $_SESSION['fullname']; ?>">
    <input type="hidden" class="meeting_id" value="<?php echo $meeting_id; ?>">

    <script>
        // var randomID = Math.floor(100000 + Math.random() * 900000);
        var myname = $('.myname').val();
        var meeting_id = $('.meeting_id').val();

        // console.log(randomID);
        // console.log(myname);

        var script = document.createElement("script");
        script.type = "text/javascript";
        script.addEventListener("load", function(event) {

            const meeting = new VideoSDKMeeting();

            // Set apikey, meetingId and participant name
            const apiKey = "79d9956c-e99b-4d1a-8633-909c53694633"; // generated from app.videosdk.live
            const meetingId = meeting_id;
            const name = myname;

            const config = {
                name: name,
                apiKey: apiKey,
                meetingId: meetingId,

                containerId: null,
                redirectOnLeave: "https://www.videosdk.live/",

                micEnabled: true,
                webcamEnabled: true,
                participantCanToggleSelfWebcam: true,
                participantCanToggleSelfMic: true,

                chatEnabled: true,
                screenShareEnabled: true,
                pollEnabled: true,
                whiteboardEnabled: true,
                raiseHandEnabled: true,

                recordingEnabled: true,
                recordingEnabledByDefault: false,
                recordingWebhookUrl: "https://www.videosdk.live/callback",
                recordingAWSDirPath: `/meeting-recordings/${meetingId}/`, // automatically save recording in this s3 path

                brandingEnabled: true,
                brandLogoURL: "https://picsum.photos/200",
                brandName: "Awesome startup",
                poweredBy: true,

                participantCanLeave: true, // if false, leave button won't be visible

                // Live stream meeting to youtube
                livestream: {
                    autoStart: true,
                    outputs: [
                        // {
                        //   url: "rtmp://x.rtmp.youtube.com/live2",
                        //   streamKey: "<STREAM KEY FROM YOUTUBE>",
                        // },
                    ],
                },

                permissions: {
                    askToJoin: false, // Ask joined participants for entry in meeting
                    toggleParticipantMic: true, // Can toggle other participant's mic
                    toggleParticipantWebcam: true, // Can toggle other participant's webcam
                    removeParticipant: true, // Remove other participant from meeting
                    endMeeting: true, // End meeting for all participant
                    drawOnWhiteboard: true, // Can Draw on whiteboard
                    toggleWhiteboard: true, // Can toggle whiteboard
                    toggleRecording: true, // Can toggle recording
                },

                joinScreen: {
                    visible: true, // Show the join screen ?
                    title: "Daily scrum", // Meeting title
                    meetingUrl: window.location.href, // Meeting joining url
                },

                pin: {
                    allowed: true, // participant can pin any participant in meeting
                    layout: "SPOTLIGHT", // meeting layout - GRID | SPOTLIGHT | SIDEBAR
                },

                leftScreen: {
                    // visible when redirect on leave not provieded
                    actionButton: {
                        // optional action button
                        label: "Video SDK Live", // action button label
                        href: "https://videosdk.live/", // action button href
                    },
                },
            };

            meeting.init(config);
        });

        script.src =
            "https://sdk.videosdk.live/rtc-js-prebuilt/0.1.26/rtc-js-prebuilt.js";
        document.getElementsByTagName("head")[0].appendChild(script);
    </script>

</body>

</html>