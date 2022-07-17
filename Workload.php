<?php
    include('backend/userlogin-register.php');
	include('backend/classconfig.php');
?>
<!DOCTYPE html>
<html>

  <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <head>
        <title>Workload</title>
        <link rel="stylesheet" href="styles/mainstyle.css">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="styles/workloadstyle.css">

        <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">
    </head>

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

	<div class="main_content">

        <div class="header">
			<p class="workload_header">Workload</p>
		</div>

		<div class="content">
			<div class="content_header">Classes</div>
			<div class="folders">

				<?php 
					if(isset($_SESSION['id'])){
					$getMyclasses = "SELECT * FROM acc_classes WHERE acc_class_id = '{$_SESSION['id']}'";
					$res = mysqli_query($conn, $getMyclasses);
					$numrows = mysqli_num_rows($res);
				
						if ($numrows >= 1){

							while($rows=mysqli_fetch_array($res)){

				?>

				<div class='folderclass'>
					<i class='fa fa-folder icons'></i>
					<div class="folderclass_content">
						<ul>
							<li>
								<button type='submit' class='btn'><a href='folderquiz.php?classcode=<?php echo $rows['acc_class_code']; ?>'>
									<?php 
										if(strlen($rows['acc_class_classname']) > 10){

											echo substr($rows['acc_class_classname'], 0, 10) . '...';
											
										}else{

											echo $rows['acc_class_classname'];
										}
									?>
								</a></button>
							</li>
							<li>
								<span class="fdcspan"><?php echo $rows['acc_class_section']; ?></span>
							</li>
							<?php if($_SESSION['id'] !== $rows['acc_class_admin_id']): ?>
							<li>
								<span><?php echo $rows['acc_class_admin']; ?></span>
							</li>
							<?php endif ?>
						</ul>
						<?php if($_SESSION['id'] !== $rows['acc_class_admin_id']): ?>
							<img src="<?php echo $rows['acc_class_admin_image']; ?>" alt="ProfImg">
						<?php endif ?>
					</div>
				</div>

				<?php
                            
							}
						}

					}

            	?>

			</div>

			
			
		</div>

		
	</div>

	<script>

			window.onscroll = function() {stickyFunction()};

			var header = document.querySelector(".header");
			var sticky = header.offsetTop;

			function stickyFunction() {
				if (window.pageYOffset > sticky) {
					header.classList.add("sticky");
				} else {
					header.classList.remove("sticky");
				}
			}


	</script>
		


</html>