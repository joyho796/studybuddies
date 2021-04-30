/* Open when someone clicks on the span element */
function openNav() {
  document.getElementById("mobileNav").style.width = "100%";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
  document.getElementById("mobileNav").style.width = "0%";
}

function onSignIn(googleUser) {
    console.log(googleUser.getBasicProfile())
    document.getElementById("signedIn").style.display = "block";
}