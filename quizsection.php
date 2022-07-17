<?php 

    include('backend/userlogin-register.php');

    if(isset($_GET['id'])){

        $classcode_id = $_GET['id'];
    }

    $options1 = "";
    $options2 = "";
    $options3 = "";
    $options4 = "";
    $score = 0;
    
    $myanswer = '';


    if(isset($_POST['submitquiz']))
    {

        $getquizinfo = "SELECT * FROM {$_SESSION['myquiztake']}_{$classcode_id}";
        $res = mysqli_query($conn, $getquizinfo);
        $numofresults = mysqli_num_rows($res);
        $questionarray = [];
        $answerarray = [];
        if($numofresults > 0){
            while($questionsrow=mysqli_fetch_array($res)){

                array_push($questionarray, $questionsrow['quiz_question_id']);
                if(isset($questionarray[0])){
                    $question1 = $questionarray[0];
                }
                if(isset($questionarray[1])){
                    $question2 = $questionarray[1];
                }
                if(isset($questionarray[2])){
                    $question3 = $questionarray[2];
                }
                if(isset($questionarray[3])){
                    $question4 = $questionarray[3];
                }
                if(isset($questionarray[4])){
                    $question5 = $questionarray[4];
                }
                if(isset($questionarray[5])){
                    $question6 = $questionarray[5];
                }
                if(isset($questionarray[6])){
                    $question7 = $questionarray[6];
                }
                if(isset($questionarray[7])){
                    $question8 = $questionarray[7];
                }
                if(isset($questionarray[8])){
                    $question9 = $questionarray[8];
                }
                if(isset($questionarray[9])){
                    $question10 = $questionarray[9];
                }

                array_push($answerarray, $questionsrow['quiz_answer']);
                if(isset($answerarray[0])){
                    $answer1 = $answerarray[0];
                }
                if(isset($answerarray[1])){
                    $answer2 = $answerarray[1];
                }
                if(isset($answerarray[2])){
                    $answer3 = $answerarray[2];
                }
                if(isset($answerarray[3])){
                    $answer4 = $answerarray[3];
                }
                if(isset($answerarray[4])){
                    $answer5 = $answerarray[4];
                }
                if(isset($answerarray[5])){
                    $answer6 = $answerarray[5];
                }
                if(isset($answerarray[6])){
                    $answer7 = $answerarray[6];
                }
                if(isset($answerarray[7])){
                    $answer8 = $answerarray[7];
                }
                if(isset($answerarray[8])){
                    $answer9 = $answerarray[8];
                }
                if(isset($answerarray[9])){
                    $answer10 = $answerarray[9];
                }

            }
        }

        if(isset($question1)){
            $question1answer = mysqli_real_escape_string($conn, $_POST[$question1]);
        }
        if(isset($question2)){
            $question2answer = mysqli_real_escape_string($conn, $_POST[$question2]);
        }
        if(isset($question3)){
            $question3answer = mysqli_real_escape_string($conn, $_POST[$question3]);
        }
        if(isset($question4)){
            $question4answer = mysqli_real_escape_string($conn, $_POST[$question4]);
        }
        if(isset($question5)){
            $question5answer = mysqli_real_escape_string($conn, $_POST[$question5]);
        }
        if(isset($question6)){
            $question6answer = mysqli_real_escape_string($conn, $_POST[$question6]);
        }
        if(isset($question7)){
            $question7answer = mysqli_real_escape_string($conn, $_POST[$question7]);
        }
        if(isset($question8)){
            $question8answer = mysqli_real_escape_string($conn, $_POST[$question8]);
        }
        if(isset($question9)){
            $question9answer = mysqli_real_escape_string($conn, $_POST[$question9]);
        }
        if(isset($question10)){
            $question10answer = mysqli_real_escape_string($conn, $_POST[$question10]);
        }

        if(isset($question1answer) && !empty($answer1)){
            if($question1answer == $answer1){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question2answer) && !empty($answer2)){
            if($question2answer == $answer2){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question3answer) && !empty($answer3)){
            if($question3answer == $answer3){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question4answer) && !empty($answer4)){
            if($question4answer == $answer4){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question5answer) && !empty($answer5)){
            if($question5answer == $answer5){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question6answer) && !empty($answer6)){
            if($question6answer == $answer6){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question7answer) && !empty($answer7)){
            if($question7answer == $answer7){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question8answer) && !empty($answer8)){
            if($question8answer == $answer8){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question9answer) && !empty($answer9)){
            if($question9answer == $answer9){
                $score += 1;
            }else{
                $score = $score;
            }
        }
        if(isset($question10answer) && !empty($answer10)){
            if($question10answer == $answer10){
                $score += 1;
            }else{
                $score = $score;
            }
        }

        $date = date("F jS");
        $insertscore_query = 
        "INSERT INTO {$_SESSION['myquiztake']}_{$classcode_id}_takers (student_id, fullname, score, date)
        VALUES('{$_SESSION['id']}', '{$_SESSION['fullname']}', '$score', '$date');";

        mysqli_query($conn, $insertscore_query);
        header('LOCATION: folderquiz.php?classcode='.$classcode_id);



    }

    $edit_state = false;

    if(isset($_POST['editquiz'])){

        $edit_state = true;

    }

    if(isset($_POST['cancelquiz_admin'])){

        $edit_state = false;

    }

    if(isset($_POST['savequiz'])){

        $edit_state = false;

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['myquiztake'] ?></title>

    <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>

<style>

    body{

        background-color: #1d1b31;

    }

    .title{

        color: #fff;
        font-size: 2rem;
        text-align: center;
        letter-spacing: 5px;

    }

    .main_content{

        background-color: #1d1b31;
        border-radius: 12px;
        padding: 1.5rem;
        width: 50%;
        height: 50%;
        margin: 0 auto 0 auto;

    }

    .questionnaire_wrapper{

        border: 1px solid #71b7e6;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 0 0 1rem 0;
        text-align: center;

    }

    .questionnaire_wrapper .questions{

        font-size: 2rem;
        color: #fff;

    }

    .questionnaire_wrapper .quiz_options{

        display: table;
        margin: auto;
        border: 1px solid #71b7e6;
        border-radius: 12px;
        margin: 1rem auto 1rem auto;
        padding: 1rem;
        color: #fff;
        
    }

    .questionnaire_wrapper .quiz_options:hover{

        background-color: #71b7e6;
        color: #000;

    }

    .questionnaire_wrapper .quiz_options .quiz_options_wrapper{

        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .questionnaire_wrapper .quiz_options .quiz_options_wrapper p{

       margin: 0 1rem 0 1rem;

    }

    .main_content_btns{

        display: flex;
        justify-content: center;
        align-items: center;

    }

    .main_content_btns 
        .submitquiz_btn,
        .editquiz_btn,
        .savequiz_btn, 
        .cancelquiz_btn{

        font-size: 1.5rem;
        border-radius: 12px;
        outline: none;
        border: none;
        padding: 10px;
        margin: 0 1rem 0 1rem;
        width: 100px;
    }

</style>


<body>


    <div class="title"><?php echo $_SESSION['myquiztake']?></div>

    <?php echo $myanswer; ?>

    <!-- <?php echo $question2answer; ?>
    <?php echo $question3answer; ?>` -->


    <div class="main_content">
        <form action="" method="post">
        <?php 
        
            $getquiztable_query = "SELECT * FROM {$_SESSION['myquiztake']}_{$classcode_id}";
            $results = mysqli_query($conn, $getquiztable_query);
            $numofresults = mysqli_num_rows($results);

            if($numofresults > 0){

                while($questionsrow=mysqli_fetch_array($results)){   

        ?>
        
        <div class="quiz_form">
            <div class="questionnaire_wrapper">
                <div class="questions"><?php echo $questionsrow['quiz_question'];?></div>
                <input type="hidden" name="answer" value="<?php echo $questionsrow['quiz_answer']?>">
                <div class="quiz_options">
                    <div class="quiz_options_wrapper">
                        <input type="radio" name="<?php echo $questionsrow['quiz_question_id']; ?>" id="1" value="<?php echo $questionsrow['quiz_option1'];?>" required>
                        <p><?php echo $questionsrow['quiz_option1'];?></p>
                    </div>
                </div>
                <div class="quiz_options">
                    <div class="quiz_options_wrapper">
                        <input type="radio" name="<?php echo $questionsrow['quiz_question_id']; ?>" id="2" value="<?php echo $questionsrow['quiz_option2'];?>" required>
                        <p><?php echo $questionsrow['quiz_option2'];?></p>
                    </div>
                </div>
                <div class="quiz_options">
                    <div class="quiz_options_wrapper">
                        <input type="radio" name="<?php echo $questionsrow['quiz_question_id']; ?>" id="3" value="<?php echo $questionsrow['quiz_option3'];?>" required>
                        <p><?php echo $questionsrow['quiz_option3'];?></p>
                    </div>
                </div>
                <div class="quiz_options">
                    <div class="quiz_options_wrapper">
                        <input type="radio" name="<?php echo $questionsrow['quiz_question_id']; ?>" id="4" value="<?php echo $questionsrow['quiz_option4'];?>" required>
                        <p><?php echo $questionsrow['quiz_option4'];?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <?php 
                }

            }
        ?>

        <div class="main_content_btns">
            <?php 
                $checkadmin_query = "SELECT class_admin_id FROM class_info_{$classcode_id}";
                $checkadmin_results = mysqli_query($conn, $checkadmin_query);
                if(mysqli_num_rows($checkadmin_results) == 1){
                    while($checkadmin_rows = mysqli_fetch_assoc($checkadmin_results)){
                        if($_SESSION['id'] == $checkadmin_rows['class_admin_id']){
            ?>
                <?php if ($edit_state == true): ?>
                <input type="submit" name="savequiz" class="savequiz_btn" value="Save">
                <?php else: ?>
                <input type="submit" name="editquiz" class="editquiz_btn" value="Edit">
                <?php endif ?>
                <input type="submit" name="cancelquiz_admin" class="cancelquiz_btn" value="Cancel">
            <?php 
                        }else{
            ?>
            <input type="submit" name="submitquiz" class="submitquiz_btn" value="Submit">
            <?php
                        }
                    }
                }
            ?>
        </div>


        </form>
    </div>



    
</body>
</html>