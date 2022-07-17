<?php
	include('backend/userlogin-register.php');

	if (isset($_GET['classcode'])) 
	{
		$classcode_id = $_GET['classcode'];
		$_SESSION['fclasscode_id'] = $classcode_id;
	}


	$classinfo_query = "SELECT * FROM class_info_{$classcode_id}";
	$access = mysqli_query($conn, $classinfo_query);
	$accessrows = mysqli_num_rows($access);

	$thisclass_adminid = "";
	$thisclass_name = "";

	if ($accessrows > 0) 
	{
		while ($accessrecord = mysqli_fetch_array($access)) {

			$thisclass_adminid = $accessrecord['class_admin_id'];
			$thisclass_adminimage = $accessrecord['class_admin_image'];
			$thisclass_name = $accessrecord['class_name'];
			$thisclass_section = $accessrecord['class_section'];
			$thisclass_subject = $accessrecord['class_subject'];
			$thisclass_credit = $accessrecord['class_credit'];
			$thisclass_sched = $accessrecord['class_sched'];

		}
	}

	if(isset($_POST['postthoughts_btn']))
	{

		$content = mysqli_real_escape_string($conn, $_POST['postthoughts_txtarea']);
		$date = date("F jS");

		if($content == ""){

			echo "<script>
				alert('Content can\'t be empty');
			</script>";
						
		}else{

			$insert_content = 
			"INSERT INTO class_forum_{$classcode_id} (class_forum_creator_id, class_forum_date, class_forum_creator_name, class_forum_content) 
			VALUES ('{$_SESSION['id']}', '$date', '{$_SESSION['fullname']}', '$content');";

			mysqli_query($conn, $insert_content);
			header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);

		}
	}

	/* File size limit conversion from mb to bytes ... (MB x 1024)x 1024 === MB converted to bytes */

	if (isset($_POST['upload'])) 
	{

		$file_path = "uploadedfiles/";
		$file_new_unique_name = date("dmy") . time() . $_FILES["uploadedfile"]['name'];
		$file_name = $_FILES['uploadedfile']['name'];
		$file_temp = $_FILES['uploadedfile']['tmp_name'];
		$file_size = $_FILES['uploadedfile']['size'];
		$file_type = pathinfo($file_name, PATHINFO_EXTENSION);

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

		if ($file_size > 10485760) {
			
			echo "<script>alert('File is too big. Limit is 10mb');</script>";
		} elseif ($file_size <= 0) {

			echo "<script>alert('There is no File found');</script>";
		} else {
			$insert_file_query =
				"INSERT INTO class_file_{$_SESSION['fclasscode_id']}(class_file_unique_name, class_file_name, class_file_path, class_file_size, class_file_type)
				VALUES('$file_new_unique_name', '$file_name', '$file_path$file_new_unique_name', '$file_size_string', '$file_type');";

			mysqli_query($conn, $insert_file_query);
			move_uploaded_file($file_temp, $file_path . $file_new_unique_name);
			header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
			// echo "<script>alert('Success!');</script>";

		}
	}

	$classfile_id = "";

	if (isset($_POST['delete'])) 
	{

		$classfile_id = mysqli_real_escape_string($conn, $_POST['classfile_id']);
		$getclassfile_query = "SELECT * FROM class_file_$classcode_id WHERE class_file_id = '$classfile_id'";
		$file_result = mysqli_query($conn, $getclassfile_query);
		$filenum_rows = mysqli_num_rows($file_result);

		if ($filenum_rows > 0) {
			while ($file_rows = mysqli_fetch_array($file_result)) {

				$file_path = $file_rows['class_file_path'];
				unlink($file_path);
			}
		}

		$delete_file_query = "DELETE FROM class_file_$classcode_id WHERE class_file_id = '$classfile_id'";
		mysqli_query($conn, $delete_file_query);
		header('Location:' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
	}

	$edit_state = false;

	if (isset($_POST['edit'])) 
	{

		$edit_state = true;
		$edit_classfile_id = mysqli_real_escape_string($conn, $_POST['classfile_id']);
		$edit_classfile_path = mysqli_real_escape_string($conn, $_POST['classfile_path']);
		$edit_classfile_name = mysqli_real_escape_string($conn, $_POST['classfile_name']);

		$edit_classdir_name = pathinfo($edit_classfile_path);
		$baseid = $edit_classfile_id;
		$baseext = $edit_classdir_name['extension'];
		// $basename = substr($edit_classdir_name['filename'], 16);
		$basename = substr($edit_classfile_name, 0, strpos($edit_classfile_name, "."));
	}

	if (isset($_POST['save'])) 
	{

		$newfile_id = mysqli_real_escape_string($conn, $_POST['newfileid']);
		$newfile_name = mysqli_real_escape_string($conn, $_POST['newfilename']);
		$newfile_extension = mysqli_real_escape_string($conn, $_POST['newfileext']);

		$editfile_query = "UPDATE class_file_{$classcode_id} SET class_file_name = '$newfile_name.$newfile_extension' WHERE class_file_id = '$newfile_id'";
		mysqli_query($conn, $editfile_query);
	}

	if (isset($_POST['cancel'])) 
	{
		$edit_state = false;
	}

?>

<!DOCTYPE html>
<html>
<head>

	<title><?php echo $thisclass_name; ?></title>

	<link rel="stylesheet" href="styles/mainstyle.css">
	<link rel="stylesheet" type="text/css" href="cropperjs/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
	<link rel="stylesheet" href="styles/folderclass.css">

	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js'></script>

	<link rel="stylesheet" href="https://fengyuanchen.github.io/cropperjs/css/cropper.css" />
	<script src="https://fengyuanchen.github.io/cropperjs/js/cropper.js"></script>

	<link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
</head>

<script>
	$(document).ready(function() {

		var uploadform = document.getElementById('uploadimageform');
		var uploadpop = document.getElementById('uploadpop');
		var $modal = $('#modal');
		var modal_image = document.getElementById('modal-image');
		var cropper;
		$('#upload_image').change(function(event) {
			var files = event.target.files;
			var done = function(url) {
				modal_image.src = url;
				$modal.modal('show');
			};
			if (files && files.length > 0) {
				reader = new FileReader();
				reader.onload = function(event) {
					done(reader.result);
				};
				reader.readAsDataURL(files[0]);
			}
		});

		$modal.on('shown.bs.modal', function() {
			cropper = new Cropper(modal_image, {
				aspectRatio: 4,
				/* 4 */
				viewMode: 6,
				/* 6 */
				preview: '.preview'
			});
		}).on('hidden.bs.modal', function() {
			cropper.destroy();
			cropper = null;
		});

		$('#crop_and_upload').click(function() {
			canvas = cropper.getCroppedCanvas({
				width: 1150,
				height: 200
			});

			canvas.toBlob(function(blob) {
				var folderclass_classcode = $('.folderclass_classcode').val();
				url = URL.createObjectURL(blob);
				var reader = new FileReader();
				reader.readAsDataURL(blob);
				reader.onloadend = function() {
					var base64data = reader.result;

					$.ajax({
						url: 'backend/folderclass_back.php',
						method: 'POST',
						data: {
							modal_image: base64data,
							classcode: folderclass_classcode
						},
						success: function(data) {
							$modal.modal('hide');
							uploadpop.style.display = 'none';
							uploadform.reset();
						}
					});

				};
			});

		});

	});
</script>

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

	<div class="main_content" style="overflow-y: scroll">

		<input type="hidden" class="folderclass_classcode" value="<?php echo $classcode_id; ?>">
		<input type="hidden" class="folderclass_admin_image" value="<?php echo $thisclass_adminimage; ?>">
		<input type="hidden" class="folderclass_admin_id" value="<?php echo $thisclass_adminid; ?>">

		<input type="hidden" class="myid" value="<?php echo $_SESSION['id']; ?>">

		<input type="hidden" class="folderclass_name" value="<?php echo $thisclass_name; ?>">
		<input type="hidden" class="folderclass_section" value="<?php echo $thisclass_section; ?>">
		<input type="hidden" class="folderclass_subject" value="<?php echo $thisclass_subject; ?>">
		<input type="hidden" class="folderclass_credit" value="<?php echo $thisclass_credit; ?>">
		<input type="hidden" class="folderclass_sched" value="<?php echo $thisclass_sched; ?>">
		
		<div class="header">
			
			<?php

			$query = "SELECT * FROM class_info_{$classcode_id}";
			$results = mysqli_query($conn, $query);

			if (isset($results)) {

				while ($rows = mysqli_fetch_array($results)) {

			?>

					<img src="<?php echo $rows['class_image'] ?>" alt="headerimg">

					<?php if ($rows['class_admin_id'] == $_SESSION['id']) : ?>
						<button type='submit' class='btn' name='uploadimage'>Upload Image</button>
					<?php endif ?>

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

		<div class="uploadimage_popup" style="display: none;" id="uploadpop">
			<div class="popup_wrapper">
				<div class="popup_header">Upload Image</div>
				<form id="uploadimageform" method="POST">
					<div class="class-inputs">
						<input type="file" name="image" class="image" id="upload_image">
					</div>

					<div class="popup-btn_wrapper">
						<div class="popup-btn">
							<button type="submit" class="uploadcancel">Cancel</button>
						</div>
						<div class="popup-btn">
							<button type="submit" name="upload">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>


		<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Crop Image Before Upload</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="img-container">
							<div class="row">
								<div class="col-md-8">
									<img src="" id="modal-image" />
								</div>
								<div class="col-md-4">
									<div class="preview"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="crop_and_upload" class="btn btn-primary">Crop</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		

		<?php if($_SESSION['id'] == $thisclass_adminid) : ?>
		<div class="edit_class_info_wrapper">
			<button class="edit_class_btn">Edit Class</button>
			<button class="delete_class_btn" value="<?php echo $classcode_id; ?>">Delete Class</button>
			<button class="view_class_members_btn" value="<?php echo $classcode_id; ?>">View Members</button>
		</div>
		<?php else: ?>
		<div class="edit_class_info_wrapper">
			<button class="leave_class_btn" value="<?php echo $classcode_id; ?>">Leave Class</button>
			<button class="view_class_members_btn" value="<?php echo $classcode_id; ?>">View Members</button>
		</div>
		<?php endif ?>


		<div class="contents-box">
			<div class="content">
				<form action="" method="POST" enctype="multipart/form-data">
					<?php if ($thisclass_adminid == $_SESSION['id']) : ?>
						<div class="content_header">
							<span>Upload File</span>
							<input type="file" name="uploadedfile" id="upload">
							<button name="upload" class="uploadbtn">Upload</button>
						</div>
					<?php else : ?>
						<div class="content_header">
							<span>Class Files</span>
						</div>
					<?php endif ?>
				</form>
				<?php if ($edit_state == true) : ?>
					<form action="" method="post">
						<div class="content_editor">
							<input type="text" name="newfilename" value="<?php echo $basename; ?>">
							<input type="hidden" name="newfileext" value="<?php echo $baseext; ?>">
							<input type="hidden" name="newfileid" value="<?php echo $baseid; ?>">
							<div class="content_editor_btns">
								<button type='submit' class='btn save' name='save'>Save</button>
								<button type='submit' class='btn cancel' name='cancel'>Cancel</button>
							</div>
						</div>
					</form>
				<?php endif ?>
				<?php

				$files_query = "SELECT * FROM class_file_{$classcode_id}";
				$file_results = mysqli_query($conn, $files_query);
				$numoffiles = mysqli_num_rows($file_results);

				if ($numoffiles > 0) {
					while ($record = mysqli_fetch_array($file_results)) {

				?>
						<div class="content-wrapper">
							<!-- onsubmit="return false" -->
							<form action="" method="POST">
								<div class="content_info">
									<div class="content_info_header">
										<!-- <button id="option_btn" value='<?php echo $record['class_file_id']; ?>'><i id="option" class='bx bx-dots-vertical-rounded'></i></button> -->
										<input type="hidden" name="classfile_id" class="classfile_id" value='<?php echo $record['class_file_id']; ?>'>
										<input type="hidden" name="classfile_name" class="classfile_name" value='<?php echo $record['class_file_name']; ?>'>
										<input type="hidden" name="classfile_path" class="classfile_path" value='<?php echo $record['class_file_path']; ?>'>

										<?php if ($record['class_file_type'] == 'zip') : ?>
											<i class="fa fa-file-archive-o icons"></i>
										<?php elseif (
											$record['class_file_type'] == 'jpg' || $record['class_file_type'] == 'jpeg' || $record['class_file_type'] == 'png'
											|| $record['class_file_type'] == 'gif' || $record['class_file_type'] == 'tiff' || $record['class_file_type'] == 'psd' || $record['class_file_type'] == 'eps'
											|| $record['class_file_type'] == 'ai'
										) : ?>
											<i class="fa fa-file-image-o icons"></i>
										<?php elseif ($record['class_file_type'] == 'pptx') : ?>
											<i class="fa fa-file-powerpoint-o icons"></i>
										<?php elseif ($record['class_file_type'] == 'docx') : ?>
											<i class="fa fa-file-word-o icons"></i>
										<?php elseif ($record['class_file_type'] == 'pdf') : ?>
											<i class="fa fa-file-pdf-o icons"></i>
										<?php else : ?>
											<i class="fa fa-file-o icons"></i>
										<?php endif ?>

										<!-- <input type="text" value="<?php echo $record['class_file_name']; ?>"> -->
										<h1><?php echo $record['class_file_name']; ?></h1>
									</div>
									<p><?php echo $record['class_file_size']; ?></p>
								</div>
								<?php if ($thisclass_adminid == $_SESSION['id']) : ?>
									<div class="options" id="<?php echo $record['class_file_id']; ?>">
										<button type='submit' class='btn edit' name='edit'>Edit</button>
										<button type='submit' class='btn delete' name='delete'>Delete</button>
									</div>
								<?php endif ?>
								<button type='submit' class='btn download' name='download'><a href='uploadedfiles/<?php echo $record['class_file_unique_name']; ?>' download>Download</a></button>
							</form>
						</div>

				<?php
					}
				}
				?>

			</div>

			<div class="content2">
				<form method="post">
					<div class="content2-header">
						<img class="content2headerimg" src="<?php echo $_SESSION['myimage']; ?>" alt="profile">
						<textarea name="postthoughts_txtarea" cols="55" rows="2" placeholder="Post your Thoughts"></textarea>
						
						<button name="postthoughts_btn"><i class='bx bx-send'></i></button>
					</div>
				</form>

				<div class="content2-wrapper">

						
				</div>

			</div>
		</div>

		<div class="class_members">
			<h3 class="title2" style="margin-left: 2rem;">Class Members</h3>
			
			<br>

			<div class="table-responsive">
				<table class="table table-bordered" style="width : 30% ; margin:auto; text-align:center;">
					<tr>
						<th>Members Name</th>
					</tr>
					<?php

					$checkmembers = "SELECT * FROM class_members_{$classcode_id}";
					$checkmembers_run = mysqli_query($conn, $checkmembers);

					if (mysqli_num_rows($checkmembers_run) > 0) {
						while ($checkmembers_rows = mysqli_fetch_assoc($checkmembers_run)) {

					?>
							<tr>
								<td><?php echo $checkmembers_rows['members_name']; ?></td>
						<?php
						}
					}
						?>
							</tr>

				</table>
			</div>
		</div>

		

	</div>

</body>

<script>
	const uploadpopup_btn = document.querySelector('.btn');
	const popup = document.querySelector('.uploadimage_popup');

	const uploadcancel_btn = document.querySelector('.uploadcancel');

	const uploadimage_form = document.getElementById('uploadimageform');

	function showpopup() {

		if (popup.style.display == 'block') {

			popup.style.display = 'none';

		} else {

			popup.style.display = 'block';
		}

	}

	uploadpopup_btn.addEventListener('click', showpopup);

	function cancelupload() {

		if (popup.style.display == 'block') {

			popup.style.display = 'none';
			uploadimage_form.reset();

		}

	}

	uploadcancel_btn.addEventListener('click', cancelupload);

	$

</script>

<script src="js/folderclass.js"></script>


</html>