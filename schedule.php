<?php
  include('backend/userlogin-register.php');
  include('backend/classconfig.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Schedule</title>
  <link rel="stylesheet" href="styles/mainstyle.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="styles/css2/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" /> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

  <link rel="icon" href="pageicon.png" type="image/gif" sizes="16x16">

  <script>
    $(document).ready(function() {
      var user_id = $('.user_id').val();
      var calendar = $('#calendar').fullCalendar({
        editable: true,
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        events: 'backend/load_calendar.php',
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
          var title = prompt("Enter Event Title");
          if (title) {
            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
            $.ajax({
              url: "backend/schedule_back.php",
              type: "POST",
              data: {
                title: title,
                start: start,
                end: end,
                "user_id": user_id,
                "insert_event": true
              },
              success: function() {
                calendar.fullCalendar('refetchEvents');
                alert("Added Successfully");
              }
            })
          }
        },
        editable: true,
        eventResize: function(event) {
          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
          var date_id = event.date_id;
          $.ajax({
            url: "backend/schedule_back.php",
            type: "POST",
            data: {
              title: title,
              start: start,
              end: end,
              date_id: date_id,
              "user_id": user_id,
              "update_event": true
            },
            success: function(response) {
              calendar.fullCalendar('refetchEvents');
              alert('Event Update');
              console.log(response);
            }
          })
        },

        eventDrop: function(event) {
          var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
          var title = event.title;
          var date_id = event.date_id;
          $.ajax({
            url: "backend/schedule_back.php",
            type: "POST",
            data: {
              title: title,
              start: start,
              end: end,
              date_id: date_id,
              "user_id": user_id,
              "update_event": true
            },
            success: function(response) {
              calendar.fullCalendar('refetchEvents');
              alert("Event Updated");
              // console.log(response);
            }
          });
        },

        eventClick: function(event) {
          if (confirm("Are you sure you want to remove it?")) {
            var date_id = event.date_id;
            $.ajax({
              url: "backend/schedule_back.php",
              type: "POST",
              data: {
                date_id: date_id,
                "user_id": user_id,
                "delete_event": true
              },
              success: function() {
                calendar.fullCalendar('refetchEvents');
                alert("Event Removed");
              }
            })
          }
        },

      });
    });
  </script>

</head>
<style>
  .calendar {
    padding: 0 5rem 0 5rem;
    margin: 0 5rem 0 5rem;

  }

  .header {

    margin-top: 1rem;
    visibility: hidden;

  }
</style>


<body>

  <div class="navbar_wrapper">
    <div class="navbar_logo-content">
      <div class="navbar_logo">
          <img src="pageicon.png" alt="pageicon">
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
    <div class="calendar_wrapper">
      <input type="hidden" class="user_id" value="<?php echo $_SESSION['id']; ?>">
      <div class="header">
        Whitespace
      </div>
      <div id="calendar" class="calendar"></div>

    </div>
  </div>

</body>

</html>