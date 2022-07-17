<?php 

    include_once "config.php";
    include_once "userlogin-register.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($message)){
        $insertmessage_query = "INSERT INTO acc_messages (incoming_msg_id, outgoing_msg_id, message) 
                                VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')";
        $insertmessage_result = mysqli_query($conn, $insertmessage_query) or die();
    }


?>