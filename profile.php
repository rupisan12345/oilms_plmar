<?php
    include('backend/userlogin-register.php');
	include('backend/classconfig.php');


    $edit_state = false;

    $image = "";
    $fname = "";
    $lname = "";
    $username = "";
    $email    = "";
    $number = "";
    $gender = "";
    $role = "";

    $oldimage = "";

    if(isset($_POST['editbtn'])){
        $edit_state = true;
    }

    if(isset($_POST['savebtn'])){

        $oldimage = mysqli_real_escape_string($conn, $_POST['oldimage']);
        $oldfname = mysqli_real_escape_string($conn, $_POST['oldfname']);
        $oldlname = mysqli_real_escape_string($conn, $_POST['oldlname']);
        $oldfullname = mysqli_real_escape_string($conn, $_POST['oldfullname']);
        $oldusername = mysqli_real_escape_string($conn, $_POST['oldusername']);
        $oldemail = mysqli_real_escape_string($conn, $_POST['oldemail']);
        $oldnumber = mysqli_real_escape_string($conn, $_POST['oldnumber']);
        $oldpassword = mysqli_real_escape_string($conn, $_POST['oldpassword']);

        if(mysqli_real_escape_string($conn, $_POST['fname']) == ''){
            $fname = $oldfname;
        }else{
            $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        }

        if(mysqli_real_escape_string($conn, $_POST['lname']) == ''){
            $lname = $oldlname;
        }else{
            $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        }

        if(isset($fname) && isset($lname)){
            $fullname = $fname." ".$lname;
        }else{
            $fullname = $oldfullname;
        }

        if(mysqli_real_escape_string($conn, $_POST['username']) == ''){
            $username = $oldusername;
        }else{
            $username = mysqli_real_escape_string($conn, $_POST['username']);
        }

        if(mysqli_real_escape_string($conn, $_POST['email']) == ''){
            $email = $oldemail;
        }else{
            $email = mysqli_real_escape_string($conn, $_POST['email']);
        }

        if(mysqli_real_escape_string($conn, $_POST['phonenumber']) == ''){
            $number = $oldnumber;
        }else{
            $number = mysqli_real_escape_string($conn, $_POST['phonenumber']);
        }

        if(mysqli_real_escape_string($conn, $_POST['password']) == ''){
            $password = $oldpassword;
        }else{
            $password = mysqli_real_escape_string($conn, $_POST['password']);
        }
        
        $gender = $_POST['gender'];
        $role = $_POST['role'];

        if($_FILES['image']['name'] == ''){
            $image = $oldimage;
        }else{
            $image = "img/".$_FILES['image']['name'];
            $target = "img/".basename($image);
        }

        $updateinfo_query = "UPDATE acc_users SET 
        occupation = '$role', image = '$image', firstname = '$fname', lastname = '$lname', fullname = '$fullname', username = '$username', email = '$email', number = '$number', password = '$password', gender = '$gender'
        WHERE user_id = '{$_SESSION['id']}'";

        $updateinfo_query_run = mysqli_query($conn, $updateinfo_query);

        if(isset($target)){
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        }

        $query = "SELECT * FROM acc_users WHERE user_id = '{$_SESSION['id']}'";
            /* acc_ausers */

			$results = mysqli_query($conn, $query);

                if (mysqli_num_rows($results) == 1) {

                    while($row=mysqli_fetch_assoc($results)){

                        $_SESSION['id'] = $row['user_id'];
                        $_SESSION['id2'] = $row['user_creator_id'];
                        $_SESSION['username'] = $username;
                        $_SESSION['gender'] = $row['gender'];
                        $_SESSION['image'] = $row['image'];
                        $_SESSION['occupation'] = $row['occupation'];
                        $_SESSION['fullname'] = $row['fullname'];
                        $_SESSION['myimage'] = $row['image'];

                    }
                }

        if($updateinfo_query_run){

            $checkclass = "SELECT * FROM acc_classes WHERE acc_class_id = '{$_SESSION['id']}'";
            $checkclass_run = mysqli_query($conn, $checkclass);

            if(mysqli_num_rows($checkclass_run) > 0)
            {
                $checkclass_data = mysqli_fetch_array($checkclass_run);

                $checkmynames = "SELECT * FROM class_members_{$checkclass_data['acc_class_code']} WHERE members_id = '{$_SESSION['id']}'";
                $checkmynames_run = mysqli_query($conn, $checkmynames);
                
                if(mysqli_num_rows($checkmynames_run) > 0)
                {
                    $checkmynames_data = mysqli_fetch_assoc($checkmynames_run);

                    $updatemyname = 
                    "UPDATE class_members_{$checkclass_data['acc_class_code']} 
                        SET 
                            members_name = '{$_SESSION['fullname']}'
                        WHERE
                            members_name = '{$checkmynames_data['members_name']}'";
                    mysqli_query($conn, $updatemyname);

                    $updatemyname_assignment = 
                    "UPDATE class_assignments_takers_{$checkclass_data['acc_class_code']} 
                        SET 
                            assign_taker_name = '{$_SESSION['fullname']}'
                        WHERE
                            assign_taker_name = '{$checkmynames_data['members_name']}'";
                    
                    mysqli_query($conn, $updatemyname_assignment);

                    $updatemyname_forum = 
                    "UPDATE class_forum_{$checkclass_data['acc_class_code']} 
                        SET 
                            class_forum_creator_name = '{$_SESSION['fullname']}'
                        WHERE
                            class_forum_creator_name = '{$checkmynames_data['members_name']}'";
                    mysqli_query($conn, $updatemyname_forum);

                    $updatemyname_comments = 
                    "UPDATE class_forum_comments_{$checkclass_data['acc_class_code']} 
                        SET 
                            class_commenter_name = '{$_SESSION['fullname']}'
                        WHERE
                        class_commenter_name = '{$checkmynames_data['members_name']}'";
                    mysqli_query($conn, $updatemyname_comments);

                    $checkquizzes = "SELECT * FROM class_quizzes_{$checkclass_data['acc_class_code']}";
                    $checkquizzes_run = mysqli_query($conn, $checkquizzes);

                    if(mysqli_num_rows($checkquizzes_run))
                    {

                        $checkquizzes_data = mysqli_fetch_assoc($checkquizzes_run);

                        $checkmyname_quizzes = 
                        "SELECT * FROM {$checkquizzes_data['quiz_description']}_{$checkclass_data['acc_class_code']}_takers
                            WHERE fullname = '{$checkmynames_data['members_name']}'";
                        $checkmyname_quizzes_run = mysqli_query($conn, $checkmyname_quizzes);
                        
                        if(mysqli_num_rows($checkmyname_quizzes_run) > 0)
                        {
                            $updatemyname_quizzes = 
                            "UPDATE {$checkquizzes_data['quiz_description']}_{$checkclass_data['acc_class_code']}_takers
                            SET 
                                fullname = '{$_SESSION['fullname']}'
                            WHERE
                            fullname = '{$checkmynames_data['members_name']}'";
                            mysqli_query($conn, $updatemyname_quizzes);
                        }
                        
                    }

                    $checktests= "SELECT * FROM class_tests_{$checkclass_data['acc_class_code']}";
                    $checktests_run = mysqli_query($conn, $checktests);

                    if(mysqli_num_rows($checktests_run))
                    {

                        $checktests_data = mysqli_fetch_assoc($checktests_run);

                        $checkmyname_tests = 
                        "SELECT * FROM {$checktests_data['test_description']}_{$checkclass_data['acc_class_code']}_takers
                            WHERE fullname = '{$checkmynames_data['members_name']}'";
                        $checkmyname_tests_run = mysqli_query($conn, $checkmyname_tests);
                        
                        if(mysqli_num_rows($checkmyname_tests_run) > 0)
                        {
                            $updatemyname_tests = 
                            "UPDATE {$checktests_data['test_description']}_{$checkclass_data['acc_class_code']}_takers
                            SET 
                                fullname = '{$_SESSION['fullname']}'
                            WHERE
                            fullname = '{$checkmynames_data['members_name']}'";
                            mysqli_query($conn, $updatemyname_tests);
                        }
                    }

                }



            }


        }

        $edit_state = false;
        header('location: profile.php');

    }

    if(isset($_POST['cancelbtn'])){

        $edit_state = false;

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/mainstyle.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="styles/registerstyle.css">
    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>


<style>

    body{

        display: flex;
        height: 100vh;
        justify-content: center;
        align-items: center;
        padding: 10px;
        background: lightblue;

    }

    .container{

        position: relative;
        max-width: 700px;
        width: 100%;
        background: #11101d;
        padding: 25px 30px;
        border-radius: 5px;
        margin-top: 5rem;

    }

    .container .title{

        color: #fff;

    }

    .container .container_img img{

        width: 120px;
        height: 120px;
        border-radius: 50%;
        position: absolute;
        right: 0;
        top: 0;
        transform: translate(10%, -20%);


    }

    .container span{

        color: #fff;

    }

    .container input[type = "file"]{

        color: #fff;

    }

    .user-details .input-box i{

        transform: translate(-30px, 3px);
        
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {

        -webkit-appearance: none;
    
    }

    .input-box .details_info{

        font-size: 2rem;
        margin-left: 1rem;

    }

    .input-box input.currentpassword{

        background-color: transparent;
        border: none;
        outline: none;
        color: #fff;

    }

    .gender-wrapper .mygender,
    .role-wrapper .myrole{

        margin: 2rem;
        text-align: center;

    }

    .gender-wrapper .mygender span,
    .role-wrapper .myrole span{

        font-size: 2rem;
        
        

    }

    form .button.edit{

        justify-content: center;

    }



</style>

<body>

    <div class="navbar_wrapper">
        <div class="navbar_logo-content">
            <div class="navbar_logo">
                <img src="pageicon.png" alt="pageicon">
                <div class="logo_name">LMS</div>
            </div>
                <i class='bx bx-menu' id='btn' > </i>
                <i class='bx bx-window-close' id='btn1' > </i>
        </div>

        <ul class="navbar_list">
            
            <li>
                <a href="main.php">
                    <i class='bx bx-grid-alt' ></i>
                    <span class="links_name">Dashboard</span>
                </a>
                    <span class="tooltip">Dashboard</span>
            </li>
            <?php if(isset($_SESSION['username'])): ?>
            <li>
                <a href="profile.php">
                    <i class='bx bx-user' ></i>
                    <span class="links_name">Profile</span>
                </a>
                    <span class="tooltip">Profile</span>
            </li>

            <li>
                <a href="message.php">
                    <i class='bx bx-chat' ></i>
                    <span class="links_name">Message</span>
                </a>
                    <span class="tooltip">Message</span>
            </li>

            <li>
                <a href="class.php">
                    <i class='bx bx-briefcase' ></i>
                    <span class="links_name">Class</span>
                </a>
                    <span class="tooltip">Class</span>
            </li>

            <li>
                <a href="schedule.php">
                    <i class='bx bx-calendar' ></i>
                    <span class="links_name">Schedule</span>
                </a>
                    <span class="tooltip">Schedule</span>
            </li>

            <li>
                <a href="workload.php">
                    <i class='bx bx-notepad'></i>
                    <span class="links_name">Workload</span>
                </a>
                    <span class="tooltip">Workload</span>
            </li>
            <?php endif ?>
        </ul>

        <?php if(empty($_SESSION['username'])): ?>
            <div class="log_section">
                <div class="log_content">
                    <div class="log_content-wrap">
                        <div class="log_btn"><a href="register.php">Sign Up</a></div>
                        <div class="log_btn"><a href="login.php">Sign In</a></div>
                    </div>
                        <i class='bx bx-log-out' id="log_icon" ></i>
                </div>
            </div>
        <?php else: ?>
            <div class="profile">
                <div class="profile-details">
                    <?php if($_SESSION['username'] != 'Admin'): ?>
                    <img src="<?php echo $_SESSION['image'];?>" alt="profileImg">
                    <?php endif ?>
                    <div class="name_job">
                        <div class="name"><?php echo $_SESSION['fullname'];?></div>
                        <div class="job"><?php echo $_SESSION['occupation'];?></div>
                    </div>
                </div>
                <form action="main.php" method="post">
                    <button type="submit" name="logout_btn">
                        <i class='bx bx-log-out' id="log_out"></i>
                    </button>
                </form>
            </div>
        <?php endif ?>

    </div>


    <div class="main_content">
        
            
            <?php 

                if(isset($_SESSION['id'])){
                $getmyinfo_query = "SELECT * FROM acc_users WHERE user_id = {$_SESSION['id']}";
                $getmyinfo_results = mysqli_query($conn, $getmyinfo_query);

                    if(mysqli_num_rows($getmyinfo_results) > 0){

                        while($getmyinfo_rows = mysqli_fetch_array($getmyinfo_results)){
            ?>

                <?php if($edit_state == false): ?>
                    <div class="container">
                        <div class="title">Information</div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="size" value="1000000 ">
                            <div class="container_img">
                                <img src="<?php echo $getmyinfo_rows['image']; ?>" alt="myimg">
                            </div>
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">First Name</span>
                                    <span class="details_info"><?php echo $getmyinfo_rows['firstname']; ?></span>
                                </div>
                                <div class="input-box">
                                    <span class="details">Last Name</span>
                                    <span class="details_info"><?php echo $getmyinfo_rows['lastname']; ?></span>
                                </div>
                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <span class="details_info"><?php echo $getmyinfo_rows['username']; ?></span>
                                </div>
                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <span class="details_info"><?php echo $getmyinfo_rows['email']; ?></span>
                                </div>
                                <div class="input-box">
                                    <span class="details">Phone Number</span>
                                    <span class="details_info"><?php echo $getmyinfo_rows['number']; ?></span>
                                </div>
                                <div class="input-box">
                                    <span class="details">Password</span>
                                    <input type="password" id="password" class="currentpassword" value="<?php echo $getmyinfo_rows['password']; ?>"> 
                                    <i class="bi bi-eye-slash" id="togglePassword" style="color: #fff;"></i>
                                </div>
                            </div>
                            <div class="choice-details">
                                <div class="choice-wrapper">
                                    <div class="gender-wrapper">
                                        <div class="choice-title">
                                            <span class="gender-title">Gender</span>
                                        </div>
                                        <div class="mygender">
                                            <span><?php echo $getmyinfo_rows['gender']; ?></span>
                                        </div>
                                    </div>

                                    <div class="role-wrapper">
                                        <div class="choice-title">
                                            <span class="role-title">Role</span>
                                        </div>
                                        <div class="myrole">
                                            <span><?php echo $getmyinfo_rows['occupation']; ?></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button edit">
                                <input type="submit" name = "editbtn" value="Edit">
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="container">
                        <div class="title">Information</div>
                        <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="size" value="1000000 ">
                        <input type="hidden" name = "oldfullname" value="<?php echo $getmyinfo_rows['fullname']; ?>">
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">First Name</span>
                                    <input type="hidden" name = "oldfname" value="<?php echo $getmyinfo_rows['firstname']; ?>">
                                    <input type="text" name="fname" placeholder="Enter your First Name" required value="<?php echo $getmyinfo_rows['firstname']; ?>">
                                </div>
                                <div class="input-box">
                                    <span class="details">Last Name</span>
                                    <input type="hidden" name = "oldlname" value="<?php echo $getmyinfo_rows['lastname']; ?>">
                                    <input type="text" name="lname" placeholder="Enter your Last Name" required value="<?php echo $getmyinfo_rows['lastname']; ?>">
                                </div>
                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="hidden" name = "oldusername" value="<?php echo $getmyinfo_rows['username']; ?>">
                                    <input type="text" name="username" placeholder="Enter your Username" required value="<?php echo $getmyinfo_rows['username']; ?>">
                                </div>
                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="hidden" name = "oldemail" value="<?php echo $getmyinfo_rows['email']; ?>">
                                    <input type="email" name="email" placeholder="Enter your Email" required value="<?php echo $getmyinfo_rows['email']; ?>">
                                </div>
                                <div class="input-box">
                                    <span class="details">Phone Number</span>
                                    <input type="hidden" name = "oldnumber" value="<?php echo $getmyinfo_rows['number']; ?>">
                                    <input type="number" name="phonenumber" placeholder="Enter your Number" required value="<?php echo $getmyinfo_rows['number']; ?>">
                                </div>
                                <div class="input-box">
                                    <span class="details">Password</span>
                                    <input type="hidden" name = "oldpassword" value="<?php echo $getmyinfo_rows['password']; ?>">
                                    <input type="password" name="password" id="password" placeholder="Enter your Password" required value="<?php echo $getmyinfo_rows['password']; ?>"> 
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                </div>
                                <div class="input img">
                                    <span class="details img">Select Image</span>
                                    <input type="hidden" name = "oldimage" value="<?php echo $getmyinfo_rows['image']; ?>">
                                    <!-- <button style="display:block;width:120px; height:30px; cursor:pointer;" onclick="document.getElementById('getFile').click()">Choose File</button> -->
                                    <input type='file' id="getFile" name="image">
                                </div>
                            </div>
                            <div class="choice-details">
                                <input type="hidden" name="oldgender" value="<?php echo $getmyinfo_rows['gender']; ?>">

                                <input type="radio" name="gender" id="dot-1" value="Male" <?php if($getmyinfo_rows['gender'] == 'Male'){ ?> checked <?php } ?>>
                                <input type="radio" name="gender" id="dot-2" value="Female" <?php if($getmyinfo_rows['gender'] == 'Female'){ ?> checked <?php } ?>>
                                <input type="radio" name="gender" id="dot-3" value="Unspecified" <?php if($getmyinfo_rows['gender'] == 'Unspecified'){ ?> checked <?php } ?>>
                                <input type="radio" name="role" id="dot-4" value="Student" <?php if($getmyinfo_rows['occupation'] == 'Student'){ ?> checked <?php } ?>>
                                <input type="radio" name="role" id="dot-5" value="Professor" <?php if($getmyinfo_rows['occupation'] == 'Professor'){ ?> checked <?php } ?>>

                                <div class="choice-wrapper">
                                    <div class="gender-wrapper">
                                        <div class="choice-title">
                                            <span class="gender-title">Gender</span>
                                        </div>
                                        <div class="gender-category">
                                            <label for="dot-1">
                                                <span class="dot one"></span>
                                                <span class="gender">Male</span>
                                            </label>
                                            <label for="dot-2">
                                                <span class="dot two"></span>
                                                <span class="gender">Female</span>
                                            </label>
                                            <label for="dot-3">
                                                <span class="dot three"></span>
                                                <span class="gender">Prefer not to Say</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="role-wrapper">
                                        <div class="choice-title">
                                            <span class="role-title">Role</span>
                                        </div>
                                        <div class="role-category">
                                            <label for="dot-4">
                                                <span class="dot four"></span>
                                                <span class="role">Student</span>
                                            </label>
                                            <label for="dot-5">
                                                <span class="dot five"></span>
                                                <span class="role">Professor</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="button">
                                <input type="submit" name = "savebtn" value="Save">
                                <input type="submit" name = "cancelbtn" value="Cancel">
                            </div>
                        </form>
                    </div>
                <?php endif ?>

            <?php 
                        }
                    }

                }
            ?>
    </div>
    

</body>

    <script>

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('bi-eye');
        });

    </script>

</html>