
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
    sendAjaxRequest('post', url.concat("/send"), {text: message_text.value},null); 
    event.preventDefault();
    message_text.value='';
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
        let user_url = document.getElementById("profile-icon-link").href.split('/');
        let user_id = user_url[user_url.length-1];
        if(message_place ==3){
            if(url[2] == data.message.user_id){
                newMessage.className = "message self";
            }else{
                newMessage.className = "message sender";
            }   
        }else{
            if(user_id== data.message.user_id){
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

    var notifBell = document.getElementsByClassName("fa-bell")[0];
    var notifTab = document.getElementsByClassName("notifications")[0];

    notifBell.onclick = function(){
        if (notifTab.classList.contains("tab-open")){
            notifTab.classList.remove("tab-open");
            notifTab.classList.add("tab-closed");
        }
        else {
            notifTab.classList.remove("tab-closed");
            notifTab.classList.add("tab-open");
        }
    }

    if (window.location.href.indexOf("messages") > -1) {
        var messageHistory = document.getElementsByClassName("message-history")[0];
        var messageSendButton = document.getElementById("message_form").lastElementChild;

        var contactsMenu = document.getElementsByClassName("contacts-menu")[0];
        var messageHistory = document.getElementsByClassName("messages-page-messages")[0];
        var contactsList = document.getElementsByClassName("contacts-list")[0];
        var contactsListContacts = document.getElementsByClassName("contacts-list-contacts")[0];
        var contact = document.getElementsByClassName("contact");
         
        messageHistory.scrollTo(0, messageHistory.scrollHeight);

        messageSendButton.onclick = function(){
            messageHistory.scrollTo(0, messageHistory.scrollHeight);
        }

        contactsMenu.onclick = function(){
            
            if (contactsMenu.classList.contains("menu-closed")){
                
                contactsMenu.classList.remove("menu-closed");
                contactsMenu.classList.add("menu-open");

                messageHistory.classList.add("collapse-history");
                contactsList.classList.add("expand-contact-list");
                contactsListContacts.classList.add("expand-contact-list");
            }
            else {
                contactsMenu.classList.add("menu-closed");
                contactsMenu.classList.remove("menu-open");

                messageHistory.classList.remove("collapse-history");
                contactsList.classList.remove("expand-contact-list");
                contactsListContacts.classList.remove("expand-contact-list");
            }

            
        }

        contact.addEventListener("click", function(){
            console.log("CLICKED CONTACT");

            messageHistory.classList.remove("collapse-history");
            contactsList.classList.remove("expand-contact-list");
        });
    }

    if (window.location.href.indexOf("friends") > -1){
        var friendsTab = document.getElementById("friends-list-tab");
        var friendRequestsTab = document.getElementById("friend-requests-tab");

        var friendsPage = document.getElementById("friends-list");
        var friendRequestsPage = document.getElementById("friend-requests-list");

        friendsTab.onclick = function(){
    
            friendRequestsPage.style = "display: none";
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

}

window.onload = runFuntions();






