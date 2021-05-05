/* Open when someone clicks on the span element */
function openNav() {
  document.getElementById("mobileNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("mobileNav").style.width = "0%";
}

function onSignIn(googleUser) {
    document.cookie = "email=" + googleUser.getBasicProfile().getEmail();
    console.log(googleUser.getBasicProfile().getEmail()+" signed in.")
    document.getElementById("profileNav").style.display = "block";
    document.getElementById("buddiesNav").style.display = "block";
    document.getElementById("findNav").style.display = "block";
    document.getElementById("signOutBttn").style.display = "block";
}

function signOut() {
    document.cookie = "email=";
    gapi.auth2.getAuthInstance().signOut().then(function() {
        document.getElementById("profileNav").style.display = "none";
        document.getElementById("buddiesNav").style.display = "none";
        document.getElementById("findNav").style.display = "none";
        document.getElementById("signOutBttn").style.display = "none";
        alert("You're signed out. Please sign in order to access your account.");
    })
    location.href='index.html';
}

function hideMatch(email){
    summaryID = "match"+email;
    document.getElementById(summaryID).style.display = "none";
    document.getElementById(email).style.display = "none";

}

function fullChat(){
    direction = document.getElementById("chatToggle").innerHTML;
    num = document.getElementsByClassName("topBar").length;

    if (direction == "close") {

        document.getElementById("buddiesList").style.width = "0%";
        document.getElementById("chatWindows").style.width = "100%";
        document.getElementById("chatToggle").style.left = "250px";
        for(i = 0; i < num; i++){
        document.getElementsByClassName("topBar")[i].style.width = "calc(100vw - 250px)";
        document.getElementsByClassName("chatInput")[i].style.width = "calc(100vw - 250px)";}
        document.getElementById("chatToggle").innerHTML = "open";

    } else {
        if (screen.width < 940){
            document.getElementById("buddiesList").style.width = "100%";
            document.getElementById("chatWindows").style.width = "0%";
            for(i = 0; i < num; i++){
            document.getElementsByClassName("deleteButton")[i].style.display = "none";
            document.getElementsByClassName("topBar")[i].style.width = "calc(100vw)";
            document.getElementsByClassName("chatInput")[i].style.width = "calc(100vw)";}
            document.getElementById("chatToggle").style.display='none';
            document.getElementById("mobile").style.display='flex';
        } else {
            document.getElementById("buddiesList").style.width = "30%";
            document.getElementById("chatWindows").style.width = "70%";
            for(i = 0; i < num; i++){
            document.getElementsByClassName("topBar")[i].style.width = "calc(70% - 220px)";
            document.getElementsByClassName("chatInput")[i].style.width = "calc(70vw - 170px)";}
            document.getElementById("chatToggle").style.left = "calc(180px + 30%)";
            document.getElementById("chatToggle").innerHTML = "close";
        }
    }
}



function openChat(evt, name, user, request) {
    var path = window. location. pathname;
    var page = path. split("/"). pop();
    document.getElementById("mobile").style.display = "none";
    document.getElementById("chatToggle").style.display = "block";
    if(page=="buddies.php" && request != 1){

        document.getElementById("delete"+name).style.display = "block";



        $(document).ready(function() {

            submitMsg = "#sm".name;
            userMsg = "#um".name;


            $(document).submit(function() {
            users = [];
            users.push(name);
            users.push(user);
            filename = users.sort().join("");

            logURL = "chatlogs/";
            logURL += filename;
            logURL += ".html";

            var clientmsg = document.getElementById("um"+name).value;
            $.post("post.php", { text: clientmsg, url: logURL});
            document.getElementById("um"+name).value = "";
            return false;
            });

        });
        setInterval(loadLog, 1000);
    }


    function loadLog() {

        users = [];
        users.push(name);
        users.push(user);
        filename = users.sort().join("");

        toOpen="chatbox"+name;
        elem = document.getElementById(toOpen);
        oldHeight = elem.scrollHeight;

        logURL = "chatlogs/";
        logURL += filename;
        logURL += ".html";

        $.ajax({
            url: logURL,
            cache: false,
            success: function (html) {
                elem.innerHTML = html;
                if (elem.scrollHeight > oldHeight){
                document.getElementById("scroll"+name).scrollIntoView({behavior:'smooth'});}
            }
        });

    }

    var i, buddyChat, buddySummary;
    buddyChat = document.getElementsByClassName("buddyChat");
    for (i = 0; i < buddyChat.length; i++) {
    buddyChat[i].style.display = "none";
    }
    buddySummary = document.getElementsByClassName("buddySummary");
    for (i = 0; i < buddySummary.length; i++) {
    buddySummary[i].style.backgroundColor = "rgba(0,0,0,0)";
    }
    document.getElementById(name).style.display = "block";
    evt.currentTarget.style.backgroundColor = "rgba(0,0,0,0.1)";
    if (screen.width < 940) {
        document.getElementById("buddiesList").style.width = "0%";
        document.getElementById("chatWindows").style.width = "100%";
        document.getElementById("chatToggle").innerHTML = "open";

    }


}
