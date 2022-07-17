<?php

    if(session_id() == '') {
        session_start();
    }
    
    include('config.php');
    include_once('functions.php');

    $image = "";
    $fname = "";
    $lname = "";
    $username = "";
    $email    = "";
    $number = "";
    $gender = "";
    $role = "";
    $errors = array();
    $gettheid = 0;
    

    if (isset($_POST['userregister_btn'])) {

		$fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $fullname = $fname." ".$lname;
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = mysqli_real_escape_string($conn, $_POST['phonenumber']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
        if(isset($_POST['gender']) || isset($_POST['role'])){
            $gender = $_POST['gender'];
            $role = $_POST['role'];
        }

        if(empty($fname) || empty($lname) || empty($username) || empty($email) || empty($number) || empty($password) || empty($gender) || empty($role)){
            array_push($errors, "All input Fields are Required");
        }else{
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){//if email is valid

                $user_check_query = "SELECT * FROM acc_pusers WHERE username='$username' OR email='$email' LIMIT 1";
                $result = mysqli_query($conn, $user_check_query);
                if(mysqli_num_rows($result) > 0){
                    array_push($errors, $email." - This email already exist!");
                }else{
                    if(isset($_FILES['image'])){
                        $img_name = $_FILES['image']['name'];
                        $tmp_name = $_FILES['image']['tmp_name'];

                        $img_explode = explode('.', $img_name);
                        $img_ext = end($img_explode);

                        $extensions = ['png', 'jpeg', 'jpg', 'PNG', 'JPEG', 'JPG'];
                        if(in_array($img_ext, $extensions) === true){
                            $time = time();
                            $new_img_name = $time.$img_name;
                            $image = "img/".$new_img_name;      //for db data
                            $target = "img/".$new_img_name;     //for move upload data
                            
                        }else{
                            array_push($errors, "Please select an Image File! - jpeg, jpg, png!");
                        }
                    }else{
                        array_push($errors, "Please select an Image File!");
                    }
                }
            }else{
                array_push($errors, $email." - This is not a valid Email!");
            }
        }

        if (count($errors) == 0) {

            $id = substr(md5(uniqid(mt_rand(), true)), 0, 3);
            $gettheid = $id;

            $query = "INSERT INTO acc_pusers (user_id, occupation, image, firstname, lastname, fullname, username, email, number, password, gender, created_class_count, joined_class_count, approval, status) VALUES('$gettheid', '$role', '$image', '$fname', '$lname', '$fullname', '$username', '$email', '$number', '$password', '$gender', '0', '0', 'PENDING', 'offline')";
            
            mysqli_query($conn, $query);
            move_uploaded_file($tmp_name, $target);
            echo "
                <script>
                    alert('success');
                    window.location = 'login.php';
                </script>";
            // echo $query;
        }


    }

    if (isset($_POST['userlogin_btn'])) {

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $admin_query = "SELECT * FROM acc_admin WHERE username = '$username' AND password = '$password'";
            $admin_results = mysqli_query($conn, $admin_query);
            $adminrows = mysqli_num_rows($admin_results);

            if(!empty($username) && !empty($password)){

                $approval_check_query = "SELECT * FROM acc_pusers WHERE username = '$username' AND password = '$password'";
                $result = mysqli_query($conn, $approval_check_query) or die(mysqli_error($conn));
                if(mysqli_num_rows($result) > 0){
                    array_push($errors, $username." user hasn't been approved yet");
                }else if($adminrows == 1){
                    $_SESSION['username'] = "Admin";
                    header('location: main.php');
                }else{
                    $check_users_username = "SELECT * FROM acc_users WHERE username = '$username'";
                    $check_users_username_result = mysqli_query($conn, $check_users_username);
                    if(mysqli_num_rows($check_users_username_result) > 0){
                        $check_users_password = "SELECT * FROM acc_users WHERE username = '$username' AND password = '$password'";
                        $check_users_password_result = mysqli_query($conn, $check_users_password);
                        if(mysqli_num_rows($check_users_password_result) > 0){
                            $get_user_info = "SELECT * FROM acc_users WHERE username='$username' AND password='$password' LIMIT 1";
                            $get_user_info_results = mysqli_query($conn, $get_user_info);
                            if (mysqli_num_rows($get_user_info_results) == 1) {
                                while($row=mysqli_fetch_assoc($get_user_info_results)){

                                    $_SESSION['id'] = $row['user_id'];
                                    $_SESSION['username'] = $username;
                                    $_SESSION['gender'] = $row['gender'];
                                    $_SESSION['image'] = $row['image'];
                                    $_SESSION['occupation'] = $row['occupation'];
                                    $_SESSION['fullname'] = $row['fullname'];
                                    $_SESSION['myimage'] = $row['image'];
            
                                    $settoactivenow_query = "UPDATE acc_users SET status = 'online' WHERE user_id = '{$_SESSION['id']}'";
                                    mysqli_query($conn, $settoactivenow_query);
            
                                }
                                header('location: main.php');
                            }else{
                                array_push($errors, "Something went Wrong");
                            }
                        }else{
                            array_push($errors, "Wrong Password");
                        }
                    }else{
                        array_push($errors, $username." user doesn't exist");
                        
                    }
                }
            }
            else{
                array_push($errors, "Username or Password can't be empty");
            }

    }

    if (isset($_POST['logout_btn'])) {

            if(isset($_SESSION['id'])){
            $settooffline_query = "UPDATE acc_users SET status = 'offline' WHERE user_id = '{$_SESSION['id']}'";
            $settooffline_query_result = mysqli_query($conn, $settooffline_query);
                if($settooffline_query_result){
                    session_destroy();
                    header("Refresh:0");
                }
            }else if(isset($_SESSION['username'])  == 'Admin'){
                session_destroy();
                header("Refresh:0");
            }

            
    }

?>