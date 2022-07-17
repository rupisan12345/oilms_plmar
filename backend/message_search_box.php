<?php

    include_once "config.php";
    include_once "userlogin-register.php";

    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $searh_query = "SELECT * FROM acc_users WHERE fullname LIKE '%{$searchTerm}%' AND user_id != {$_SESSION['id']}";
    $search_query_results = mysqli_query($conn, $searh_query);
    $append = "";

    if(mysqli_num_rows($search_query_results) > 0){
        while($searchusers_rows = mysqli_fetch_array($search_query_results)){   
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
        $append .= 'No user found related to your search term';
    }
    echo $append;
?>