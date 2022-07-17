$(document).ready(function () {


    hide_test_takers();

    function hide_test_takers() {

        $('.test_takers').hide();

    }

    $(document).on('click', '.view_test_takers_btn', function () {

        var thisBtn = $(this);

        var test_takers_table = $('.test_takers');
        var test_content = $('.test_content');

        test_takers_table.toggle();
        test_content.toggle();

        if(thisBtn.html() == "View Takers"){

            thisBtn.html("Hide Takers");

        }else{

            thisBtn.html("View Takers");

        }
        

    });



});