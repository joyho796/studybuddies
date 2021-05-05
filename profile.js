function loadData(googleUser) {
    document.cookie = "email=" + googleUser.getBasicProfile().getEmail();
    document.getElementById("profileNav").style.display = "block";
    document.getElementById("buddiesNav").style.display = "block";
    document.getElementById("findNav").style.display = "block";
    document.getElementById("signOutBttn").style.display = "block";

    $("#welcome").html("Hi " + googleUser.getBasicProfile().getGivenName()+"!");
    $("input[name=email]").val(googleUser.getBasicProfile().getEmail());
}