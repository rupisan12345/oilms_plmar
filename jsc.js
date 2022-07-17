const btn = document.querySelector('#btn');
const btn1 = document.querySelector('#btn1');
const sidebar = document.querySelector(".navbar_wrapper");

function mobileMenu() {
    sidebar.classList.toggle('mobile');
};

function inactive() {

    btn.classList.toggle('mobileoff');
    btn1.classList.toggle('mobile');

};

btn.addEventListener('click', mobileMenu);
btn.addEventListener('click', inactive);

btn1.addEventListener('click', mobileMenu);
btn1.addEventListener('click', inactive);


const plusbtn = document.querySelector('#dash');
const xbtn = document.querySelector('#dash1');

const dashbtns = document.querySelector(".dash_main-btn");
const dashtooltip = document.querySelector(".dash_main_icon-tooltip");


function showbtns(e) {

    e.stopPropagation();

    if (dashbtns.style.opacity == "0") {
        dashbtns.style.opacity = "1";
        plusbtn.style.display = "none";
        xbtn.style.display = "inline-block";
        dashbtns.style.pointerEvents = "auto";

    }
    else {

        dashbtns.style.opacity = "0";
        dashtooltip.style.opacity = "0";
        plusbtn.style.display = "inline-block";
        xbtn.style.display = "none";
        dashbtns.style.pointerEvents = "none";

    }


};

function showTooltip() {
    dashtooltip.style.opacity = "1";
}

function hideTooltip() {
    dashtooltip.style.opacity = "0";
}

plusbtn.addEventListener("mouseover", showTooltip);
plusbtn.addEventListener("mouseout", hideTooltip);
plusbtn.addEventListener('click', showbtns);


const bodyWrapper = document.querySelector(".body-wrapper");

const dashcreateClass = document.querySelector(".create_class-btn");
const createclass_form = document.getElementById("createclassform");
const create_classpopupWrapper = document.querySelector(".create_class_popup-box");
const createclass_cancel = document.querySelector(".createclass_cancel");

const dashjoinClass = document.querySelector(".join_class-btn");
const joinclass_form = document.getElementById("joinclassform");
const join_classpopupWrapper = document.querySelector(".join_class_popup-box");

const dashconstructRoom = document.querySelector(".construct_room-btn");
const constructroom_popupWrapper = document.querySelector(".construct_room-box");
const cancel_Room = document.querySelector(".cancel_room");

const showcreate_popup1 = () => {

    bodyWrapper.classList.add('popup');
    create_classpopupWrapper.style.display = 'block';

    if (join_classpopupWrapper.style.display == 'block') {

        join_classpopupWrapper.style.display = 'none';

    }else if(constructroom_popupWrapper.style.display == 'block'){

        constructroom_popupWrapper.style.display = 'none';

    } else {

        return

    }

}

dashcreateClass.addEventListener('click', showcreate_popup1);

const showcreate_popup2 = () => {

    bodyWrapper.classList.add('popup');
    join_classpopupWrapper.style.display = 'block';

    if (create_classpopupWrapper.style.display == 'block') {

        create_classpopupWrapper.style.display = 'none';

    }else if(constructroom_popupWrapper.style.display == 'block'){

        constructroom_popupWrapper.style.display = 'none';

    } else {

        return

    }

}

dashjoinClass.addEventListener('click', showcreate_popup2);

const showcreate_popup3 = () => {

    bodyWrapper.classList.add('popup');
    constructroom_popupWrapper.style.display = 'block';

    if (create_classpopupWrapper.style.display == 'block') {

        create_classpopupWrapper.style.display = 'none';

    }else if (join_classpopupWrapper.style.display == 'block') {

        join_classpopupWrapper.style.display = 'none';

    } else {

        return

    }
}

dashconstructRoom.addEventListener('click', showcreate_popup3);

const cancel_createclass = () => {

    create_classpopupWrapper.style.display = 'none';
    bodyWrapper.classList.remove('popup');
    createclass_form.reset();

}

createclass_cancel.addEventListener('click', cancel_createclass);

const cancel_room = () => {

    var meeting_id = document.getElementsByClassName("room_code");
    meeting_id[0].value = "";
    constructroom_popupWrapper.style.display = 'none';
    bodyWrapper.classList.remove('popup');
    
}

cancel_Room.addEventListener('click', cancel_room);


window.addEventListener('mouseup', function (event) {

    if (event.target.closest(".join_class_popup-box") || event.target.closest(".create_class_popup-box") || event.target.closest(".construct_room-box")) {

        dashbtns.style.opacity = '0';
        plusbtn.style.display = "inline-block";
        xbtn.style.display = "none";
        return

    } else if (event.target.closest(".dash_main-btn")) {

        return

    }
    else {


        plusbtn.style.display = "inline-block";
        xbtn.style.display = "none";
        dashbtns.style.opacity = '0';
        dashbtns.style.pointerEvents = "none";

        join_classpopupWrapper.style.display = 'none';
        create_classpopupWrapper.style.display = 'none';
        constructroom_popupWrapper.style.display = 'none';

        bodyWrapper.classList.remove('popup');

        createclass_form.reset();
        joinclass_form.reset();

    }

});


























