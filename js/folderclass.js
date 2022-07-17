$(document).ready(function () {

   load_comment();

   hide_class_members();

   function load_comment() {

      var folderclass_classcode = $('.folderclass_classcode').val();
      var myid = $('.myid').val();

      $.ajax({
         type: "POST",
         url: "backend/folderclass_back.php",
         data: {
            'comment_load_data': true,
            classcode: folderclass_classcode
         },
         success: function (response) {

            $('.content2-wrapper').html("")
            console.log(response);
            $.each(response, function (key, value) {

               $('.content2-wrapper').
                  append('<div class="eachForum-wrapper">\
                           <div class="content2-info">\
                              <img src="'+ value.user['image'] + '" alt="icon"></img>\
                              <div class="content2_info-header">\
                                 <h2>'+ value.cmt['class_forum_creator_name'] + '</h2>\
                                 <p class="date" name="date">'+ value.cmt['class_forum_date'] + '</p>\
                              </div>\
                              '+ ( value.cmt['class_forum_creator_id'] == myid ? '<button type="submit" class="comment_dots_btn" value="'+ value.cmt['class_forum_id'] +'"><i class="bx bx-x-circle"></i></button>' : '' )+'\
                           </div>\
                           <p class="description" name="description"> '+ value.cmt['class_forum_content'] + ' </p>\
                           <div class="commentwrap">\
                                 <div class="commentbuttons">\
                                    <button  button value = "'+ value.cmt['class_forum_id'] + '" class="replycomments_btn">Reply</button>\
                                    <button value = "'+ value.cmt['class_forum_id'] + '" class="classcomments_btn"><i class="bx bxs-group"></i>View Replies</button>\
                                    <input type = "hidden" class = "hidden-forum_date" value = " '+ value.cmt['class_forum_date'] + ' ">\
                                 </div>\
                              <div class="content2-reply_section">\
                              </div>\
                           </div>\
                        </div>\
                  ');

            });

         }

      });

   }

   function hide_class_members() {

      $('.class_members').hide();

   }

   $(document).on('click', '.comment_dots_btn', function () {
      
      var thisClicked = $(this);
      var comment_id = thisClicked.val();
      var folderclass_classcode = $('.folderclass_classcode').val();
      var data = {
         "delete_class_comment": true,
         "comment_id": comment_id,
         "classcode": folderclass_classcode
      }
      bootbox.confirm("Do you really want to delete this Comment?", function (result) {

         if (result) {
            // AJAX Request
            $.ajax({
               url: 'backend/folderclass_back.php',
               type: 'POST',
               data: data,
               success: function (response) {
                  alert("Success");
                  location.reload();
               }
            });
         }

      });

   });

   $(document).on('click', '.classcomments_btn', function (e) {
      e.preventDefault();

      var thisClicked = $(this);
      var forum_id = thisClicked.val();
      var folderclass_classcode = $('.folderclass_classcode').val();

      $.ajax({
         type: "POST",
         url: "backend/folderclass_back.php",
         data: {
            'forum_id': forum_id,
            'view_comment_data': true,
            classcode: folderclass_classcode
         },
         success: function (response) {

            console.log(response);
            $('.content2-reply_section').html("");

            $.each(response, function (key, value) {
               thisClicked.closest('.commentbuttons').closest('.commentwrap').find('.content2-reply_section').
                  append('<div class="comment_content_wrapper">\
                        <div class="comment_header">\
                           <img src="'+ value.user['image'] + '" alt="icon"></img>\
                        </div>\
                        <div class="comment_info">\
                           <div class="comment_info_header" style="display: flex; align-items:center;">\
                              <h3>' + value.cmt['class_commenter_name'] + '</h3>\
                              <p>' + value.cmt['class_comment_date'] + '</p>\
                           </div>\
                           <p>' + value.cmt['class_comment'] + '</p>\
                        </div>\
                        <div class="sub_comment_section">\
                        </div>\
                     </div>\
               ');

            });

         }

      });

   });

   $(document).on('click', '.replycomments_btn', function () {

      var thisClicked = $(this);
      var forum_id = thisClicked;

      $('.content2-reply_section').html("");
      thisClicked.closest('.commentwrap').find('.content2-reply_section').
         html('<div class="footer">\
               <img class = "commentimg" src="'+ $('.folderclass_admin_image').val() + '" alt="icon"></img>\
               <textarea class = "reply_msg" name="comment_txtarea" id="comment" cols="55" rows="2" placeholder="Add comment"></textarea>\
               <div class = "reply_buttons">\
                  <button class="add_reply_btn">Reply</button>\
                  <button class="cancel_reply_btn">Cancel</button>\
               </div>\
            </div>\
      ');


   });

   $(document).on('click', '.cancel_reply_btn', function () {

      $('.content2-reply_section').html("");

   });

   $(document).on('click', '.add_reply_btn', function (e) {
      e.preventDefault();

      var thisClicked = $(this);

      var forum_id = thisClicked.closest('.content2-reply_section').closest('.commentwrap').find('.replycomments_btn').val();
      var reply = thisClicked.closest('.content2-reply_section').find('.reply_msg').val();
      var reply_date = thisClicked.closest('.content2-reply_section').closest('.commentwrap').find('.hidden-forum_date').val();
      var folderclass_classcode = $('.folderclass_classcode').val();

      var data = {
         'forum_id': forum_id,
         'reply_date': reply_date,
         'reply_msg': reply,
         classcode: folderclass_classcode,
         'add_reply': true
      };

      $.ajax({
         type: "POST",
         url: "backend/folderclass_back.php",
         data: data,
         success: function (response) {
            alert(response);
            $('.content2-reply_section').html("");
         }

      });

   });

   $(document).on('click', '.edit_class_btn', function () {

      var thisClicked = $(this);

      var classname = $('.folderclass_name').val();
      var section = $('.folderclass_section').val();
      var subject = $('.folderclass_subject').val();
      var credit = $('.folderclass_credit').val();
      var sched = $('.folderclass_sched').val();

      thisClicked.closest(".edit_class_info_wrapper").
         html('<div class="editor_wrapper">\
               <div class="editor_boxes">\
                     <span>Enter New Class Name</span>\
                     <input type="text" class="class_name" name="class_name" value = "'+ classname + '">\
               </div>\
               <div class="editor_boxes">\
                     <span>Enter New Subject Name</span>\
                     <input type="text" class="subject_name" name="subject_name" value = "'+ subject + '">\
               </div>\
               <div class="editor_boxes">\
                     <span>Enter New Section Name</span>\
                     <input type="text" class="section_name" name="section_name" value = "'+ section + '">\
               </div>\
               <div class="editor_boxes">\
                     <span>Enter New Credit</span>\
                     <input type="number" class="credit" name="credit" value = "'+ credit + '">\
               </div>\
               <div class="editor_boxes">\
                  <span>Enter New Schedule</span>\
                  <input type="datetime-local" name="schedule" class="schedule" value="'+ sched + '">\
               </div>\
               <div class="editor_btn">\
                     <button name="save" class="saveedits_btn">Save</button>\
                     <button name="cancel" class="canceledit_btn">Cancel</button>\
               </div>\
            </div>\
      ');

   });

   $(document).on('click', '.canceledit_btn', function () {

      var thisClicked = $(this);

      thisClicked.closest(".edit_class_info_wrapper").
         html('<button class="edit_class_btn">Edit Class</button>');

   });

   $(document).on('click', '.saveedits_btn', function () {

      var thisClicked = $(this);

      var classname = thisClicked.closest(".editor_btn").closest(".editor_wrapper").find(".class_name").val();
      var section = thisClicked.closest(".editor_btn").closest(".editor_wrapper").find(".section_name").val();
      var subject = thisClicked.closest(".editor_btn").closest(".editor_wrapper").find(".subject_name").val();
      var credit = thisClicked.closest(".editor_btn").closest(".editor_wrapper").find(".credit").val();
      var sched = thisClicked.closest(".editor_btn").closest(".editor_wrapper").find(".schedule").val();

      var folderclass_adminid = $('.folderclass_admin_id').val();
      var folderclass_classcode = $('.folderclass_classcode').val();

      var data = {
         "save_edit_btn": true,
         "classname": classname,
         "section": section,
         "subject": subject,
         "credit": credit,
         "sched": sched,
         "classcode": folderclass_classcode,
         "class_admin_id": folderclass_adminid
      }

      $.ajax({
         type: "POST",
         url: "backend/folderclass_back.php",
         data: data,
         success: function (response) {
            // console.log(response)
            alert("Success");
            location.reload();
         }

      });

   });

   $(document).on('click', '.delete_class_btn', function () {

      var thisClicked = $(this);
      var classcode = thisClicked.val();
      var data = {
         "delete_class_btn": true,
         "classcode": classcode,
      }

      bootbox.confirm("Do you really want to delete this Class?", function (result) {

         if (result) {
            // AJAX Request
            $.ajax({
               url: 'backend/folderclass_back.php',
               type: 'POST',
               data: data,
               success: function (response) {
                  alert("Success");
                  window.location.href = "main.php";
               }
            });
         }

      });


   });

   $(document).on('click', '.leave_class_btn', function () {

      var thisClicked = $(this);
      var classcode = thisClicked.val();
      var myid = $('.myid').val();
      var data = {
         "leave_class_btn": true,
         "classcode": classcode,
         "user_id": myid
      }

      bootbox.confirm("Do you really want to leave this Class?", function (result) {

         if (result) {
            // AJAX Request
            $.ajax({
               url: 'backend/folderclass_back.php',
               type: 'POST',
               data: data,
               success: function (response) {
                  alert("Success");
                  window.location.href = "main.php";
               }
            });
         }

      });


   });

   $(document).on('click', '.leave_class_btn', function () {

      var thisClicked = $(this);
      var classcode = thisClicked.val();
      var myid = $('.myid').val();
      var data = {
         "leave_class_btn": true,
         "classcode": classcode,
         "user_id": myid
      }

      bootbox.confirm("Do you really want to leave this Class?", function (result) {

         if (result) {
            // AJAX Request
            $.ajax({
               url: 'backend/folderclass_back.php',
               type: 'POST',
               data: data,
               success: function (response) {
                  alert("Success");
                  window.location.href = "main.php";
               }
            });
         }

      });


   });

   $(document).on('click', '.view_class_members_btn', function () {

      var thisBtn = $(this);

        var class_members_table = $('.class_members');
        var contents_box = $('.contents-box');

        class_members_table.toggle();
        contents_box.toggle();

        if(thisBtn.html() == "View Members"){

            thisBtn.html("Hide Members");

        }else{

            thisBtn.html("View Members");

        }

   });








});
