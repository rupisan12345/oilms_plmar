<?php
    include('backend/userlogin-register.php');
    include('backend/classconfig.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles/mainstyle.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">

    <link rel="stylesheet" type="text/css" href="tobeadded/Dashboard/Dashboard/css2/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <style type="text/css">
        
        .button{
            height: 45px;
            margin: -20px 0 20px 0;
        }

        .button input{
            height: 100%;
            width: 25%;
            outline: none;
            color: #fff;
            border: none;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            border-radius: 5px;
            background: #1d1b31;
            transition: all 0.3s ease;
        }

        .button input:hover{
            background: #71b7e6;
        }

        .slide-container{
            position:relative;
        }
        .slide img{
            width: 1100px;              /* Edit if a must */
            height: 473px;
        }




        .class_content{

            border-radius: 12px;
            padding: 2rem;
            z-index: 1;

        }

        .class_content .class_content_header{

            display: flex;
            flex-direction: column;

        }

        .class_content .class_content_header span{

            color: #000;
            font-size: 3rem;

        }

        .class_content .class_content_header a{

            color: red;
            font-size: 2rem;
            margin: -5px 0 2rem 0;

        }


        .class_content .my_classes{

            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            width: 100%;
            
        }

        .class_content_box {

            position: relative;
            background-color: #1d1b31;
            margin: 0 3rem 0 0;
            border-radius: 12px;
            padding: 2rem;

        }

        .class_content_box .class_content_info_header{

            display: flex;
            flex-direction: column;
            
        }

        .class_content_box .class_content_info_header h1{

            font-size: 3rem;
            text-transform: capitalize;
            color: #fff;

        }

        .class_content_box .class_content_info_header span{

            font-size: 2rem;
            text-transform: capitalize;
            color: #fff;

        }

        .class_content_box .class_content_info_header span i{

            margin-right: 1rem;

        }

        .class_content_box i{

            color: #fff;

        }

        .class_content_box  .class_content_info{

            display: grid;
            grid-template-columns: 1fr 1fr;
            font-size: 2rem;
            margin: 2rem 0 2rem 0;

        }

        .class_content_box  .class_content_info span{

            color: #fff;

        }

        .class_content_box  .class_content_info span i{

            margin-right: 1rem;

        }

        .class_content_box .class_content_footer a{

            color: #71b7e6;
            position: absolute;
            right: 0;
            transform: translate(-30%, -30%);
            font-size: 2rem;

        }

    </style>


</head>
<body>

<div class="body-wrapper" >
    
    <?php if(isset($_SESSION['username']) && $_SESSION['username'] != 'Admin'): ?>
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
    <?php else: ?>
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
                    <a href="#">
                        <i></i>
                        <span class="links_name">Pamantasan Ng</span>
                    </a>
                        <span class="tooltip">Pamantasan Ng</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">Lungsod Ng</span>
                    </a>
                        <span class="tooltip">Lungsod Ng</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">Marikina</span>
                    </a>
                        <span class="tooltip">Marikina</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">(PLMar)</span>
                    </a>
                        <span class="tooltip">(PLMar)</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">Learning</span>
                    </a>
                        <span class="tooltip">Learning</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">Management</span>
                    </a>
                        <span class="tooltip">Management</span>
                </li>

                <li>
                    <a href="#">
                        <i></i>
                        <span class="links_name">System</span>
                    </a>
                        <span class="tooltip">System</span>
                </li>

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
                            <div class="name"><?php echo $_SESSION['username'];?></div>
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
    <?php endif ?>

    <div class="main_content">
        
        <div class = "header">

            <div class="text">
                    <?php

                    if(isset($_SESSION['fullname'])){
                        echo "Hi, ".$_SESSION['fullname']."!";
                        echo "<div class='name_text'> Welcome back, nice to see you again!</div>";
                    }
                    else{
                        echo "Hello!";
                        echo "<div class='name_text'> Welcome to LearnOnMe!</div>";
                    }

                    ?>
            </div>

            <?php if(isset($_SESSION['username']) && $_SESSION['username'] != 'Admin'): ?>
            <div class = "dashboard_buttons">
                <div class = "dash_main">
                    <div class="dash_main-icon">
                        <i class='bx bx-plus-circle' id='dash' style="display: inline-block;"  ></i>
                        <i class='bx bx-x-circle' id='dash1' style="display: none;"></i>
                        <div class="dash_main_icon-tooltip">
                            <span> Create or Join Class <br> Contruct Room </span>
                        </div>
                    </div>

                        <div class="dash_main-btn" style="opacity: 0; pointer-events: none;">
                            <!-- <form action="main.php" method="POST"> -->
                                <div class="dash_main-buttons">
                                    <button type="submit" name="construct_room-btn" class="construct_room-btn">
                                        <span>Contruct Room</span>
                                    </button>
                                </div>
                                <div class="dash_main-buttons">
                                    <button type="submit" name="join_class-btn" class="join_class-btn">
                                        <span>Join Class</span>
                                    </button>
                                </div>
                                <div class="dash_main-buttons">
                                    <button type="submit" class="create_class-btn">
                                        <span>Create Class</span>
                                    </button>
                                </div>
                            <!-- </form> -->
                        </div>
                    
                </div>
            </div>
            <?php endif ?>

        </div>
        
        <div class="create_class_popup-box" style="display: none;">
            <div class="class_popup-wrapper createclass">
                <div class="class-header">Create Class</div>
                <form id="createclassform" action="main.php" method="POST">
                    <div class="class-inputs">
                        <label>Class Name</label>
                        <input type="text" name="classname" required>
                    </div>
                    <div class="class-inputs">
                        <label>Subject</label>
                        <input type="text" name="subj" required>
                    </div>
                    <div class="class-inputs">
                        <label>Section</label>
                        <input type="text" name="section" required>
                    </div>
                    <!-- <div class="class-inputs">
                        <label>Description</label>
                        <input type="text" name="description" required>
                    </div> -->
                    <div class="class-inputs">
                        <label>Credit</label>
                        <input type="number" name="credit" required>
                    </div>
                    <div class="class-inputs">
                        <label>Schedule</label>
                        <input type="datetime-local" name="schedule" required>
                    </div>

                    <div class="class_popup-btn_wrapper">
                        <div class="class_popup-btn">
                            <div class="inner"></div>
                            <button type="submit" class="createclass_cancel">Cancel</button>
                        </div>
                        <div class="class_popup-btn">
                            <div class="inner"></div>
                            <button type="submit"  name="create_class-btn" >Create</button>
                        </div>
                    </div>
                        
                </form>
            </div>
        </div>

        <div class="join_class_popup-box" style="display: none;">
            <div class="class_popup-wrapper joinclass">
                <div class="class-header">Join Class</div>
                <form id="joinclassform" action="main.php" method="POST">
                    <div class="class-inputs">
                        <label>Class Code</label>
                        <input type="text" name="joincode">
                    </div>

                    <div class="class_popup-btn_wrapper">
                        <div class="class_popup-btn">
                            <div class="inner"></div>
                            <button type="submit">Cancel</button>
                        </div>
                        <div class="class_popup-btn">
                            <div class="inner"></div>
                            <button type="submit"  name="join_class-btn" >Join</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="construct_room-box" style="display: none;">
            <div class="construct_room-wrapper">
                <div class="room_header">Construct Room</div>
                <div class="room_inputs">
                    <label>Enter or Create Room Code</label>
                    <input type="text" name="room_code" class="room_code">
                </div>
                <div class="room_popup-btn_wrapper">
                    <div class="room_popup-btn">
                        <div class="inner"></div>
                        <button type="submit" class="cancel_room">Cancel</button>
                    </div>
                    <div class="room_popup-btn">
                        <div class="inner"></div>
                        <button type="submit"  name="construct_room-btn" onclick="telcon()">Submit</button>
                    </div>
                </div>
                
            </div>
        </div>

        <?php if(!isset($_SESSION['username'])) : ?>
        
        <div class="hvm_wrapper">
            <div class="button">
                <input type="submit" class="history_btn" value="History">
                <input type="submit" class="vision_btn" value="Vision">
                <input type="submit" class="mission_btn" value="Mission">
            </div>

            <div class = "slide-container" style="display: block;">
                <div class="effect slide">
                    <img src="img/bg.jpg">
                </div>
                <div class="effect slide">
                    <img src="img/bg2.jpg">
                </div>
            </div>

            <div class="historywrapper" style="display: none;">
                <p style= "font-family:Arial Black;"> 
                To provide quality yet affordable tertiary education to the residents of Marikina, 
                the Pamantasan ng Lungsod ng Marikina (PLMar) was established through the initiative
                of then Mayor Ma.Lourdes C. Fernando under Ordinance No. 015, series of 2003.<br>
                <br>
                From the 1st one thousand four hundred twenty four (1,424) students in 2003, enrollment
                increases every year.<br>
                <br>
                To date, PLMar has produced graduates who passed the Professional Regulation Commission
                national board examinations for nurses, teachers, and criminologist, all surpassing the 
                national passing ratings.<br>
                <br>
                In keeping with its commitment to produce work-ready, career focused and community oriented 
                graduates, PLMar has been consistent in developing globally competitive graduates who land
                with good jobs in reputable companies and institutions here and abroad. Today PLMar gears
                its programs toward attaining them and help maintain Marikina as a vibrant community of 
                citizens who are proud of their roots and have mutual concern for the common good.<br> </p>
            </div>

            <div class="visionwrapper" style="display: none;">
                <p style = "font-family:Arial Black;">
                Pamantasan ng Lungsod ng Marikina (PLMar) is a progressive higher educational institution fostering 
                competent, compassionate and creative learning community dedicated to the pursuit of academic excellence, character formation,social responsibility and accountability. </p> </font>
            </div>

            <div class="missionwrapper" style="display: none;">
                <font size = "3" style = "font-family:Lucida Console; color:black;"> Pamantasan ng Lungsod ng Marikina (PLMar) is commited to:</h1></font>

                <p style = "font-family:Arial Black;">
                1. Provide accessible quality education, resources, opportunities and services for student development; 
                <br>
                2. Promote holistic approach in lifelong learning leading to better quality of life;
                <br>
                3. Build an empowered, resilient and supportive learning community of agents for positive change.<br> </p></font>
            </div>
        </div>
        <?php endif ?>

        <?php if(isset($_SESSION['username']) && $_SESSION['username'] != 'Admin'): ?>
        <div class="class_content">

            <?php 
                $check_classes = "SELECT * FROM acc_classes WHERE acc_class_id = '{$_SESSION['id']}'";
                $check_classes_result = mysqli_query($conn, $check_classes);
                $check_classes_result_rows = mysqli_num_rows($check_classes_result);

                    if ($check_classes_result_rows >= 1){
            ?>
            <div class="class_content_header">
                <span>My Classes</span>
                <a href="Class.php">See All<i class="fa fa-angle-double-right icons"></i></a>
            </div>
            <?php 
                    }
                else{
            ?>
            <div class="class_content_header">
                <span>No classes registered yet!</span>
            </div>
            <?php }?>
            
            <div class="my_classes">
                <?php 
                $getMyclasses = "SELECT * FROM acc_classes WHERE acc_class_id = '{$_SESSION['id']}'";
                $res = mysqli_query($conn, $getMyclasses);
                $numrows = mysqli_num_rows($res);

                    if ($numrows >= 1){
                        while($rows=mysqli_fetch_array($res)){
                ?>

                    <div class="class_content_box">
                        
                        <div class="class_content_info_header">
                            <h1><?php echo $rows['acc_class_classname']; ?></h1>
                            <span><i class="fa fa-user icons"></i><?php echo $rows['acc_class_admin']; ?></span>
                        </div>

                        <hr width="50;" size="6">

                        <?php 

                            $classcode_id = $rows['acc_class_code'];

                            $getclassmembers_query = "SELECT * FROM class_members_{$rows['acc_class_code']}";
                            $getclassmembers_results = mysqli_query($conn, $getclassmembers_query);
                            $getclassmembers_rows = mysqli_num_rows($getclassmembers_results);
                        
                        ?>

                        <?php 

                        $getclassinfo_query = "SELECT * FROM class_info_{$rows['acc_class_code']}";
                        $getclassinfo_results = mysqli_query($conn, $getclassinfo_query);

                        if(mysqli_num_rows($getclassinfo_results) > 0 ){
                            while($getclassinfo_rows = mysqli_fetch_assoc($getclassinfo_results)){
                        ?>

                            <div class="class_content_info">
                                <span><i class="fa fa-puzzle-piece icons"></i><?php echo $rows['acc_class_section']; ?></span>
                                <span><i class="fa fa-users icons"></i><?php echo $getclassmembers_rows; ?></span>
                            </div>

                            <div class="class_content_info">
                                <span><i class="fa fa-file-text icons"></i><?php echo $getclassinfo_rows['class_credit']?></span>
                                <span><i class="fa fa-clock-o icons"></i><?php echo $getclassinfo_rows['class_sched']?></span>
                            </div>

                        <?php 
                                }
                            }
                        ?>

                        <div class="class_content_footer">
                            <a href="folderclass.php?classcode=<?php echo $rows['acc_class_code'];?>">View</a>
                        </div>

                    </div>
                <?php 
                        }
                    }
                ?>
            </div>

        </div>
        <?php endif ?>

        <?php if(isset($_SESSION['username']) && $_SESSION['username'] == 'Admin'): ?>
            <h3 class="title2">User Accounts under approval</h3>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Id</th>
                        <th>Occupation</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Number</th>
                        <th>Password</th>
                        <th>Gender</th>
                        <th>Approval</th>
                        <th>Command</th>
                    </tr>
            <?php

                $users_query = "SELECT * FROM acc_pusers";
                $user_results = mysqli_query($conn, $users_query);

                if($user_results){
                    while($user_rows=mysqli_fetch_assoc($user_results)){

            ?>
                    <tr>
                        <td><?php echo $user_rows['user_id']; ?></td>
                        <td><?php echo $user_rows['occupation']; ?></td>
                        <td><?php echo $user_rows['firstname']; ?></td>
                        <td><?php echo $user_rows['lastname']; ?></td>
                        <td><?php echo $user_rows['fullname']; ?></td>
                        <td><?php echo $user_rows['username']; ?></td>
                        <td><?php echo $user_rows['email']; ?></td>
                        <td><?php echo $user_rows['number']; ?></td>
                        <td><?php echo $user_rows['password']; ?></td>
                        <td><?php echo $user_rows['gender']; ?></td>
                        <td style="text-align: center;"><?php echo $user_rows['approval']; ?></td>
                        <td style="text-align: center;"><?php echo "<a href='backend/user_approve.php?id=".$user_rows['user_id']."' style = 'text-decoration:none'>APPROVED</a>"; ?>
                        <?php echo "<a href='backend/user_reject.php?id={$user_rows['user_id']}' style = 'text-decoration:none'>REJECT</a>"; ?>
                        </td>

            <?php
                    }

                }
            ?>
                    </tr>

                </table>
            </div>
        <?php endif ?>
        
    </div> 
    
    <!-- Main content end div -->

</div>

</body>

    <script src="jsc.js"></script>
    <script type="text/javascript">
        
        function telcon(){

            var meeting_id = document.getElementsByClassName("room_code");
            window.location.href = "telcon.php?meeting_id=" + meeting_id[0].value;

        }

        const historybtn = document.querySelector('.history_btn');
        const visionbtn = document.querySelector('.vision_btn');
        const missionbtn = document.querySelector('.mission_btn');

        const historywrapper = document.querySelector('.historywrapper');
        const visionwrapper = document.querySelector('.visionwrapper');
        const missionwrapper = document.querySelector('.missionwrapper');
        const slides = document.querySelector('.slide-container');


        function showhistory(){

           if(historywrapper.style.display == 'none'){
                historywrapper.style.display = 'block';
                visionwrapper.style.display = 'none';
                missionwrapper.style.display = 'none';
                slides.style.display = 'none';
           }else{
                historywrapper.style.display = 'none';
                visionwrapper.style.display = 'none';
                missionwrapper.style.display = 'none';
                slides.style.display = 'block';
           }

        }

        function showvision(){

           if(visionwrapper.style.display == 'none'){
                visionwrapper.style.display = 'block';
                historywrapper.style.display = 'none';
                missionwrapper.style.display = 'none';
                slides.style.display = 'none';
           }else{
                historywrapper.style.display = 'none';
                visionwrapper.style.display = 'none';
                missionwrapper.style.display = 'none';
                slides.style.display = 'block';
           }

        }

        function showmission(){

           if(missionwrapper.style.display == 'none'){
                missionwrapper.style.display = 'block';
                visionwrapper.style.display = 'none';
                historywrapper.style.display = 'none';
                slides.style.display = 'none';
           }else{
                historywrapper.style.display = 'none';
                visionwrapper.style.display = 'none';
                missionwrapper.style.display = 'none';
                slides.style.display = 'block';
           }

        }

        historybtn.addEventListener('click', showhistory);
        visionbtn.addEventListener('click', showvision);
        missionbtn.addEventListener('click', showmission);

        var index=0;
        show();
        function show() {
        var i ;
        var slides=document.getElementsByClassName("slide");
        for(i=0; i<slides.length;i++){

            slides[i].style.display=" none";

        }
        index=index+1;
        if(index>slides.length){
        index=1;
        }
        slides[index-1].style.display="block";
        setTimeout(show,1000);
        }

        console.log("test");

    </script>
    <script>

        window.addEventListener("resize", windowmonitor);

        function windowmonitor(){

            var pageinnerw = window.innerWidth;
            var pageinnerh = window.innerHeight;

            if(pageinnerw <= 768){

                sidebar.classList.add('mobile');

            }else{

                sidebar.classList.remove('mobile');
            }


        }


    </script>


</html>