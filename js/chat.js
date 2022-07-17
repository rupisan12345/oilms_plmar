const form = document.querySelector(".chat_typing_area"),
chatfield = form.querySelector(".chat_field"),
chatsend = form.querySelector("button"),
chatbox = document.querySelector(".chat_box");

form.onsubmit = (e)=> {
    e.preventDefault();
}

chatsend.onclick = ()=> {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "backend/message_chat_send.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                chatfield.value = "";
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

chatbox.onmouseover = ()=>{
    chatbox.classList.add("active");
}

chatbox.onmouseleave = ()=>{
    chatbox.classList.remove("active");
}


setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "backend/message_chat_receive.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatbox.innerHTML = data; 
                if(!chatbox.classList.contains("active")){
                    scrollToBottom();
                  }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    }, 500);

function scrollToBottom(){

    chatbox.scrollTop = chatbox.scrollHeight;
}