<?php 

    include('config.php');

    $id = $_GET['id'];


    $sql =  "DELETE FROM acc_pusers WHERE user_id = $id"; 

    if (mysqli_query($conn, $sql)) {
        header('location: ../main.php');
    }


?>