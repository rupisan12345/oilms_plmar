<?php
    include('backend/userlogin-register.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="styles/registerstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">

</head>
<body>

    <div class="container">
    <div class="error-text">
        <?php include('backend/error.php'); ?>
    </div>
    <div class="title">Registration</div>
        <form action="register.php" method="POST" enctype="multipart/form-data" id="form">
        <input type="hidden" name="size" value="1000000 ">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">First Name</span>
                    <input type="text" name="fname" placeholder="Enter your First Name" >
                </div>
                <div class="input-box">
                    <span class="details">Last Name</span>
                    <input type="text" name="lname" placeholder="Enter your Last Name" >
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" name="username" placeholder="Enter your Username" >
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="email" name="email" placeholder="Enter your Email" >
                </div>
                <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input type="number" name="phonenumber" placeholder="Enter your Number" >
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" name="password" id="password" placeholder="Enter your Password" > 
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <div class="input img">
                    <span class="details img">Select Image</span>
                    <!-- <button style="display:block;width:120px; height:30px; cursor:pointer;" onclick="document.getElementById('getFile').click()">Choose File</button> -->
                    <input type='file' id="getFile" name="image" >
                </div>
            </div>
            <div class="choice-details">
                <input type="radio" name="gender" id="dot-1" value="Male" >
                <input type="radio" name="gender" id="dot-2" value="Female" >
                <input type="radio" name="gender" id="dot-3" value="Unspecified" >
                <input type="radio" name="role" id="dot-4" value="Student" >
                <input type="radio" name="role" id="dot-5" value="Professor" >

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
                <input type="submit" class ="register" name = "userregister_btn" value="Register">
                <input type="submit" formaction="login.php" id = 'backbtn' value="Back">
            </div>
        </form>
        
    </div>

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

</body>
</html>

