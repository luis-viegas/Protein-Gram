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
