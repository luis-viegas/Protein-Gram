
function addEventListeners(){
    const message_form = document.getElementById("message_form");

    if(message_form!=null){
        message_form.addEventListener('submit', sendMessage);
    }
    
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
}


function sendMessage(event){ 
    const message_text = document.getElementById("message_text");
    const url = window.location.pathname;
    sendAjaxRequest('post', url, {text: message_text.value},null); 
    
    event.preventDefault();
}




// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var url = window.location.pathname.split('/');
var message_place = -1;
for(let i = 0; i< url.length; i++){
    if(url[i]=="messages") message_place=i;
}
console.log(message_place);
if(message_place>0){
    let chat_id =url[message_place+1];
    var pusher = new Pusher('74dd497c4f6d496c2f8d', {
    cluster: 'eu',
    forceTLS: true
    });

    var channel = pusher.subscribe('chat' + chat_id);
    channel.bind('update', function(data) {
        let newMessage = document.createElement('div');
        console.log(data.message.text);
        if(message_place ==3){
            if(url[2] == data.message.user_id){
                newMessage.className = "message self";
            }else{
                newMessage.className = "message sender";
            }   
        }else{
            if(document.getElementById("profile-icon-link")== data.message.user_id){
                newMessage.className = "message self";
            }else{
                newMessage.className = "message sender";
            }
        }

        newMessage.innerText = data.message.text;
        let message_form = document.getElementsByClassName('message-history')[0];
        message_form.appendChild(newMessage);
    });
}



addEventListeners();


function runFuntions(){

    var friendsTab = document.getElementById("friends-list-tab");
    var friendRequestsTab = document.getElementById("friend-requests-tab");

    var friendsPage = document.getElementById("friends-list");
    var friendRequestsPage = document.getElementsByClassName("friend-requests-list");

    friendsTab.onclick = function(){

        console.log(friendRequestsPage);

        // friendRequestsPage.style = "display: none";
        friendsPage.style = "display: block";

        if (!friendsTab.classList.contains("active-tab")){
            friendsTab.classList.add("active-tab");
            friendRequestsTab.classList.remove("active-tab");
        }
    }

    friendRequestsTab.onclick = function(){
        friendsPage.style = "display: none";
        friendRequestsPage.style = "display: block";

        if (!friendRequestsTab.classList.contains("active-tab")){
            friendRequestsTab.classList.add("active-tab");
            friendsTab.classList.remove("active-tab");
        }
    }

}



window.onload = runFuntions();






