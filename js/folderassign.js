$(document).ready(function () {

    var tempScrollTop = $(window).scrollTop();


    load_assignments();
    hide_assign_takers();

    function load_assignments() {

        var folderclass_classcode = $('.folderclass_classcode').val();
        var session_id = $('.session_id').val();
        var thisclass_admin_id = $('.thisclass_admin_id').val();

        $.ajax({
            type: "POST",
            url: "backend/folderassign_back.php",
            data: {
                'load_assign_data': true,
                classcode: folderclass_classcode
            },
            success: function (response) {

                $('.assignment_content_wrappper').html("");
                console.log(response);
                $.each(response, function (key, value) {
                    $('.assignment_content_wrappper').
                        append('<div class="assignment_content">\
                                <div class="assignment_title">\
                                    <p>'+ value.assign['assign_name'] + '</p>\
                                    <input type="hidden" class="hiddenassign_name" value="'+ value.assign['assign_name'] + '">\
                                </div>\
                                <div class="assignment_description">\
                                    <p>'+ value.assign['assign_description'] + '</p>\
                                    <input type="hidden" class="hiddenassign_desc" value="'+ value.assign['assign_description'] + '">\
                                </div>\
                                '+ (value.assign['assign_file_name'] != "" ? ' ' + (session_id == thisclass_admin_id ?
                                '<div class="assignment_file">\
                                            <div class="assignment_info">\
                                                <i class="fa fa-file icons"></i>\
                                                <h1>'+ value.assign['assign_file_name'] + '.' + value.assign['assign_file_type'] + '</h1>\
                                                <input type="hidden" class="hiddenassign_filename" value="'+ value.assign['assign_file_name'] + '">\
                                            </div>\
                                            <p>'+ value.assign['assign_file_size'] + '</p>\
                                        </div>\
                                        <div class="options">\
                                            <button value="'+ value.assign['assign_id'] + '" type="submit" class="btn edit" name="edit">Edit</button>\
                                            <button value="'+ value.assign['assign_id'] + '" type="submit" class="btn delete" name="delete">Delete</button>\
                                        </div>\
                                        <button type="submit" class="btn download" name="download"><a href="'+ value.assign['assign_file_path'] + '" download>Download</a></button>\
                            </div>' :
                                '<div class="assignment_file">\
                                        <div class="assignment_info">\
                                            <i class="fa fa-file icons"></i>\
                                            <h1>'+ value.assign['assign_file_name'] + '.' + value.assign['assign_file_type'] + '</h1>\
                                            <input type="hidden" class="hiddenassign_filename" value="'+ value.assign['assign_file_name'] + '">\
                                        </div>\
                                        <p>'+ value.assign['assign_file_size'] + '</p>\
                                    </div>\
                                    '+ (value.assign['assign_id'] == value.takers['assign_id'] && value.takers['assign_taker_id'] == session_id ?
                                    ''+ (value.takers['assign_taker_score'] <= 0 ? '<div class = upload_work_wrapper>\
                                                                                        <p class="assign_status" style="transform: translate(-70%, 50%);">Submitted: Score : '+ value.takers['assign_taker_score'] + '</p>\
                                                                                    </div>\
                                                                                    <div class = "upload_work_wrapper edit_work">\
                                                                                        <button type="submit" class="edit_work_btn" name="edit_work_btn" value="'+ value.assign['assign_id'] + '">Edit Work</button>\
                                                                                    </div>' : 
                                                                                    '<div class = upload_work_wrapper>\
                                                                                        <p class="assign_status">Submitted: Score : '+ value.takers['assign_taker_score'] + '</p>\
                                                                                    </div>' ) +'' :
                                    '<div class = "upload_work_wrapper">\
                                        <button type="submit" class="show_upload_assign_btn" name="show_btn" value="'+ value.assign['assign_id'] + '">Upload Work</button>\
                                    </div>') + '\
                                    <button type="submit" class="btn download" name="download"><a href="'+ value.assign['assign_file_path'] + '" download>Download</a></button>\
                            </div>') + ' ' : ' ' + (session_id == thisclass_admin_id ? '<div class="options">\
                                                                                            <button value="'+ value.assign['assign_id'] + '" type="submit" class="btn edit" name="edit">Edit</button>\
                                                                                            <button value="'+ value.assign['assign_id'] + '" type="submit" class="btn delete" name="delete">Delete</button>\
                                                                                        </div>' : '') + '') + '\
                ');

                });

            }

        });

    }

    function hide_assign_takers() {

        $('.assignment_takers').hide();

    }

    $(document).on('click', '.show_upload_assign_btn', function () {

        var thisClicked = $(this);
        var assign_id = thisClicked.val();
        thisClicked.closest('.upload_work_wrapper').
            html('  <input type="file" class="btn upload_work" name="upload_work">\
                <input type="hidden" class="hiddenassign_id" name="hiddenassign_id" value="'+ assign_id + '">\
                <button type="submit" class="upload_assign_btn" name="hide_btn">Upload</button>\
                <button type="submit" class="hide_upload_assign_btn" name="hide_btn">Cancel</button>');
    });

    $(document).on('click', '.hide_upload_assign_btn', function () {

        var thisClicked = $(this);
        thisClicked.closest('.upload_work_wrapper').
            html('<button type="submit" class="show_upload_assign_btn" name="show_btn">Upload Work</button>');

    });

    $(document).on('click', '.upload_assign_btn', function (e) {

        e.preventDefault();

        var thisClicked = $(this);

        var work_file = $('.btn.upload_work').prop('files')[0];
        var assign_id = $('.hiddenassign_id').val();
        var assign_name = thisClicked.closest('.upload_work_wrapper').closest('.assignment_content').find('.hiddenassign_name').val();

        var folderclass_classcode = $('.folderclass_classcode').val();

        var assign_taker_id = $('.session_id').val();
        var assign_taker_name = $('.session_fullname').val();

        var upload_work = "true";

        var form_data = new FormData();

        form_data.append("assign_id", assign_id);
        form_data.append("assign_name", assign_name);
        form_data.append("assign_taker_id", assign_taker_id);
        form_data.append("assign_taker_name", assign_taker_name);
        form_data.append("work_file", work_file);
        form_data.append("classcode", folderclass_classcode);
        form_data.append("upload_work", upload_work);

        for (var pair of form_data.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }

        $.ajax({
            url: "backend/folderassign_back.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                alert("Success");
                location.reload();
                thisClicked.closest('.upload_work_wrapper').
                    html('<button type="submit" class="show_upload_assign_btn" name="show_btn">Upload Work</button>');
            }
        });

    });

    /*Show edit work btns */
    $(document).on('click', '.edit_work_btn', function () {

        var thisClicked = $(this);
        var assign_id = thisClicked.val();
        thisClicked.closest('.upload_work_wrapper').
            html('<input type="file" class="btn upload_edited_work" name="upload_edited_work">\
                <input type="hidden" class="hiddenassign_id" name="hiddenassign_id" value="'+ assign_id + '">\
                <button type="submit" class="upload_edit_work_btn" name="hide_btn">Upload</button>\
                <button type="submit" class="cancel_edit_work_btn" name="cancel_edit_work_btn" value="'+ assign_id +'">Cancel</button>');
    });


    $(document).on('click', '.cancel_edit_work_btn', function () {

        var thisClicked = $(this);
        var assign_id = thisClicked.val();
        thisClicked.closest('.upload_work_wrapper').
            html('<button type="submit" class="edit_work_btn" name="edit_work_btn" value="'+ assign_id + '">Edit Work</button>');

    });

    $(document).on('click', '.upload_edit_work_btn', function (e) {

        e.preventDefault();

        var thisClicked = $(this);

        var work_file = $('.btn.upload_edited_work').prop('files')[0];
        var assign_id = $('.hiddenassign_id').val();
        var assign_name = thisClicked.closest('.upload_work_wrapper').closest('.assignment_content').find('.hiddenassign_name').val();

        var folderclass_classcode = $('.folderclass_classcode').val();

        var assign_taker_id = $('.session_id').val();
        var assign_taker_name = $('.session_fullname').val();

        var upload_edit_work = "true";

        var form_data = new FormData();

        form_data.append("assign_id", assign_id);
        form_data.append("assign_name", assign_name);
        form_data.append("assign_taker_id", assign_taker_id);
        form_data.append("assign_taker_name", assign_taker_name);
        form_data.append("work_file", work_file);
        form_data.append("classcode", folderclass_classcode);
        form_data.append("upload_edit_work", upload_edit_work);

        // for (var pair of form_data.entries()) {
        //     console.log(pair[0] + ', ' + pair[1]);
        // }

        $.ajax({
            url: "backend/folderassign_back.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                // console.log(response);
                alert("Success");
                location.reload();
            }
        });

    });


    $(document).on('click', '.create_assignment_btn', function () {

        var thisClicked = $(this);
        thisClicked.closest('.main_content_btn').find('.main_content_wrapper').
            html('<div class="creator_wrapper">\
                    <div class="creator_boxes">\
                        <span>Enter Assignment Name</span>\
                        <input type="text" class="assign_name" name="assign_name">\
                    </div>\
                    <div class="creator_boxes">\
                        <span>Enter Assignment Description</span>\
                        <textarea class="assign_desc" name="assign_desc" id="assign_desc" cols="23" rows="2"></textarea>\
                    </div>\
                    <div class="creator_boxes">\
                        <span>Enter Assignment File Name Label</span>\
                        <input type="text" class="assign_file_name" name="assign_file_name">\
                    </div>\
                    <div class="creator_boxes">\
                        <span>Upload File Here</span>\
                        <input type="file" class="assign_file" name="assign_file" id="upload">\
                    </div>\
                    <div class="creator_btn">\
                        <button name="upload" class="upload_btn">Upload</button>\
                        <button name="cancel" class="cancelupload_btn">Cancel</button>\
                    </div>\
                </div>\
            <script>\
            $("textarea").each(function () {\
                this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");\
                }).on("input", function () {\
                this.style.height = "auto";\
                this.style.height = (this.scrollHeight) + "px";\
                });\
            </script>\
        ');
    });

    $(document).on('click', '.cancelupload_btn', function () {

        var thisClicked = $(this);
        thisClicked.closest('.main_content_btn').find('.main_content_wrapper').
            html('<button class="create_assignment_btn">Create Assignment</button>\
        ');
    });

    $(document).on('click', '.upload_btn', function (e) {
        e.preventDefault();

        var thisClicked = $(this);

        var assign_name = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_name').val();
        var assign_desc = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_desc').val();
        var assign_file_name = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_file_name').val();
        var assign_file = $('.assign_file').prop('files')[0];
        var folderclass_classcode = $('.folderclass_classcode').val();

        var uploader = "true";

        var form_data = new FormData();

        form_data.append("assign_name", assign_name);
        form_data.append("assign_desc", assign_desc);
        form_data.append("assign_file_name", assign_file_name);
        form_data.append("assign_file", assign_file);
        form_data.append("classcode", folderclass_classcode);
        form_data.append("uploadbtn", uploader);

        // for (var pair of form_data.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]); 
        // }

        $.ajax({
            url: "backend/folderassign_back.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                alert("Success");
                location.reload();
                thisClicked.closest('.main_content_btn').find('.main_content_wrapper').
                    html('<button class="create_assignment_btn">Create Assignment</button>\
            ');
            }
        });

    });

    $(document).on('click', '.btn.edit', function (e) {

        e.preventDefault();
        $(window).scrollTop(tempScrollTop);

        var thisClicked = $(this);
        var emptytext = "";

        var assign_id = thisClicked.val();
        var assign_name = thisClicked.closest('.options').closest('.assignment_content').find('.hiddenassign_name').val();
        var assign_desc = thisClicked.closest('.options').closest('.assignment_content').find('.hiddenassign_desc').val();
        if (!thisClicked.closest('.options').closest('.assignment_content').find('.hiddenassign_filename').val()) {
            var assign_filename = emptytext;

        } else {

            var assign_filename = thisClicked.closest('.options').closest('.assignment_content').find('.hiddenassign_filename').val();
        }

        var createassign_btn = $('.main_content_wrapper');
        createassign_btn.html('<div class="creator_wrapper">\
                                    <div class="creator_boxes">\
                                        <span>Enter Assignment Name</span>\
                                        <input type="text" class="assign_name" name="assign_name" value = "'+ assign_name + '">\
                                    </div>\
                                    <div class="creator_boxes">\
                                        <span>Enter Assignment Description</span>\
                                        <textarea class="assign_desc" name="assign_desc" id="assign_desc" cols="23" rows="2">'+ assign_desc + '</textarea>\
                                    </div>\
                                    <div class="creator_boxes">\
                                        <span>Enter Assignment File Name Label</span>\
                                        <input type="text" class="assign_file_name" name="assign_file_name" value = "'+ assign_filename + '">\
                                    </div>\
                                    <div class="creator_boxes">\
                                        <span>Upload File Here</span>\
                                        <input type="file" class="assign_file" name="assign_file" id="upload">\
                                    </div>\
                                    <div class="creator_btn">\
                                        <button name="save" class="save_btn" value = "'+ assign_id + '">Save</button>\
                                        <button name="cancel" class="cancelupload_btn">Cancel</button>\
                                    </div>\
                                </div>\
                            <script>\
                            $("textarea").each(function () {\
                                this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");\
                                }).on("input", function () {\
                                this.style.height = "auto";\
                                this.style.height = (this.scrollHeight) + "px";\
                                });\
                            </script>\
                            ');
    });

    $(document).on('click', '.save_btn', function (e) {
        e.preventDefault();

        var thisClicked = $(this);
        var emptytext = "";

        var assign_id = thisClicked.val();
        var assign_name = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_name').val();
        var assign_desc = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_desc').val();

        var folderclass_classcode = $('.folderclass_classcode').val();

        if (!thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_file').val()) {
            var assign_file = emptytext;
        }
        else {
            var assign_file = $('.assign_file').prop('files')[0];
        }

        if (!thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_file_name').val()) {
            var assign_filename = emptytext;
        }
        else {
            var assign_filename = thisClicked.closest('.creator_btn').closest('.creator_wrapper').find('.assign_file_name').val();
        }

        var editor = "true";

        var form_data = new FormData();

        form_data.append("assign_id", assign_id);
        form_data.append("assign_name", assign_name);
        form_data.append("assign_desc", assign_desc);
        form_data.append("assign_file_name", assign_filename);
        form_data.append("assign_file", assign_file);
        form_data.append("classcode", folderclass_classcode);
        form_data.append("edit_btn", editor);

        $.ajax({
            url: "backend/folderassign_back.php",
            type: "POST",
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                alert(response);
                thisClicked.closest('.main_content_btn').find('.main_content_wrapper').
                    html('<button class="create_assignment_btn">Create Assignment</button>\
            ');
            }
        });


    });

    $(document).on('click', '.btn.delete', function () {

        var thisClicked = $(this);

        var assign_id = thisClicked.val();
        var folderclass_classcode = $('.folderclass_classcode').val();

        var data = {
            'assign_id': assign_id,
            classcode: folderclass_classcode,
            'delete_btn': true
        };

        $.ajax({
            url: "backend/folderassign_back.php",
            type: "POST",
            data: data,
            success: function (response) {
                alert("Success");
                location.reload();
            }
        });




    });

    $(document).on('click', '.edit_score', function () {

        $('.assign_takers_editor').html("");
        var thisClicked = $(this);
        thisClicked.html(" ");

        var assign_id = thisClicked.closest(".edit_btn_wrapper").find('.hiddenassign_id').val();

        var assign_name = thisClicked.closest(".edit_btn_wrapper").find('.hiddenassign_name').val();
        var assign_taker_id = thisClicked.val();
        var assign_taker_name = thisClicked.closest(".edit_btn_wrapper").find('.hiddenassign_taker_name').val();
        var asssign_taker_score = thisClicked.closest(".edit_btn_wrapper").find('.hiddenassign_taker_score').val();

        $('.assign_takers_editor').append('<div class="creator_wrapper">\
                                                <div class="creator_boxes">\
                                                    <span>Assignment Name</span>\
                                                    <input type="text" class="assign_name" name="assign_name" value="'+ assign_name +'" disabled>\
                                                </div>\
                                                <div class="creator_boxes">\
                                                    <span>Assignment Taker Name</span>\
                                                    <input type="text" class="assign_taker_name" name="assign_taker_name" value="'+ assign_taker_name +'" disabled>\
                                                </div>\
                                                <div class="creator_boxes">\
                                                    <span>Taker Score</span>\
                                                    <input type="number" class="assign_taker_score" name="assign_taker_score" value='+ asssign_taker_score +'>\
                                                </div>\
                                                <div class="creator_boxes">\
                                                    <input type="hidden" class="hiddenassign_id" name="hiddenassign_id" value='+ assign_id +'>\
                                                </div>\
                                                <div class="creator_btn">\
                                                    <button name="save" class="update_btn" value="'+ assign_taker_id +'">Update</button>\
                                                    <button name="cancel" class="cancel_score" name="cancel_score">Cancel</button>\
                                                </div>\
                                            </div>\
                                            ');

    });

    $(document).on('click', '.cancel_score', function () {

        $('.assign_takers_editor').html("");
        location.reload();

    });

    $(document).on('click', '.update_btn', function () {

        var thisClicked = $(this);
        var assign_taker_id = thisClicked.val();

        var assign_id = thisClicked.closest(".creator_btn").closest('.creator_wrapper').find('.hiddenassign_id').val();
        var assign_name = thisClicked.closest(".creator_btn").closest('.creator_wrapper').find('.assign_name').val();
        var assign_taker_name = thisClicked.closest(".creator_btn").closest('.creator_wrapper').find('.assign_taker_name').val();
        var asssign_taker_score = thisClicked.closest(".creator_btn").closest('.creator_wrapper').find('.assign_taker_score').val();

        var folderclass_classcode = $('.folderclass_classcode').val();

        var data = {
            "update_btn": true,
            "assign_id": assign_id,
            "assign_name": assign_name,
            "assign_taker_id": assign_taker_id,
            "assign_taker_name": assign_taker_name,
            "asssign_taker_score": asssign_taker_score,
            "classcode": folderclass_classcode
        };

        $.ajax({
            type: "POST",
            url: "backend/folderassign_back.php",
            data: data,
            success: function (response){
                alert("Success");
                location.reload();
            }
   
         });



    });

    $(document).on('click', '.view_assign_takers_btn', function () {

        var thisBtn = $(this);

        var assign_takers_table = $('.assignment_takers');
        var assignment_wrapper = $('.assignment_wrapper');

        assign_takers_table.toggle();
        assignment_wrapper.toggle();

        if(thisBtn.html() == "View Takers"){

            thisBtn.html("Hide Takers");

        }else{

            thisBtn.html("View Takers");

        }
        

    });
    

});


