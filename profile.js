function loadData(googleUser) {
    document.getElementById("signedIn").style.display = "block";
    $("#fname_display").html("Currently signed in as: " + googleUser.getBasicProfile().getEmail());
}