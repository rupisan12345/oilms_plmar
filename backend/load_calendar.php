<?php

    include('userlogin-register.php');

    $user_id = $_SESSION['id'];

    $connect = new PDO('mysql:host=localhost;dbname=u428338285_db_cap', 'u428338285_root', 'VinceRodrigo45');
    $data = array();

    $query = "SELECT * FROM acc_sched WHERE user_id = '$user_id' ORDER BY date_id ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
    $data[] = array(
        'date_id'       => $row["date_id"],
        'title'         => $row["title"],
        'start'         => $row["start_event"],
        'end'           => $row["end_event"]
    );
    }
    echo json_encode($data);
?>