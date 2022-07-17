<?php 

    include('backend/userlogin-register.php');

    if(isset($_GET['classcode'])){

        $classcode_id = $_GET['classcode'];
        $_SESSION['fclasscode_id'] = $classcode_id;
    }

    $classinfo_query = "SELECT * FROM class_info_{$classcode_id}";
    $access = mysqli_query($conn, $classinfo_query);
    $accessrows = mysqli_num_rows($access);

    $thisclass_adminid = "";
    $thisclass_name = "";

    if ($accessrows > 0){
        while($accessrecord=mysqli_fetch_array($access)){

            $thisclass_adminid = $accessrecord['class_admin_id'];
            $thisclass_name = $accessrecord['class_name'];
        }
    }

    if(isset($_POST['submit_quiz']))
    {

        $quizname = mysqli_real_escape_string($conn, $_POST['quizname']);
        $quizdescription = str_replace(' ', '', $quizname);

        $insertquizname_query = "INSERT INTO class_quizzes_{$classcode_id} (quiz_name, quiz_description) VALUES ('$quizname', '$quizdescription');";

        mysqli_query($conn, $insertquizname_query);

        $createquiztable_query = "CREATE TABLE {$quizdescription}_{$classcode_id}(
            quiz_id INT(11),
            quiz_question_id VARCHAR(255),
            quiz_question VARCHAR(255),
            quiz_option1 VARCHAR(255),
            quiz_option2 VARCHAR(255),
            quiz_option3 VARCHAR(255),
            quiz_option4 VARCHAR(255),
            quiz_answer VARCHAR(255)
        );";

        mysqli_query($conn, $createquiztable_query);

        $createquiztabletakers_query = "CREATE TABLE {$quizdescription}_{$classcode_id}_takers(
            student_id INT(11),
            fullname VARCHAR(255),
            score INT(11),
            date VARCHAR(255)
        );";

        mysqli_query($conn, $createquiztabletakers_query);

        $question1 = mysqli_real_escape_string($conn, $_POST['question_desc']);
        $question_id = str_replace(' ', '', $question1);

        $option1 = mysqli_real_escape_string($conn, $_POST['option1']);
        $option2 = mysqli_real_escape_string($conn, $_POST['option2']);
        $option3 = mysqli_real_escape_string($conn, $_POST['option3']);
        $option4 = mysqli_real_escape_string($conn, $_POST['option4']);
        $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer']);

        $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
        $quizinfo = mysqli_query($conn, $getquizid);
        
        if(mysqli_num_rows($quizinfo) > 0){
            while($infos=mysqli_fetch_assoc($quizinfo)){

                $qid = $infos['quiz_id'];  
                $insertQuestionAnswerquery = 
                "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                ;";
            }
        }
        mysqli_query($conn, $insertQuestionAnswerquery);

        if(isset($_POST['question_desc2'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc2']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option5']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option6']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option7']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option8']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer2']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);


        }

        if(isset($_POST['question_desc3'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc3']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option9']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option10']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option11']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option12']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer3']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc4'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc4']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option13']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option14']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option15']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option16']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer4']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc5'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc5']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option17']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option18']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option19']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option20']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer5']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc6'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc6']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option21']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option22']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option23']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option24']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer6']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc7'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc7']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option25']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option26']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option27']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option28']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer7']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc8'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc8']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option29']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option30']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option31']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option32']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer8']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc9'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc9']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option33']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option34']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option35']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option36']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer9']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        if(isset($_POST['question_desc10'])){

            $question1 = mysqli_real_escape_string($conn, $_POST['question_desc10']);
            $question_id = str_replace(' ', '', $question1);
            $option1 = mysqli_real_escape_string($conn, $_POST['option37']);
            $option2 = mysqli_real_escape_string($conn, $_POST['option38']);
            $option3 = mysqli_real_escape_string($conn, $_POST['option39']);
            $option4 = mysqli_real_escape_string($conn, $_POST['option40']);
            $option_answer = mysqli_real_escape_string($conn, $_POST['option_answer10']);

            $getquizid = "SELECT quiz_id FROM class_quizzes_{$classcode_id} WHERE quiz_description = '$quizdescription'";
            $quizinfo = mysqli_query($conn, $getquizid);

            if(mysqli_num_rows($quizinfo) > 0){
                while($infos=mysqli_fetch_assoc($quizinfo)){
    
                    $qid = $infos['quiz_id'];  
                    $insertQuestionAnswerquery = 
                    "INSERT INTO {$quizdescription}_{$classcode_id} (quiz_id, quiz_question_id, quiz_question, quiz_option1, quiz_option2, quiz_option3, quiz_option4, quiz_answer) 
                    VALUES('$qid', '$question_id', '$question1', '$option1', '$option2', '$option3', '$option4', '$option_answer')
                    ;";
                }
            }
            mysqli_query($conn, $insertQuestionAnswerquery);

        }

        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);

    }

    if(isset($_POST['quiz_btn']))
    {

        $quizname_db = mysqli_real_escape_string($conn, $_POST['quizname']);
        
        if(!isset($_SESSION['myquiztake'])){

            $_SESSION['myquiztake'] = $quizname_db;

        }else{
            unset($_SESSION['myquiztake']);
            $_SESSION['myquiztake'] = $quizname_db;
        }

        header('LOCATION: quizsection.php?id='.$classcode_id);

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $thisclass_name; ?> Quizzes</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="styles/mainstyle.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/workloadstyle.css">

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>

<style>

    .header2{

        position: relative;
        /* width: 1150px; */
        width: 1080px;
        height: 200px;
        left: 1%;
        top: 1%;

    }

    .header2 img{

        border-radius: 12px;
        width: 100%;
        height: 100%;

    }

    .header2 .header_content{

        position: absolute;
        top: 0;
        padding: 1rem 0 0 2rem;
        width: 100%;

    }

    .header2 .header_content h1{

        color: #fff;
        font-size: 4rem;

    }

    .header2 .header_content p{

        font-size: 3rem;

    }

    .header2 p.text2{

        position: absolute;
        bottom: 0;
        left: 2%;
        font-size: 2rem;
        color: #fff;

    }

    .quiz_content{

        margin: 2rem 0 0 1.5rem;
        font-size: 3rem;
        background-color: lightblue;
        border-radius: 12px;
        padding: 2rem;
        width: 96%;

    }

    .quiz_content .quiz_info_wrapper{

        display: flex;
        align-items: center;

    }

    .quiz_content .quiz_info_wrapper > div{

        margin: 1rem 0 1rem 0;

    }

    .quiz_content .quiz_info_wrapper .quiz_title{

        margin-left: 2rem;

    }

    .quiz_content .quiz_info_wrapper .quiz_title button{

        border: none;
        outline: none;
        background: transparent;
        text-transform: capitalize;

    }

    .quiz_content .quiz_info_wrapper .quiz_title button:hover{

        text-decoration: underline;
        cursor: pointer;

    }

    .quiz_content .quiz_info_wrapper .quiz_score{

        /* position: absolute;
        right: 0;
        transform: translateX(-50%); */

        position: absolute;
        right: 0;
        transform: translateX(-50%);

    }

    .main_content_btn{

        margin-top: 2rem;
        text-align: center;

    }

    .main_content_btn button{

        padding: 5px 1rem 5px 1rem;
        border: none;
        outline: none;
        background-color: #11101d;
        border-radius: 12px;
        color: #fff;
        transition: 0.2s all ease;
        font-size: 2.5rem;

    }

    .main_content_btn button:hover{

        background-color: #71b7e6;

    }


    .create_quiz_content{
        
        padding: 1rem;
        border-radius: 12px;
        font-size: 1.5rem;

    }

    .createquiz_form{

        border-radius: 12px;
        background-color: lightgray;
        padding: 1rem;
        margin-bottom: 1rem;
        font-size: 2rem;
    }


    .createquiz_form .quiz_name{

        text-align: center;
        margin-bottom: 1rem;

    }

    .createquiz_form .quiz_name p{

        margin: 0 0 5px 0;

    }

    .createquiz_form .questions_header{

        display: flex;
        align-items: center;
        margin: 1rem;

    }

    .createquiz_form .questions_header p{

        margin: 0 2rem 0 0;

    }


    .createquiz_form .quiz_options_wrapper{

        display: flex;
        flex-direction: column;

    }

    .createquiz_form .quiz_options_wrapper input[type = "text"]{

        width: auto;
    }

    .createquiz_form .quiz_options_wrapper .quiz_options{

        margin: 10px;

    }

    .createquiz_form .quiz_options_wrapper .quiz_options.answer{

        position: absolute;
        align-self: center;

    }

    .createquiz_form .submitquiz_btn{

        position: absolute;
        right: 0;
        transform: translateX(-30%);
        font-size: 2rem;
        padding: 5px 1rem 5px 1rem;
        border-radius: 12px;
        border: none;
        background-color: #11101d;
        color: #fff;

    }

    .createquiz_form .submitquiz_btn:hover{

        background-color: #71b7e6;
        color: #000;
    }

    .createquiz_form .addbtn{

        position: absolute;
        left: 0;
        transform: translateX(15%);
        border-radius: 12px;
        border: none;
        outline: none;
        padding: 5px 2rem 5px 2rem;
        background-color: #11101d;
        color: #fff;

    }

    .createquiz_form .addbtn:hover{

        background-color: #71b7e6;
        color: #000;
    }

    
</style>

<body>

    <div class="navbar_wrapper">
		<div class="navbar_logo-content">
			<div class="navbar_logo">
				<i class='bx bxl-github'></i>
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

        <div class="header">
			<p class="header_left">Task</p>
            <p class="header_title">Quizzes</p>
			<div class="header_btns">
				<div class="header_options">
					<button type="submit" class="btn quiz" style="border-color: #71b7e6;"><a href="folderquiz.php?classcode=<?php echo $classcode_id; ?>">Quiz</a></button>
				</div>
				<div class="header_options">
					<button type="submit" class="btn test"><a href='foldertest.php?classcode=<?php echo $classcode_id; ?>'>Test</a></button>
				</div>
				<div class="header_options">
					<button type="submit" class="btn assignment"><a href='folderassign.php?classcode=<?php echo $classcode_id; ?>'>Assignment</a></button>
				</div>
			</div>
		</div>

        <div class="header2">
			<?php

			$query = "SELECT * FROM class_info_{$classcode_id}";
			$results = mysqli_query($conn, $query);

			if(isset($results)){

				while($rows=mysqli_fetch_array($results)){

			?>

			<img src="<?php echo $rows['class_image']?>" alt="headerimg">

			<div class="header_content">
				<h1><?php echo $rows['class_name']; ?>
					<p><?php echo $rows['class_section']; ?></p>
				</h1>
			</div>

			<p class="text2">Class Code : <span><?php echo $rows['class_code']; ?></span> </p>

			<?php
	
					}

				}
			?>
		</div>
        

        <?php if($thisclass_adminid == $_SESSION['id']):?>
        <div class="main_content_btn">
            <button type="submit" id="createquizbtn" onclick="showquizform()">Create Quiz</button>
            <button class="view_quiz_takers_btn">View Takers</button>
        </div>
        <?php endif ?>

        <div class="create_quiz_content">
            <div class="createquiz_form">
                <button class="addbtn" onclick="duplicate()">Add Question</button>
                <form action="" method="post" >
                <input type="submit" class="submitquiz_btn" name="submit_quiz" value="Submit">
                <form action="" method="post" id="quizform">
                    <div class="quiz_name">
                        <p>Quiz Name</p>
                        <input type="text" name="quizname" placeholder="Quiz Name">
                    </div>
                    
                    <div id="questions_duplicator">
                        <div class="questions_header">
                            <p id="numberof_Q"></p>
                            <input type="text" class="question_desc" name="question_desc" placeholder="Question...">
                        </div>
                        <div class="quiz_options_wrapper">
                            <div class="quiz_options">
                                <label for="option1">Option 1</label>
                                <input type="text" class="option1" name="option1">
                            </div>
                            <div class="quiz_options">
                                <label for="option2">Option 2</label>
                                <input type="text" class="option2" name="option2">
                            </div>
                            <div class="quiz_options">
                                <label for="option3">Option 3</label>
                                <input type="text" class="option3" name="option3">
                            </div>
                            <div class="quiz_options">
                                <label for="option4">Option 4</label>
                                <input type="text" class="option4" name="option4">
                            </div>
                            <div class="quiz_options answer">
                                <label for="option_answer">Answer</label>
                                <input type="text" class="option_answer" name="option_answer" placeholder="Answer Content...">
                            </div>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>

        <div class="quiz_content">
            <div class="quiz_content_header" style="text-align: center;">
                Class Quizzes
            </div>
            <?php 
                $checkquizzes = "SELECT * FROM class_quizzes_{$classcode_id}";
                $checker = mysqli_query($conn, $checkquizzes);
                if($checker){
                    $verify = mysqli_num_rows($checker);
                    if($verify > 0){

                $getquizzes_query = "SELECT * FROM class_quizzes_{$classcode_id}";
                $quizzes_info = mysqli_query($conn, $getquizzes_query);
                $numofquizzes = mysqli_num_rows($quizzes_info);

                if($numofquizzes > 0){

                    while($quiztable_row=mysqli_fetch_array($quizzes_info)){       
            ?>
            <form action="" method="post">
            <div class="quiz_info_wrapper">
                <input type="hidden" name="quizname" value="<?php echo $quiztable_row['quiz_description']; ?>">
                <?php 
                    $getmyscore_query = "SELECT score FROM {$quiztable_row['quiz_description']}_{$classcode_id}_takers WHERE student_id = {$_SESSION['id']}";
                    $scores = mysqli_query($conn, $getmyscore_query);
                ?>
                <div class="quiz_icon"><i class="fa fa-thumb-tack icons"></i></div>
                <div class="quiz_title"><button type="submit" name="quiz_btn" <?php if(mysqli_num_rows($scores) == 1){ ?> disabled <?php } ?>><?php echo $quiztable_row['quiz_name'];?></button></div>
                <?php 
                    $checkclassadmin_query = "SELECT class_admin_id FROM class_info_{$classcode_id}";
                    $checkadmin_results = mysqli_query($conn, $checkclassadmin_query);
                    if(mysqli_num_rows($checkadmin_results) > 0){
                        while($checkadmin_rows = mysqli_fetch_assoc($checkadmin_results)){
                            if($_SESSION['id'] != $checkadmin_rows['class_admin_id']){

                    $getoverall_query = "SELECT * FROM {$quiztable_row['quiz_description']}_{$classcode_id}";
                    $overall_results = mysqli_query($conn, $getoverall_query);
                    $overall = mysqli_num_rows($overall_results);

                    if(mysqli_num_rows($scores) == 1):
                        while($myscore = mysqli_fetch_assoc($scores)){
                ?>
                <div class="quiz_score" style="transform: translateX(-40%);">Score: <?php echo $myscore['score']; ?>/<?php echo $overall; ?></div>
                <?php } else: ?>
                <div class="quiz_score">Untaken</div>
                <?php endif ?>
                <?php } } } ?>
            </div>
            </form>
            <?php 
                        }
                    }
                }
                
            ?>
        </div>
        <?php } ?>

        <div class="quiz_takers">
			<h3 class="title2" style="margin-left: 2rem;">Quiz Takers</h3>
			<br>
			<br>
			<div class="table-responsive">
				<table class="table table-bordered" style="width : 95% ; margin:auto;">
					<tr>
						<th>Quiz Name</th>
						<th>Quiz Taker Name</th>
						<th>Taker Score</th>
						<th>Quiz Date Passed</th>
					</tr>

                    <?php 

                    $checkquizzes = "SELECT * FROM class_quizzes_{$classcode_id}";
                    $checker = mysqli_query($conn, $checkquizzes);
                    if($checker){
                        $verify = mysqli_num_rows($checker);
                            if($verify > 0){

                                $quizzes_tablesearcher_row = mysqli_fetch_array($checker);
                    
                                $checktakers_tables = "SELECT * FROM {$quizzes_tablesearcher_row['quiz_description']}_{$classcode_id}_takers";
                                $checktakers_tables_run = mysqli_query($conn, $checktakers_tables);

                                if(mysqli_num_rows($checktakers_tables_run) > 0){

                                    while($checktakers_data = mysqli_fetch_array($checktakers_tables_run)){
                 
                    ?>
							<tr>
								<td style="text-transform:capitalize;"><?php echo $quizzes_tablesearcher_row['quiz_name']; ?></td>
								<td><?php echo $checktakers_data['fullname']; ?></td>
								<td><?php echo $checktakers_data['score']; ?></td>
								<td><?php echo $checktakers_data['date']; ?></td>
							</tr>

                    <?php 
                                    }
                                }

                                    }

                            }
                    ?>

				</table>
			</div>
		</div>

    </div>

    <script>

        var createquizform = document.querySelector(".createquiz_form");
        var quizform = document.querySelector('#quizform')
        var createquiz_btn = document.querySelector('#createquizbtn');

        var i = 1;      /* clone id */
        var nq = 1;     /* number of question */
        var qn = 1;     /* question name */

        var opt1no = 1;
        var opt2no = 2;
        var opt3no = 3;
        var opt4no = 4;

        var optansw = 1;

        var original = document.getElementById('questions_duplicator');
        var numberof_Q = document.getElementById('numberof_Q');
        numberof_Q.innerText = nq + ". ";

        function duplicate() {
            console.log(nq);
            if(nq <= 9){
                var clone = original.cloneNode(true); // "deep" clone
                clone.id = "questions_duplicator" + ++i;

                var q = clone.querySelector('#numberof_Q');
                nq += 1;
                q.innerText = nq + ". ";
   
                var qdesc = clone.querySelector('.question_desc');
                qn += 1;
                qdesc.setAttribute("name", "question_desc" + qn); 
                qdesc.value = "";


                var opt1 = clone.querySelector('.option1');
                opt1no += 4;
                opt1.setAttribute("name", "option" + opt1no);
                opt1.value = "";

                var opt2 = clone.querySelector('.option2');
                opt2no += 4;
                opt2.setAttribute("name", "option" + opt2no);
                opt2.value = "";
                
                var opt3 = clone.querySelector('.option3');
                opt3no += 4;
                opt3.setAttribute("name", "option" + opt3no);
                opt3.value = "";

                var opt4 = clone.querySelector('.option4');
                opt4no += 4;
                opt4.setAttribute("name", "option" + opt4no);
                opt4.value = "";

                var optans = clone.querySelector('.option_answer');
                optansw += 1;
                optans.setAttribute("name", "option_answer" + optansw);
                optans.value = "";

                original.parentNode.appendChild(clone);
                alert("Success");

            }else{
                alert("Maximum is 10 Question");
            }
            
        }

        hideform();

        function hideform (){

            $('.createquiz_form').hide();

        }

        function showquizform(){

            var quiz_content = $('.quiz_content');
            quiz_content.toggle();
            var quiz_form = $('.createquiz_form');
            quiz_form.toggle();

            if(createquiz_btn.innerHTML == "Create Quiz"){

                createquiz_btn.innerHTML = "Cancel";

            }else{
                createquiz_btn.innerHTML = "Create Quiz";
            }
            

            $('#quizform').children().slice(2).remove();
            i = 1;
            nq = 1;
            qn = 1;
            opt1no = 1;
            opt2no = 2;
            opt3no = 3;
            opt4no = 4;
            optansw = 1;
        }
	</script>

    <script src="js/folderquiz.js"></script>
    
</body>
</html>