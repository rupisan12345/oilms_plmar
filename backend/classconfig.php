<?php 

    if(session_id() == '') {
        session_start();
    }
    include('backend/userlogin-register.php');

    $class_id = substr(md5(uniqid(mt_rand(), true)), 0, 3);
    $classname = "";
    $section = "";
    $subj = "";
    
    $schedule = "";
    $credit = 0;
    $classcode = substr(md5(uniqid(mt_rand(), true)), 0, 6);

    $joincode = "";

    
    if(isset($_POST['create_class-btn'])){

        $classname = mysqli_real_escape_string($conn, $_POST['classname']);
        $section = mysqli_real_escape_string($conn, $_POST['section']);
        $subj = mysqli_real_escape_string($conn, $_POST['subj']);
        $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
        $credit = mysqli_real_escape_string($conn, $_POST['credit']);
        
        
        $createtableclass_query = "CREATE TABLE class_info_{$classcode}(
            class_id INT(11) PRIMARY KEY AUTO_INCREMENT,
            class_name VARCHAR(255),
            class_admin_id INT(11),
            class_admin_image VARCHAR(255),
            class_admin_name VARCHAR(255),
            class_section VARCHAR(255),
            class_subject VARCHAR(255),
            class_sched DATETIME,
            class_credit INT(11),
            class_code VARCHAR(255),
            class_image VARCHAR (255)
        );";

        mysqli_query($conn, $createtableclass_query);

        $createtableclass_members_query = "CREATE TABLE class_members_{$classcode}(
            members_id INT(11),
            members_name VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_members_query);

        $createtableclass_forum_query = "CREATE TABLE class_forum_{$classcode}(
            class_forum_id INT (11) PRIMARY KEY AUTO_INCREMENT, 
            class_forum_creator_id INT(11),
            class_forum_date VARCHAR(255),
            class_forum_creator_name VARCHAR(255),
            class_forum_content VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_forum_query);

        $createtableclass_forum_comments_query = "CREATE TABLE class_forum_comments_{$classcode}(
            class_forum_id INT (11),
            class_comment_id INT (11) PRIMARY KEY AUTO_INCREMENT,
            class_commenter_id INT(11),
            class_commenter_name VARCHAR(255),
            class_comment_date VARCHAR(255),
            class_comment VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_forum_comments_query);

        $createtableclass_modules_query = "CREATE TABLE class_file_{$classcode}(
            class_file_id INT(11) PRIMARY KEY AUTO_INCREMENT,
            class_file_unique_name VARCHAR(255),
            class_file_name VARCHAR(255),
            class_file_path VARCHAR(255),
            class_file_size VARCHAR(255),
            class_file_type VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_modules_query);

        $createtableclass_quiz_query = "CREATE TABLE class_quizzes_{$classcode}(
            quiz_id INT(11) PRIMARY KEY AUTO_INCREMENT,
            quiz_name VARCHAR(255),
            quiz_description VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_quiz_query);

        $createtableclass_assign_query = "CREATE TABLE class_assignments_{$classcode}(
                assign_id INT(11) PRIMARY KEY AUTO_INCREMENT,
                assign_date_created VARCHAR(255),
                assign_name VARCHAR(255),
                assign_description VARCHAR(255),
                assign_file_name VARCHAR(255),
                assign_file_unique_name VARCHAR(255),
                assign_file_path VARCHAR(255),
                assign_file_size VARCHAR(255),
                assign_file_type VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_assign_query);

        $createtableclass_assign_takers_query = "CREATE TABLE class_assignments_takers_{$classcode}(
            assign_id INT(11),
            assign_name VARCHAR(255),
            assign_taker_id INT(11),
            assign_taker_name VARCHAR(255),
            assign_date_passed VARCHAR(255),
            assign_file_name VARCHAR(255),
            assign_file_path VARCHAR(255),
            assign_file_size VARCHAR(255),
            assign_file_type VARCHAR(255),
            assign_taker_score INT(11)
        );";
        
        mysqli_query($conn, $createtableclass_assign_takers_query);

        $createtableclass_test_query = "CREATE TABLE class_tests_{$classcode}(
            test_id INT(11) PRIMARY KEY AUTO_INCREMENT,
            test_name VARCHAR(255),
            test_description VARCHAR(255)
        );";

        mysqli_query($conn, $createtableclass_test_query);

        $insertoclass_query = 
        
        "INSERT INTO class_info_{$classcode}
        (class_id, class_name, class_admin_id, class_admin_image, class_admin_name, class_section, class_subject, class_sched, class_credit, class_code, class_image)
        VALUES
        ('$class_id', '$classname', '{$_SESSION['id']}', '{$_SESSION['myimage']}', '{$_SESSION['fullname']}', '$section', '$subj', '$schedule', '$credit', '$classcode', 'img/headerimg.jpg');
        ";

            mysqli_query($conn, $insertoclass_query);

        $update_createdclasscount = "UPDATE acc_users SET created_class_count = created_class_count + 1 WHERE user_id = {$_SESSION['id']}";

            mysqli_query($conn, $update_createdclasscount);

        $insertownclass_query = "SELECT * FROM class_info_{$classcode}";
        $results = mysqli_query($conn, $insertownclass_query);
        
        if (mysqli_num_rows($results) == 1) {

            while($row=mysqli_fetch_assoc($results)){

                $updateclasses_query = 
                "INSERT INTO acc_classes (acc_class_id, acc_class_classname, acc_class_section, acc_class_admin_id, acc_class_admin_image, acc_class_admin, acc_class_code) 
                VALUES ('{$_SESSION['id']}', '{$row['class_name']}', '{$row['class_section']}', '{$row['class_admin_id']}', '{$row['class_admin_image']}', '{$row['class_admin_name']}', '{$classcode}');";
                mysqli_query($conn, $updateclasses_query);

                $inserttosched = 
                "INSERT INTO acc_sched (user_id, title, start_event, end_event) 
                VALUES ('{$_SESSION['id']}', '{$row['class_name']}', '{$row['class_sched']}', '{$row['class_sched']}')";
                mysqli_query($conn, $inserttosched);

            }

        }

        echo "
        <script>
            alert('success');
            window.location = 'main.php';
        </script>";
    }


    if(isset($_POST['join_class-btn']))
    {

        $joincode = mysqli_real_escape_string($conn, $_POST['joincode']);

        $checkmymembership = "SELECT * FROM class_members_{$joincode} WHERE members_id = '{$_SESSION['id']}'";
        $checkmymembership_run = mysqli_query($conn , $checkmymembership);

        if(mysqli_num_rows($checkmymembership_run) <= 0){

            $joinquery = 
            "INSERT INTO class_members_{$joincode}(members_id, members_name) 
            VALUES('{$_SESSION['id']}', '{$_SESSION['fullname']}'); 
            ";
                mysqli_query($conn, $joinquery);

            $updateclasscount_query = 
            "UPDATE acc_users SET joined_class_count = joined_class_count + 1 WHERE user_id = {$_SESSION['id']}";

                mysqli_query($conn, $updateclasscount_query);

            $getclassname_query = "SELECT * FROM class_info_{$joincode} WHERE class_code = '{$joincode}'";
            $results = mysqli_query($conn, $getclassname_query);

            if (mysqli_num_rows($results) == 1) {

                while($row=mysqli_fetch_assoc($results)){

                    $updateclasses_query = 
                    "INSERT INTO acc_classes (acc_class_id, acc_class_classname, acc_class_section, acc_class_admin_id, acc_class_admin_image, acc_class_admin, acc_class_code) 
                    VALUES ('{$_SESSION['id']}', '{$row['class_name']}', '{$row['class_section']}', '{$row['class_admin_id']}', '{$row['class_admin_image']}', '{$row['class_admin_name']}', '{$joincode}');";
                    mysqli_query($conn, $updateclasses_query);

                    $inserttosched = 
                    "INSERT INTO acc_sched (user_id, title, start_event, end_event) 
                    VALUES ('{$_SESSION['id']}', '{$row['class_name']}', '{$row['class_sched']}', '{$row['class_sched']}')";
                    mysqli_query($conn, $inserttosched);

                }
            }

            echo "
            <script>
                window.location = 'main.php';
            </script>";
        }else{

            echo "
            <script>
                window.location = 'main.php';
            </script>";

        }

    }
























?>