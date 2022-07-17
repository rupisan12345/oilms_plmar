<?php

    include_once "config.php";
    include_once "userlogin-register.php";
    
    $searchusers_query_default = "SELECT * FROM acc_users WHERE user_id != {$_SESSION['id']}";
    $searchusers_query = $searchusers_query_default;
    $searchusers_results = mysqli_query($conn, $searchusers_query);
    $append = "";
    $somevar = $_SESSION['id'];
    

    if(mysqli_num_rows($searchusers_results) >= 1){
        while($searchusers_rows = mysqli_fetch_array($searchusers_results)){   
            $displaylatestmessage_query = "SELECT * FROM acc_messages WHERE (incoming_msg_id = {$searchusers_rows['user_id']}
                                            OR outgoing_msg_id = {$searchusers_rows['user_id']}) AND (outgoing_msg_id = {$_SESSION['id']} 
                                            OR incoming_msg_id = {$_SESSION['id']}) ORDER BY msg_id DESC LIMIT 1";
            $displaylatestmessage_result = mysqli_query($conn, $displaylatestmessage_query);
            $displaylatestmessage_row = mysqli_fetch_assoc($displaylatestmessage_result);
            if(mysqli_num_rows($displaylatestmessage_result) > 0){
                $displaymessage = $displaylatestmessage_row['message'];
            }else{
                $displaymessage = "No Message Available";
            }

            (strlen($displaymessage) > 28) ? $trimdisplaymessage = substr($displaymessage, 0, 28).'...' : $trimdisplaymessage = $displaymessage;
            if(isset($displaylatestmessage_row['outgoing_msg_id'])){
                ($_SESSION['id'] == $displaylatestmessage_row['outgoing_msg_id']) ? $you = "You: " : $you = "";
            }else{
                $you = "";
            }

            $append .=  '<a href="message_user.php?user_id='.$searchusers_rows['user_id'].'">
                        <div class="search_users_details">
                            <img src="'.$searchusers_rows['image'].'" alt="userimage">
                            <div class="search_users_details_content">
                            <span>'. $searchusers_rows['fullname'] .'</span>
                                <p>'.$you.$trimdisplaymessage.'</p>
                            </div>
                        </div>
                        </a>';
        }
    }else{
        $append = "No users are available to chat";
    }

    echo $append;


?>