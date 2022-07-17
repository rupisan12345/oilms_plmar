$(document).ready(function () {


    hide_quiz_takers();

    function hide_quiz_takers() {

        $('.quiz_takers').hide();

    }

    $(document).on('click', '.view_quiz_takers_btn', function () {

        var thisBtn = $(this);

        var quiz_takers_table = $('.quiz_takers');
        var quiz_content = $('.quiz_content');

        quiz_takers_table.toggle();
        quiz_content.toggle();

        if(thisBtn.html() == "View Takers"){

            thisBtn.html("Hide Takers");

        }else{

            thisBtn.html("View Takers");

        }
        

    });



});