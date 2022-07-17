<?php 

    session_start();

    include('config.php');
    include('userlogin-register.php');

    $emptytext = "";

    if(isset($_POST['load_assign_data']))
	{

		$classcode = $_POST['classcode'];
		
		$getassigns_data = "SELECT * FROM class_assignments_{$classcode}";
		$getassigns_data_run = mysqli_query($conn, $getassigns_data);

		$array_result = [];

		if(mysqli_num_rows($getassigns_data_run) > 0)
		{

			foreach($getassigns_data_run as $row)
			{
                $assign_id = $row['assign_id'];
				$assign_takers = "SELECT * FROM class_assignments_takers_{$classcode} WHERE assign_id = '$assign_id' LIMIT 1";
				$assign_takers_run = mysqli_query($conn, $assign_takers);
                if(mysqli_num_rows($assign_takers_run) > 0){
                    $assign_takers_results = mysqli_fetch_array($assign_takers_run);
                }else{
                    $assign_takers_results = "";
                }
                
                array_push($array_result, ['assign'=>$row, 'takers'=>$assign_takers_results]);
				
			}
			header('Content-type: application/json');
			echo json_encode($array_result);

		}
		else
		{
			echo "Give me comments";
		}

	}

    if(isset($_POST['uploadbtn']) == "true")
    {

        $classcode = $_POST['classcode'];

        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        $assign_desc = mysqli_real_escape_string($conn, $_POST['assign_desc']);

        if(!empty($_POST['assign_file_name']) || !empty($_FILES['assign_file']['name'])){

            $assign_file_name = mysqli_real_escape_string($conn, $_POST['assign_file_name']);
            $date = date("F jS");

            $file_path = "../uploadedfiles/";
            $new_file_name = date("dmy") . time() . $_FILES["assign_file"]['name'];

            $file_name = $_FILES['assign_file']['name'];
            $file_temp = $_FILES['assign_file']['tmp_name'];
            $file_size = $_FILES['assign_file']['size'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_complete_path = "uploadedfiles/".$new_file_name;

            $file_size_string = "";

            if ($file_size >= 1073741824) {
                $file_size_string = number_format($file_size / 1073741824, 2) . ' GB';
            } elseif ($file_size >= 1048576) {
                $file_size_string = number_format($file_size / 1048576, 2) . ' MB';
            } elseif ($file_size >= 1024) {
                $file_size_string = number_format($file_size / 1024, 2) . ' KB';
            } elseif ($file_size > 1) {
                $file_size_string = $file_size . ' bytes';
            } elseif ($file_size == 1) {
                $file_size_string = $file_size . ' byte';
            } else {
                $file_size_string = '0 bytes';
            }

        }else{

            $assign_file_name = $emptytext;
            $date = date("F jS");

            $file_path = $emptytext = "";
            $new_file_name = $emptytext = "";

            $file_name = $emptytext = "";
            $file_temp = $emptytext = "";
            $file_size = $emptytext = "";
            $file_type = $emptytext = "";
            $file_complete_path = $file_path.$new_file_name;

            $file_size_string = "";
        }
        
        if ($file_size > 10485760) 
        {
            echo "<script>alert('File is too big. Limit is 10mb');</script>";
        }
        else 
        {
            $insert_file_query =
                "INSERT INTO class_assignments_{$classcode}(assign_date_created, assign_name, assign_description, assign_file_name, assign_file_unique_name, assign_file_path, assign_file_size, assign_file_type)
                VALUES('$date', '$assign_name', '$assign_desc', '$assign_file_name', '$new_file_name', '$file_complete_path', '$file_size_string', '$file_type');";

            mysqli_query($conn, $insert_file_query);
            move_uploaded_file($file_temp, $file_path . $new_file_name);
            // header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            // echo "<script>alert('success');location.reload();</script>";
        }
    }

    if(isset($_POST['edit_btn']) == "true")
    {

        $classcode = $_POST['classcode'];

        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);

        $getexistingfile_query = "SELECT * FROM class_assignments_{$classcode} WHERE assign_id = '$assign_id'";
        $getexistingfile_run = mysqli_query($conn, $getexistingfile_query);
        $getexistingfile_rows = mysqli_num_rows($getexistingfile_run);
        if ($getexistingfile_rows > 0) {
			while ($getexistingfile_rows = mysqli_fetch_array($getexistingfile_run)) {

				$file_path = $getexistingfile_rows['assign_file_path'];
                if($file_path != ''){
				    unlink('../'.$file_path);
                }
			}
		}

        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        $assign_desc = mysqli_real_escape_string($conn, $_POST['assign_desc']);

        if(!empty($_POST['assign_file_name']) || !empty($_FILES['assign_file']['name'])){

            $assign_file_name = mysqli_real_escape_string($conn, $_POST['assign_file_name']);
            $date = date("F jS");

            $file_path = "../uploadedfiles/";
            $new_file_name = date("dmy") . time() . $_FILES["assign_file"]['name'];


            $file_name = $_FILES['assign_file']['name'];
            $file_temp = $_FILES['assign_file']['tmp_name'];
            $file_size = $_FILES['assign_file']['size'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_complete_path = "uploadedfiles/".$new_file_name;

            $file_size_string = "";

            if ($file_size >= 1073741824) {
                $file_size_string = number_format($file_size / 1073741824, 2) . ' GB';
            } elseif ($file_size >= 1048576) {
                $file_size_string = number_format($file_size / 1048576, 2) . ' MB';
            } elseif ($file_size >= 1024) {
                $file_size_string = number_format($file_size / 1024, 2) . ' KB';
            } elseif ($file_size > 1) {
                $file_size_string = $file_size . ' bytes';
            } elseif ($file_size == 1) {
                $file_size_string = $file_size . ' byte';
            } else {
                $file_size_string = '0 bytes';
            }

        }
        else
        {
            $assign_file_name = $emptytext;
            $date = date("F jS");

            $file_path = $emptytext = "";
            $new_file_name = $emptytext = "";

            $file_name = $emptytext = "";
            $file_temp = $emptytext = "";
            $file_size = $emptytext = "";
            $file_type = $emptytext = "";
            $file_complete_path = $file_path.$new_file_name;

            $file_size_string = "";
        }
        
        if ($file_size > 10485760) 
        {
            echo "<script>alert('File is too big. Limit is 10mb');</script>";
        }
        else 
        {
            $update_file_query = 
            "UPDATE class_assignments_{$classcode}
                SET
                    assign_date_created = '$date',
                    assign_name = '$assign_name',
                    assign_description = '$assign_desc',
                    assign_file_name = '$assign_file_name',
                    assign_file_unique_name = '$new_file_name',
                    assign_file_path = '$file_complete_path',
                    assign_file_size = '$file_size_string',
                    assign_file_type = '$file_type'
                WHERE
                    assign_id = '$assign_id';";
            mysqli_query($conn, $update_file_query);
            move_uploaded_file($file_temp, $file_path . $new_file_name);
            // header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            echo "Success";
        }


    }

    if(isset($_POST['delete_btn']))
    {

        $classcode = $_POST['classcode'];
        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);

        $getassign_data = "SELECT * FROM class_assignments_{$classcode} WHERE assign_id = '$assign_id'";
        $getassign_run = mysqli_query($conn, $getassign_data);
        $getassign_num_rows = mysqli_num_rows($getassign_run);
        if ($getassign_num_rows > 0) {
			while ($getassign_rows = mysqli_fetch_array($getassign_run)) {
				$file_path = $getassign_rows['assign_file_path'];
                if($file_path != ''){
				    unlink('../'.$file_path);
                }
			}
		}

        $deleteassign_data = "DELETE FROM class_assignments_{$classcode} WHERE assign_id = '$assign_id'";
        mysqli_query($conn, $deleteassign_data);
        header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);

    }

    if(isset($_POST['upload_work']) == "true")
    {

        $classcode = $_POST['classcode'];

        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);
        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        
        $assign_taker_id = mysqli_real_escape_string($conn, $_POST['assign_taker_id']);
        $assign_taker_name = mysqli_real_escape_string($conn, $_POST['assign_taker_name']);

        $date = date("F jS");

        $file_path = "../uploadedfiles/";

        $file_name = $_FILES['work_file']['name'];
        $file_temp = $_FILES['work_file']['tmp_name'];
        $file_size = $_FILES['work_file']['size'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_complete_path = "uploadedfiles/".$file_name;

        $file_size_string = "";

        if ($file_size >= 1073741824) {
            $file_size_string = number_format($file_size / 1073741824, 2) . ' GB';
        } elseif ($file_size >= 1048576) {
            $file_size_string = number_format($file_size / 1048576, 2) . ' MB';
        } elseif ($file_size >= 1024) {
            $file_size_string = number_format($file_size / 1024, 2) . ' KB';
        } elseif ($file_size > 1) {
            $file_size_string = $file_size . ' bytes';
        } elseif ($file_size == 1) {
            $file_size_string = $file_size . ' byte';
        } else {
            $file_size_string = '0 bytes';
        }

        if ($file_size > 10485760) 
        {
            echo "<script>alert('File is too big. Limit is 10mb');</script>";
        }
        else 
        {
            $upload_assign_query =
                "INSERT INTO class_assignments_takers_{$classcode}(assign_id, assign_name, assign_taker_id, assign_taker_name, assign_date_passed, assign_file_name, assign_file_path, assign_file_size, assign_file_type, assign_taker_score)
                VALUES('$assign_id', '$assign_name', '$assign_taker_id', '$assign_taker_name', '$date', '$file_name', '$file_complete_path', '$file_size_string', '$file_type', 0);";

            mysqli_query($conn, $upload_assign_query);
            move_uploaded_file($file_temp, $file_path . $file_name);
        }


    }

    if(isset($_POST['upload_edit_work']) == "true")
    {

        $classcode = $_POST['classcode'];

        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);
        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        
        $assign_taker_id = mysqli_real_escape_string($conn, $_POST['assign_taker_id']);
        $assign_taker_name = mysqli_real_escape_string($conn, $_POST['assign_taker_name']);


        $checkmyassign = "SELECT assign_file_name, assign_file_path, assign_file_size, assign_file_type FROM class_assignments_takers_{$classcode} 
                        WHERE assign_id = '$assign_id' AND assign_name = '$assign_name' AND assign_taker_id = '$assign_taker_id' AND assign_taker_name = '$assign_taker_name'";
        $checkmyassign_run = mysqli_query($conn, $checkmyassign);
        $checkmyassign_num_rows = mysqli_num_rows($checkmyassign_run);

        if($checkmyassign_num_rows > 0){
            $checkmyassign_rows = mysqli_fetch_array($checkmyassign_run);
            $existing_file = $checkmyassign_rows['assign_file_path'];
            if($existing_file != ''){
                unlink('../'.$existing_file);
            }
        }

        $date = date("F jS");

        $file_path = "../uploadedfiles/";

        $file_name = $_FILES['work_file']['name'];
        $file_temp = $_FILES['work_file']['tmp_name'];
        $file_size = $_FILES['work_file']['size'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_complete_path = "uploadedfiles/".$file_name;

        $file_size_string = "";

        if ($file_size >= 1073741824) {
            $file_size_string = number_format($file_size / 1073741824, 2) . ' GB';
        } elseif ($file_size >= 1048576) {
            $file_size_string = number_format($file_size / 1048576, 2) . ' MB';
        } elseif ($file_size >= 1024) {
            $file_size_string = number_format($file_size / 1024, 2) . ' KB';
        } elseif ($file_size > 1) {
            $file_size_string = $file_size . ' bytes';
        } elseif ($file_size == 1) {
            $file_size_string = $file_size . ' byte';
        } else {
            $file_size_string = '0 bytes';
        }

        if ($file_size > 10485760) 
        {
            echo "<script>alert('File is too big. Limit is 10mb');</script>";
        }
        else 
        {
            $upload_edit_work ="UPDATE class_assignments_takers_{$classcode}
                                    SET
                                        assign_date_passed = '$date',
                                        assign_file_name = '$file_name',
                                        assign_file_path = '$file_complete_path',
                                        assign_file_size = '$file_size_string',
                                        assign_file_type = '$file_type',
                                        assign_taker_score = '0'
                                    WHERE
                                        assign_id = '$assign_id'
                                        AND
                                        assign_name = '$assign_name'
                                        AND
                                        assign_taker_id = '$assign_taker_id'
                                        AND
                                        assign_taker_name = '$assign_taker_name';";

            mysqli_query($conn, $upload_edit_work);
            move_uploaded_file($file_temp, $file_path . $file_name);
        }

    }


    if(isset($_POST['update_btn']))
    {

        $classcode = $_POST['classcode'];

        $assign_id = mysqli_real_escape_string($conn, $_POST['assign_id']);
        $assign_name = mysqli_real_escape_string($conn, $_POST['assign_name']);
        $assign_taker_id = mysqli_real_escape_string($conn, $_POST['assign_taker_id']);
        $assign_taker_name = mysqli_real_escape_string($conn, $_POST['assign_taker_name']);
        $assign_taker_score = mysqli_real_escape_string($conn, $_POST['asssign_taker_score']);

        $getmyassign = "SELECT * FROM class_assignments_takers_{$classcode} 
        WHERE assign_id = '$assign_id' AND assign_name = '$assign_name' AND assign_taker_id = '$assign_taker_id' AND assign_taker_name = '$assign_taker_name' LIMIT 1";
        $getmyassign_run = mysqli_query($conn, $getmyassign);
        $getmyassign_num_rows = mysqli_num_rows($getmyassign_run);

        if($getmyassign_num_rows > 0){

            $updatemyassign = "UPDATE class_assignments_takers_{$classcode}
                                    SET
                                        assign_taker_score = '$assign_taker_score'
                                    WHERE
                                        assign_id = '$assign_id'
                                        AND
                                        assign_name = '$assign_name'
                                        AND
                                        assign_taker_id = '$assign_taker_id'
                                        AND
                                        assign_taker_name = '$assign_taker_name';";
            mysqli_query($conn, $updatemyassign);
        }

    }




?>