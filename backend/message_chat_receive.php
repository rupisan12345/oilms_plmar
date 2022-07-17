<?php 

    include_once "config.php";
    include_once "userlogin-register.php";

    $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $append = "";

    $getmessages_query =    "SELECT * FROM acc_messages 
                            LEFT JOIN acc_users on acc_users.user_id = acc_messages.outgoing_msg_id
                            WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id}) 
                            OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id ASC";
    $getmessage_results = mysqli_query($conn, $getmessages_query);
    if(mysqli_num_rows($getmessage_results) > 0){
        while($getmessage_rows = mysqli_fetch_assoc($getmessage_results)){
            if($getmessage_rows['outgoing_msg_id'] === $outgoing_id){
                $append .= '<div class="chat outgoing">
                                <div class="chat_details">
                                    <p>'.$getmessage_rows['message'].'</p>
                                </div>
                            </div>';
            }else{
                $append .= '<div class="chat incoming">
                                <img src="'.$getmessage_rows['image'].'" alt="">
                                <div class="chat_details">
                                    <p>'.$getmessage_rows['message'].'</p>
                                </div>
                            </div>';

            }
        }
        echo $append;
    }


?>