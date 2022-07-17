<?php 

    include('config.php');

    $id = $_GET['id'];

    $sql = "UPDATE acc_pusers SET approval = 'APPROVED' WHERE user_id = $id";
    $sql1 =  "INSERT INTO acc_users (user_id, user_creator_id, occupation, image, firstname, lastname, fullname, username, email, number, password, gender, approval, status)
            SELECT user_id, user_creator_id, occupation, image, firstname, lastname, fullname, username, email, number, password, gender, approval, status FROM acc_pusers
            WHERE user_id = $id";
    $sql2 =  "DELETE FROM acc_pusers WHERE user_id = $id"; 

    if (mysqli_query($conn, $sql)) {

        header('location: ../main.php');

        if (mysqli_query($conn, $sql1)) {
            header('location: ../main.php');
        }

        if (mysqli_query($conn, $sql2)) {
            header('location: ../main.php');
        }

    }








?>