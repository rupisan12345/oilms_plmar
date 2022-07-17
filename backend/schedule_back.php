<?php 

$connect = new PDO('mysql:host=localhost;dbname=u428338285_db_cap', 'u428338285_root', 'VinceRodrigo45');

    if (isset($_POST["insert_event"])) 
    {
        $user_id = $_POST['user_id'];
        $query = "  INSERT INTO acc_sched 
                    (user_id, title, start_event, end_event) 
                    VALUES ('$user_id', :title, :start_event, :end_event)
                    ";

        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':title'  => $_POST['title'],
                ':start_event' => $_POST['start'],
                ':end_event' => $_POST['end']
            )
        );
    }

    if (isset($_POST["update_event"])) 
    {   
        $user_id = $_POST['user_id'];
        $query = "UPDATE acc_sched 
                    SET title=:title, start_event=:start_event, end_event=:end_event 
                    WHERE date_id=:date_id AND user_id = '$user_id';
                    ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':title'  => $_POST['title'],
                ':start_event' => $_POST['start'],
                ':end_event' => $_POST['end'],
                ':date_id'   => $_POST['date_id']
            )
        );
    }

    if(isset($_POST["delete_event"]))
    {
        $user_id = $_POST['user_id'];

        $query = "DELETE from acc_sched WHERE date_id=:date_id AND user_id = '$user_id'";
        
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':date_id' => $_POST['date_id']
            )
        );
    }

?>