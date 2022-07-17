<?php

	include('backend/userlogin-register.php');

	if (isset($_GET['classcode'])) {

		$classcode_id = $_GET['classcode'];
		$_SESSION['fclasscode_id'] = $classcode_id;
	}

	$classinfo_query = "SELECT * FROM class_info_{$classcode_id}";
	$access = mysqli_query($conn, $classinfo_query);
	$accessrows = mysqli_num_rows($access);

	$thisclass_adminid = "";
	$thisclass_name = "";

	if ($accessrows > 0) {
		while ($accessrecord = mysqli_fetch_array($access)) {

			$thisclass_adminid = $accessrecord['class_admin_id'];
			$thisclass_name = $accessrecord['class_name'];
		}
	}

	$edit_state = false;

	$edit_state_takers = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<title><?php echo $thisclass_name; ?></title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<link rel="stylesheet" href="styles/mainstyle.css">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles/workloadstyle.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css">

	<link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>

<style>

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {

		-webkit-appearance: none;

	}

	/* Header Img */

			.header2 {

				position: relative;
				/* width: 1150px; */
				width: 1080px;
				height: 200px;
				left: 1%;
				top: 1%;

			}

			.header2 img {

				border-radius: 12px;
				width: 100%;
				height: 100%;

			}

			.header2 .header_content {

				position: absolute;
				top: 0;
				padding: 1rem 0 0 2rem;
				width: 100%;

			}

			.header2 .header_content h1 {

				color: #fff;
				font-size: 4rem;

			}

			.header2 .header_content p {

				font-size: 3rem;

			}

			.header2 p.text2 {

				position: absolute;
				bottom: 0;
				left: 2%;
				font-size: 2rem;
				color: #fff;

			}

	/* Header Img */

	/* Main Content Btn */
	
		.main_content_btn {

			margin-top: 2rem;
			text-align: center;

		}

		.main_content_btn .creator_wrapper{

			position: relative;
			background-color: lightgrey;
			border-radius: 12px;
			padding: 2rem 2rem 10rem 2rem;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			font-size: 2rem;
			margin: auto;
			width: 50%;

		}

		.main_content_btn .creator_boxes{

			position: relative;
			margin-bottom: 15px;
			width: calc(100% / 2 + 20px);

		}

		.main_content_btn .creator_boxes span {

			display: block;
			font-weight: 500;
			margin-bottom: 5px;

		}

		.main_content_btn .creator_boxes input {

			height: 45px;
			width: 100%;
			outline: none;
			border-radius: 5px;
			border: 1px solid #ccc;
			padding-left: 15px;
			font-size: 16px;
			border-bottom-width: 2px;
			transition: all 0.3s ease;

		}

		.main_content_btn .creator_boxes input[type="file"] {

			border: initial;
			font-size: 2rem;

		}

		.main_content_btn .creator_boxes textarea {

			font-size: 2rem;
			padding: 1rem;

		}

		.main_content_btn .creator_btn {

			position: absolute;
			bottom: 0;
			transform: translateY(-100%);

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

		.main_content_btn .creator_btn button:hover{

			background-color: #71b7e6;

		}

		.main_content_btn button:hover{

			background-color: #71b7e6;

		}

	/* Main Content Btn */

	/* Assignment Details / Submitting */
		.assignment_wrapper {

			background-color: lightblue;
			border-radius: 12px;
			padding: 5px 2rem 5px 2rem;
			width: 95%;
			margin: 2rem 0 0 2rem;

		}

		.assignment_wrapper .assignment_header {

			font-size: 2.5rem;
			font-weight: bold;

		}

		.assignment_wrapper .assignment_content .assignment_title {

			font-size: 2rem;

		}

		.assignment_wrapper .assignment_content .assignment_description {

			font-size: 1.5rem;
			margin-left: 1rem;

		}

		.assignment_content {

			position: relative;
			background: lightsteelblue;
			border-radius: 12px;
			padding: 1.5rem;
			margin-bottom: 2rem;

		}

		.assignment_content .assignment_file .assignment_info {

			display: flex;
			padding-bottom: 1rem;


		}

		.assignment_content .assignment_file .assignment_info i {

			font-size: 3rem;
			color: #000;
			padding: 1rem 0 2rem 1rem;

		}

		.assignment_content .assignment_file .assignment_info h1 {

			font-size: 2rem;
			padding-left: 1rem;
			margin-top: 1.5rem;
			color: #000;

		}

		.assignment_content .assignment_file p {

			font-size: 1.5rem;
			padding-left: 1rem;
			margin-top: -20px;
			color: #000;

		}

		.assignment_content button {

			border: none;
			outline: none;
			background: transparent;
		}

		.assignment_content button:hover {

			text-decoration: underline;
			color: #5f96bb;

		}

		.assignment_content button.btn.download {

			position: absolute;
			right: 0;
			transform: translateY(-100%);

		}

		.assignment_content a {

			color: #000;

		}

		.assignment_content button.btn:hover,
		.assignment_content a:hover {

			color: #5f96bb;

		}

		.assignment_content .btn.upload_work {

			position: absolute;
			right: 0;
			top: 0;
			transform: translate(0%, 150%);
			/* Interactive */
			/* visibility: hidden;																 */

		}

		.assignment_content .show_upload_assign_btn {

			position: absolute;
			right: 0;
			top: 0;
			transform: translate(-20%, 50%);
			/* Interactive */
			font-size: 1.5rem;

		}

		.assignment_content .hide_upload_assign_btn {

			position: absolute;
			right: 0;
			top: 0;
			font-size: 1.5rem;
			transform: translate(-50%, 35%);
			/* Interactive */
		}

		.assignment_content .upload_assign_btn {

			position: absolute;
			right: 0;
			top: 0;
			font-size: 1.5rem;
			transform: translate(-200%, 35%);
			/* Interactive */
		}


		.assignment_content .btn.upload_edited_work {

				position: absolute;
				right: 0;
				top: 0;
				transform: translate(0%, 150%);
				/* Interactive */
				/* visibility: hidden;																 */

		}

		.assignment_content .edit_work_btn {

			position: absolute;
			right: 0;
			top: 0;
			transform: translate(-20%, 50%);
			/* Interactive */
			font-size: 1.5rem;

		}


		.assignment_content .upload_edit_work_btn {

			position: absolute;
			right: 0;
			top: 0;
			font-size: 1.5rem;
			transform: translate(-200%, 140%);
			/* Interactive */

		}

		.assignment_content .cancel_edit_work_btn {

			position: absolute;
			right: 0;
			top: 0;
			font-size: 1.5rem;
			transform: translate(-50%, 140%);
			/* Interactive */

		}

		.footer {

			margin-top: 1rem;
			visibility: hidden;

		}

		.assignment_content p.assign_status {

			position: absolute;
			right: 0;
			top: 0;
			font-size: 1.5rem;
			transform: translate(-15%, 50%);

		}

	/* Assignment Details / Submitting */

	/* Assign Takers Scorer */

		.assign_takers_editor .creator_wrapper{

			position: relative;
			background-color: lightgrey;
			border-radius: 12px;
			padding: 2rem 2rem 10rem 2rem;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			font-size: 2rem;
			margin: auto;
			width: 50%;

		}

		.assign_takers_editor .creator_boxes {

			position: relative;
			margin-bottom: 15px;
			width: calc(100% / 2 + 20px);

		}

		.assign_takers_editor .creator_boxes span {

			display: block;
			font-weight: 500;
			margin-bottom: 5px;

		}

		.assign_takers_editor .creator_boxes input {

			height: 45px;
			width: 100%;
			outline: none;
			border-radius: 5px;
			border: 1px solid #ccc;
			padding-left: 15px;
			font-size: 16px;
			border-bottom-width: 2px;
			transition: all 0.3s ease;

		}

		.assign_takers_editor .creator_btn {

			position: absolute;
			bottom: 0;
			transform: translateY(-100%);

		}

		.assign_takers_editor .creator_btn button{

			padding: 5px 1rem 5px 1rem;
			border: none;
			outline: none;
			background-color: #11101d;
			border-radius: 12px;
			color: #fff;
			transition: 0.2s all ease;
			font-size: 2.5rem;

		}

		.assign_takers_editor .creator_btn button:hover{

			background-color: #71b7e6;

		}

		.assign_takers_editor button:hover{

			background-color: #71b7e6;

		}

	/* Assign Takers Scorer */
	
</style>

<body>

	<div class="navbar_wrapper">
		<div class="navbar_logo-content">
			<div class="navbar_logo">
				<i class='bx bxl-github'></i>
				<div class="logo_name">LMS</div>
			</div>
			<i class='bx bx-menu' id='btn'> </i>
			<i class='bx bx-window-close' id='btn1'> </i>
		</div>

		<ul class="navbar_list">
			<li>
				<a href="main.php">
					<i class='bx bx-grid-alt'></i>
					<span class="links_name">Dashboard</span>
				</a>
				<span class="tooltip">Dashboard</span>
			</li>

			<li>
				<a href="profile.php">
					<i class='bx bx-user'></i>
					<span class="links_name">Profile</span>
				</a>
				<span class="tooltip">Profile</span>
			</li>

			<li>
				<a href="message.php">
					<i class='bx bx-chat'></i>
					<span class="links_name">Message</span>
				</a>
				<span class="tooltip">Message</span>
			</li>

			<li>
				<a href="class.php">
					<i class='bx bx-briefcase'></i>
					<span class="links_name">Class</span>
				</a>
				<span class="tooltip">Class</span>
			</li>

			<li>
				<a href="schedule.php">
					<i class='bx bx-calendar'></i>
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

		<?php if (empty($_SESSION['username'])) : ?>
			<div class="log_section">
				<div class="log_content">
					<div class="log_content-wrap">
						<div class="log_btn"><a href="register.php">Sign Up</a></div>
						<div class="log_btn"><a href="login.php">Sign In</a></div>
					</div>
					<i class='bx bx-log-out' id="log_icon"></i>
				</div>
			</div>
		<?php else : ?>
			<div class="profile">
				<div class="profile-details">
					<img src="<?php echo $_SESSION['image']; ?>" alt="profileImg">
					<div class="name_job">
						<div class="name"><?php echo $_SESSION['fullname']; ?></div>
						<div class="job"><?php echo $_SESSION['occupation']; ?></div>
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

		<!-- <input type="text" class="folderclass_classcode" value="<?php echo $getmyassign; ?>"> -->

		<input type="hidden" class="folderclass_classcode" value="<?php echo $classcode_id; ?>">
		<input type="hidden" class="session_id" value="<?php echo $_SESSION['id']; ?>">
		<input type="hidden" class="session_fullname" value="<?php echo $_SESSION['fullname']; ?>">
		<input type="hidden" class="thisclass_admin_id" value="<?php echo $thisclass_adminid; ?>">

		<div class="header">
			<p class="header_left">Task</p>
			<p class="header_title">Assignment</p>
			<div class="header_btns">
				<div class="header_options">
					<button type="submit" class="btn quiz"><a href="folderquiz.php?classcode=<?php echo $classcode_id; ?>">Quiz</a></button>
				</div>
				<div class="header_options">
				<button type="submit" class="btn test"><a href='foldertest.php?classcode=<?php echo $classcode_id; ?>'>Test</a></button>
				</div>
				<div class="header_options">
					<button type="submit" class="btn assignment" style="border-color: #71b7e6;"><a href='folderassign.php?classcode=<?php echo $classcode_id; ?>'>Assignment</a></button>
				</div>
			</div>
		</div>

		<div class="header2">
			<?php

			$query = "SELECT * FROM class_info_{$classcode_id}";
			$results = mysqli_query($conn, $query);

			if (isset($results)) {

				while ($rows = mysqli_fetch_array($results)) {

			?>

					<img src="<?php echo $rows['class_image'] ?>" alt="headerimg">

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

		<div class="main_content_btn">
			<div class="main_content_wrapper">
				<?php if ($thisclass_adminid == $_SESSION['id']) : ?>
					<button class="create_assignment_btn">Create Assignment</button>
					<button class="view_assign_takers_btn">View Takers</button>
				<?php endif ?>
			</div>
		</div>


		<div class="assignment_wrapper">


			<div class="assignment_header" style="text-align: center;">
				Class Assignments
			</div>

			<div class="assignment_content_wrappper">


			</div>

		</div>

		<div class="assignment_takers">
			<h3 class="title2" style="margin-left: 2rem;">Assignment Takers</h3>
			<br>

			<div class="assign_takers_editor">
				
			</div>

			<br>

			<div class="table-responsive">
				<table class="table table-bordered" style="width : 95% ; margin:auto;">
					<tr>
						<th>Assignment Name</th>
						<th>Assignment Taker Name</th>
						<th>Assignment File</th>
						<th>Assignment File Download</th>
						<th>Assignment Date Passed</th>
						<th>Taker Score</th>
						<th>Command</th>
					</tr>
					<?php

					$getassign_takers_data = "SELECT * FROM class_assignments_takers_{$classcode_id}";
					$getassign_takers_data_run = mysqli_query($conn, $getassign_takers_data);

					if ($getassign_takers_data_run) {
						while ($getassign_data_rows = mysqli_fetch_assoc($getassign_takers_data_run)) {

					?>
							
							<tr>
								<td><?php echo $getassign_data_rows['assign_name']; ?></td>
								<td><?php echo $getassign_data_rows['assign_taker_name']; ?></td>
								<td><?php echo basename($getassign_data_rows['assign_file_name']); ?></td>
								<td><a href="<?php echo $getassign_data_rows['assign_file_path']; ?>" download>Download</a></td>
								<td><?php echo $getassign_data_rows['assign_date_passed']; ?></td>
								<td><?php echo $getassign_data_rows['assign_taker_score']; ?></td>
								<td style="text-align: center;">
									<div class="edit_btn_wrapper">
										<button type="submit" class="edit_score" name="edit_score" value="<?php echo $getassign_data_rows['assign_taker_id'];  ?>">Edit</button>
										<input type="hidden" class="hiddenassign_id" value="<?php echo $getassign_data_rows['assign_id'];  ?>">
										<input type="hidden" class="hiddenassign_name" name="hiddenassign_name" value="<?php echo $getassign_data_rows['assign_name'];  ?>">
										<input type="hidden" class="hiddenassign_taker_name" value="<?php echo $getassign_data_rows['assign_taker_name'];  ?>">
										<input type="hidden" class="hiddenassign_taker_score" value="<?php echo $getassign_data_rows['assign_taker_score'];  ?>">
									</div>
								</td>
								

						<?php
						}
					}
						?>
							</tr>

				</table>
			</div>

			</form>

		</div>

		<div class="footer">

			Whitespace

		</div>

	</div>

</body>

<script>

</script>
<script src="js/folderassign.js"></script>

</html>