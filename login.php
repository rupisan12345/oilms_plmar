<?php
    include('backend/userlogin-register.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="styles/loginstyle.css">

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">

</head>
<body>

    <div class="container">
        <div class="icon">
            <img src="pageicon.png" alt="pageicon">
        </div>
        <div class="title">LearnOnMe</div>
        <form method="post" action="login.php">
            <?php include('backend/error.php'); ?>
            <div class="user-details">
                <div class="input-box">
                    <input type="text" name = "username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Password" required/>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                </div>
            </div>
            <div class="button">
                <input type="submit" name="userlogin_btn" value="Sign in">
            </div>
        </form>
        <div class="footer-text">
            <p>Don't have an Account? <a href="register.php">Click Here!</a></p>
        </div>
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
