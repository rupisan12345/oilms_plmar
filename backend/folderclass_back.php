<?php 

session_start();

include('config.php');
include('userlogin-register.php');

	if(isset($_POST['modal_image']))
	{

		$data = $_POST['modal_image'];
		$classcode = $_POST['classcode'];
		$image_array_1 = explode(";", $data);
		$image_array_2 = explode(",", $image_array_1[1]);
		$base64_decode = base64_decode($image_array_2[1]);
		$path_img = '../img/'.time().'.png';

		$imagename = ''.time().'.png';
		
		file_put_contents($path_img, $base64_decode); 

		$query = "SELECT * FROM class_info_{$classcode}";
		$results = mysqli_query($conn, $query);

		while($rows=mysqli_fetch_array($results)){

		$path = "../img/".basename($rows['class_image']);
		unlink($path);

		}
		
		$updateimg = 
		"UPDATE class_info_{$classcode} SET class_image = 'img/$imagename' WHERE class_code = '{$classcode}'";
		mysqli_query($conn, $updateimg);

	}

	if(isset($_POST['comment_load_data']))
	{

		$classcode = $_POST['classcode'];
		
		$comments_query = "SELECT * FROM class_forum_{$classcode}";
		$comments_query_run = mysqli_query($conn, $comments_query);

		$array_result = [];

		if(mysqli_num_rows($comments_query_run) > 0)
		{

			foreach($comments_query_run as $row)
			{
				$user_id = $row['class_forum_creator_id'];
				$user_query = "SELECT * FROM acc_users WHERE user_id = '$user_id' LIMIT 1";
				$user_query_run = mysqli_query($conn, $user_query);
				$user_result = mysqli_fetch_array($user_query_run);

				array_push($array_result, ['cmt'=>$row, 'user'=>$user_result]);
			}
			header('Content-type: application/json');
			echo json_encode($array_result);


		}
		else
		{
			echo "Give me comments";
		}

	}

	if(isset($_POST['view_comment_data']))
	{

			$forum_id = mysqli_real_escape_string($conn, $_POST['forum_id']);
			$classcode = $_POST['classcode'];

		$query = "SELECT * FROM class_forum_comments_{$classcode} WHERE class_forum_id = '$forum_id' ";
		$query_run = mysqli_query($conn, $query);

		$result_array = [];

		if(mysqli_num_rows($query_run) > 0)
		{

			foreach($query_run as $row)
			{
				$user_id = $row['class_commenter_id'];
				$user_query = "SELECT * FROM acc_users WHERE user_id = '$user_id' LIMIT 1";
				$user_query_run = mysqli_query($conn, $user_query);
				$user_result = mysqli_fetch_array($user_query_run);

				array_push($result_array, ['cmt'=>$row, 'user'=>$user_result]);
			}
			header('Content-type: application/json');
			echo json_encode($result_array);
				
		}
		else
		{
			echo "No Replies to this user";
		}

	}


	if(isset($_POST['add_reply']))
	{
		$classcode = $_POST['classcode'];

		$forum_id = mysqli_real_escape_string($conn, $_POST['forum_id']);
		$user_id = $_SESSION['id'];
		$fullname = $_SESSION['fullname'];
		$reply_date = mysqli_real_escape_string($conn, $_POST['reply_date']);
		$reply = mysqli_real_escape_string($conn, $_POST['reply_msg']);
		

		$query = "INSERT INTO class_forum_comments_{$classcode} (class_forum_id, class_commenter_id, class_commenter_name, class_comment_date, class_comment) VALUES ('$forum_id', '$user_id', '$fullname', '$reply_date', '$reply')";
		$query_run = mysqli_query($conn, $query);

		if($query_run)
		{
			echo "Comment Replied";
		}
		else
		{
			echo "Something went Wrong";
		}

	}


	if(isset($_POST['display_reply_info']))
	{

			$forum_id = mysqli_real_escape_string($conn, $_POST['forum_id']);
			$class_admin_image = $_POST['admin_image'];

		$query = "SELECT * FROM class_forum_comments_{$classcode} WHERE class_forum_id = '$forum_id' ";
		$query_run = mysqli_query($conn, $query);

		$result_array = [];

		if(mysqli_num_rows($query_run) > 0)
		{

			foreach($query_run as $row)
			{
				$user_id = $row['class_commenter_id'];
				$user_query = "SELECT * FROM acc_users WHERE user_id = '$user_id' LIMIT 1";
				$user_query_run = mysqli_query($conn, $user_query);
				$user_result = mysqli_fetch_array($user_query_run);

				array_push($result_array, ['cmt'=>$row, 'user'=>$user_result]);
			}
			header('Content-type: application/json');
			echo json_encode($result_array);
				
		}



	}

	if(isset($_POST['save_edit_btn']))
	{

		$classcode = $_POST['classcode'];

		$classname = mysqli_real_escape_string($conn, $_POST['classname']);
		$section = mysqli_real_escape_string($conn, $_POST['section']);
		$subject = mysqli_real_escape_string($conn, $_POST['subject']);
		$credit = mysqli_real_escape_string($conn, $_POST['credit']);
		$sched = mysqli_real_escape_string($conn, $_POST['sched']);

		$class_admin_id = mysqli_real_escape_string($conn, $_POST['class_admin_id']);

		$update_class_info = 
            "UPDATE class_info_{$classcode}
                SET
                    class_name = '$classname',
                    class_section = '$section',
                    class_subject = '$subject',
                    class_credit = '$credit',
                    class_sched = '$sched'
                WHERE
                    class_admin_id = '$class_admin_id';";
            mysqli_query($conn, $update_class_info);
	}

	if(isset($_POST['delete_class_btn']))
	{

		$classcode = $_POST['classcode'];

		$checkclass = "SELECT * FROM acc_classes WHERE acc_class_code = '$classcode'";
		$checkclass_run = mysqli_query($conn, $checkclass);
		if(mysqli_num_rows($checkclass_run) > 0){
			$deleteallclass = "DELETE FROM acc_classes WHERE acc_class_code = '$classcode'";
			mysqli_query($conn, $deleteallclass);
		}

		if($conn){
			$deleteclassdatabase = 
				"DROP TABLE IF EXISTS 
				class_assignments_{$classcode}, 
				class_assignments_takers_{$classcode},
				class_file_{$classcode}, 
				class_forum_comments_{$classcode}, 
				class_forum_{$classcode}, 
				class_info_{$classcode}, 
				class_members_{$classcode}, 
				class_quizzes_{$classcode}, 
				class_tests_{$classcode}
				;";
			mysqli_query($conn, $deleteclassdatabase);
		}
		

	}

	if(isset($_POST['delete_class_comment']))
	{

		$classcode = $_POST['classcode'];

		$comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);

		$check_comments = "SELECT * FROM class_forum_comments_{$classcode} WHERE class_forum_id = '$comment_id'";
		$check_comments_run = mysqli_query($conn, $check_comments);
		if(mysqli_num_rows($check_comments_run) > 0 ){

			$delete_comments = "DELETE FROM class_forum_comments_{$classcode} WHERE class_forum_id = '$comment_id'";
			mysqli_query($conn, $delete_comments);

		}

		$delete_post = "DELETE FROM class_forum_{$classcode} WHERE class_forum_id = '{$comment_id}'";
		mysqli_query($conn, $delete_post);
		
	}

	if(isset($_POST['leave_class_btn']))
	{

		$classcode = $_POST['classcode'];
		$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

		$check_membership = "SELECT * FROM class_members_{$classcode} WHERE members_id = '$user_id'";
		$check_membership_run = mysqli_query($conn, $check_membership);
		if(mysqli_num_rows($check_membership_run) > 0 ){

			$delete_membership = "DELETE FROM class_members_{$classcode} WHERE members_id = '$user_id'";
			mysqli_query($conn, $delete_membership);

		}

		$checkmyclass = "SELECT * FROM acc_classes WHERE acc_class_id = '{$user_id}' AND acc_class_code = '{$classcode}'";
		$checkmyclass_run = mysqli_query($conn, $checkmyclass);
		if(mysqli_num_rows($checkmyclass_run) > 0){

			$deletemyclass = "DELETE FROM acc_classes WHERE acc_class_id = '{$user_id}' AND acc_class_code = '{$classcode}'";
			mysqli_query($conn, $deletemyclass);

		}
		
	}


?>