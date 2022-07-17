<?php
    include('backend/userlogin-register.php');
	include('backend/classconfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message with User</title>
    <link rel="stylesheet" href="styles/mainstyle.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>
<style>


    .main_content{

        width: calc(100% - 240px);
        left: 240px;
        background-color: #1d1b31;

    }

    .search_sidebar{
        
        position: absolute;
        width: 280px;
        min-height: 100vh;
        border-right: 1px solid rgb(0, 0, 0, 0.5);
        padding-right: 2rem;
        padding-left: 2rem;
        background-color: #fff;

    }

    .search_txtbox{

        position: relative;
        margin: 20px 0;
        display: flex;
        align-items: center;

    }

    .search_txtbox input{

        height: 42px;
        width: calc(100% - 50px);
        border: 1px solid #ccc;
        padding: 0 13px;
        font-size: 16px;
        border-radius: 5px 0 0 5px;
        outline: none;

    }

    .search_txtbox button{

        width: 47px;
        height: 42px;
        border: none;
        outline: none;
        color: #333;
        background: #fff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 17px;

    }

    .search_txtbox button.active{

        background: #333;
        color: #fff;

    }

    .search_txtbox button.active i::before{

        content: "\f00d";

    }

    .search_users{

        /* border: 1px solid red; */
        

    }

    .search_users_content{

 
        max-height: 100vh;
        overflow-y: auto;
        
    }

    :is(.search_users_content, .chat_box)::-webkit-scrollbar{

        width: 0px;
    }

    .search_users_content img{

        width: 50px;
        height: 50px;
        border-radius: 50%;
        
    }

    .search_users_content a{

        display: flex;
        align-items: center;
        color: #000;
        justify-content: space-between;
        padding: 1rem;
        text-decoration: none;
        border-radius: 12px;
        
    }

    .search_users_content a:hover{

        background: lightgray;

    }

    .search_users_details{

        display: flex;

    }

    .search_users_details_content{
        margin-left: 15px;
    }

    .search_users_details_content span{

        text-transform: capitalize;
        font-size: 16px;
        font-weight: bold;
    }

    .search_users_details_content p{

        font-size: 12px;
        color: gray;

    }

    .chat_area{

        position: absolute;
        width: calc(100% - 320px);
        left: 280px;
        background-color: #fff;
        min-height: 100vh;

    }

    .chat_area_header{

        border-bottom: 1px solid rgb(0, 0, 0, 0.5);
        padding: 1rem;
        display: flex;

    }

    .chat_area_header img{

        width: 80px;
        height: 80px;
        border-radius: 12px;

    }

    .chat_area_header span{

        font-size: 3.5rem;
        margin-left: 2rem;
        text-transform: capitalize;

    }

    .chat_area_header p{

        font-size: 2rem;
        margin-left: 2rem;
        text-transform: capitalize;
    }

    .chat_box{

        height: 570px;                              /* Adjust based on vh */
        padding: 10px 30px 20px 30px;
        overflow-y: auto;

    }

    .chat_box .chat p{

        word-wrap: break-word;
        padding: 8px 16px;

    }

    .chat_box .outgoing{

        display: flex;

    }

    .outgoing .chat_details{

        margin-left: auto;
        max-width: calc(100% - 230px);
    
    }

    .outgoing .chat_details p{

        background: #333;
        color: #fff;
        border-radius: 18px 18px 0 18px;

    }

    .chat_box .incoming{

        display: flex;
        align-items: flex-end;
        margin-left: -2rem;

    }

    .chat_box .incoming img{

        height: 65px;
        width: 65px;
        border-radius: 50%;

    }

    .incoming .chat_details{

        margin-left: 10px;
        max-width: calc(100% - 230px);
        

    }

    .incoming .chat_details p{

        background: lightgray;
        color: #333;
        border-radius: 18px 18px 18px 0;

    }

    .chat_area .chat_typing_area{
        padding: 18px 30px;
        display: flex;
        justify-content: space-between;
    }

    .chat_typing_area input{
        height: 45px;
        width: calc(100% - 58px);
        font-size: 17px;
        border: 1px solid #ccc;
        padding: 0 13px;
        border-radius: 5px 0 0 5px;
        outline: none;
    }

    .chat_typing_area button{

        width: 55px;
        border: none;
        outline: none;
        background: #333;
        color: #fff;
        font-size: 19px;
        cursor: pointer;
        border-radius: 0 5px 5px 0;


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
                    <img src="<?php echo $_SESSION['image'];?>" alt="profileImg">
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
        <div class="search_sidebar">
            <div class="search_header">
                <div class="search_txtbox">
                    <input type="text" placeholder="Search Users...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="search_users">
                <div class="search_users_content">

                </div>
            </div>
        </div>

        <div class="chat_area">
            <header>
                <?php 
                    $userid = mysqli_real_escape_string($conn, $_GET['user_id']);
                    $getuserinfo_query = "SELECT * FROM acc_users WHERE user_id = {$userid}";
                    $getuserinfo_results = mysqli_query($conn, $getuserinfo_query);
                    if(mysqli_num_rows($getuserinfo_results) > 0){
                        $getuserinfo_rows = mysqli_fetch_assoc($getuserinfo_results);
                    }
                ?>
                <div class="chat_area_header">
                    <img src="<?php echo $getuserinfo_rows['image']; ?>" alt="headerimg">
                    <div class="chat_area_header_details">
                        <span><?php echo $getuserinfo_rows['fullname']; ?></span>
                        <p><?php echo $getuserinfo_rows['status']; ?></p>
                    </div>
                </div>
            </header>
            
            <div class="chat_box">


            </div>

            <form action="#" class="chat_typing_area">
                <input type="hidden" name="outgoing_id" value="<?php echo $_SESSION['id']; ?>">
                <input type="hidden" name="incoming_id" value="<?php echo $userid; ?>">
                <input type="text" name="message" class="chat_field" placeholder="Type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
            
        </div>
        
    </div>
    
    <script>
    
        const searchBar = document.querySelector(".search_txtbox input"),
        searchIcon = document.querySelector(".search_txtbox button"),
        usersList = document.querySelector(".search_users_content");

        searchIcon.onclick = ()=>{
            searchIcon.classList.toggle("active");
            if(searchIcon.classList.contains("active") == true){
                searchBar.focus();
            }else{
                searchBar.blur();
            }
        }

        searchBar.onkeyup = ()=>{
            let searchTerm = searchBar.value;
                if(searchTerm != ""){
                    searchBar.classList.add("active");
                }else{
                    searchBar.classList.remove("active");
                }
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "backend/message_search_box.php", true);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                    let data = xhr.response;
                    usersList.innerHTML = data;
                    }
                }
            }
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("searchTerm=" + searchTerm);
        }

        setInterval(() =>{
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "backend/message_search_users.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                let data = xhr.response;
                    if(!searchBar.classList.contains("active")){
                        usersList.innerHTML = data;
                    }
                }
            }
        }
        xhr.send();
        }, 500);

    </script>
    <script src="js/chat.js"></script>

</body>
</html>