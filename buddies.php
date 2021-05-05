<!DOCTYPE html>

<head>
    <title>Study Buddies | Profile</title>
    <link href="style.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/jpg" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Study, Chat, Friends, College, School">
    <meta name="google-signin-client_id" content="231404018205-ns41e7jr23p8regdups02evhp9lk7iq0.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="profile.js"></script>
</head>

<body>
    <?php

        session_start();

        $_GET["email"] = $_COOKIE["email"];

        $server = "sql206.epizy.com";
        $user = "epiz_28508303";
        $pass = "Y3MeBiyLaW0BM";
        $database = "epiz_28508303_database";

        $conn = new mysqli($server, $user, $pass);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($database);

        $query = "SELECT username, buddies FROM users WHERE email='".$_COOKIE['email']."'";

        $buddies = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $_SESSION['name'] = $row['username'];
            $buddies = $row["buddies"];
          }
        }


        $buddiesArray = explode(",", $buddies);

        $query = "SELECT requests FROM users WHERE email='".$_COOKIE['email']."'";

        $requests = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $requests = $row["requests"];
          }
        }

        $requestsArray = explode(",", $requests);

        $query = "SELECT * FROM users";

        $data = array();
        $matcher = array();

        $rData = array();
        $rMatcher = array();


        if(!isset($_COOKIE['email'])){
            $signInMessage = "<br><br><br><i>Please sign in to view your chats</i>";
        } else {
            $signInMessage = '';
        }

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if (in_array($row["email"],$requestsArray)){
                    $user = "<div class='buddySummary' id='match".$row["email"]."'
                    onclick=\"openChat(event, '".$row["email"]."','".$_GET["email"]."', 1)\">";
                    $user = $user."<p><strong>Request from: ".$row["username"]."</strong></p>";
                    $user = $user."<p style='font-size:14px;line-height:18px;'>".$row["school"].", Class of ".$row["graduation"]."<br>";
                    $user = $user."<i>".$row["major"]."</i></p></div>";
                    array_push($rData, $user);
                    $match = "<div id='".$row["email"]."' class='buddyChat'>";
                    $match = $match."<div class='chatbox' id='chatbox".$row["email"]."'><div id='flex' style='flex-direction: column; height: 70vh;overflow-y: auto;margin-bottom: 20px'>";
                    $match = $match."<img src='images/blue.png' alt='img' style='width: 40%;'><br><br><br><p><strong>".$row["username"]."</strong> sent you a chat request!<br>
                        Would you like to accept and start chatting?</p>";
                    $match = $match."<br><div style='flex-direction:row'><button onclick=\"addBuddy('".$row["email"]."','".$row["username"]."')\">accept</button>&nbsp&nbsp&nbsp
                        <button onclick=\"declineBuddy('".$row["email"]."','".$row["username"]."')\">
                        decline</button></div>";
                    $match = $match."</div></div>";
                    $match = $match."</div>";
                    array_push($rMatcher, $match);
                }
                if(in_array($row["email"],$buddiesArray)){
                    if($row["email"]!=$_COOKIE["email"]){
                    $user = "<div class='buddySummary' id='match".$row["email"]."'
                    onclick=\"openChat(event, '".$row["email"]."','".$_GET["email"]."')\">";
                    $user = $user."<p><strong>".$row["username"]."</strong></p>";
                    $user = $user."<p style='font-size:14px;line-height:18px;'>".$row["school"].", Class of ".$row["graduation"]."<br>";
                    $user = $user."<i>".$row["major"]."</i></p></div>";
                    array_push($data, $user);
                    $match = "<div id='".$row["email"]."' class='buddyChat'><div class='topBar'><br><br><p style='margin:0px;line-height:26px'><strong>".$row["username"]."</strong></p><p style='margin:0px;font-size:16px;line-height:18px'>".$row["school"].", Class of ".$row["graduation"]."<br><i>".$row["major"]."</i></p><button id='delete".$row["email"]."' class='deleteButton' onclick=\"deleteBuddy('".$row["email"]."','".$row["username"]."')\" style='position:fixed;
                        right:12px;top:12px'>delete buddy</button></div>";
                    $match = $match."<div class='chatbox' id='chatbox".$row["email"]."'><div id='flex' style='flex-direction: column; height: calc(100vh - 268px);overflow-y: auto;margin-bottom: 20px'>";
                    $match = $match."<img src='images/loader.gif' alt='img' style='width: 40%;'><br><p>Loading your chat with <strong>".$row["username"]."</strong><br><br></p>";
                    $match = $match."</div></div><div id='scroll".$row["email"]."'></div><div class=\"chatInput\">
                        <form>
                        <input autocomplete='off' name='usermsg".$row["email"]."' type=text id='um".$row["email"]."' placeholder=\"Send a message\">
                        <input name=\"submitmsg".$row["email"]."\" type=\"submit\" id=\"sm".$row["email"]."\" value=\"Send\" style=\"display:none\">
                        </form>
                    </div>";
                    $match = $match."</div>";
                    array_push($matcher, $match);
                    }
                }
            }
        }

        $conn->close();
        ?>
    <div id="nav">
        <ul>
            <li>
                <img src="images/logo2.png" alt="logo" style="padding-top: 20px;padding-bottom:20px;width: 250px; height: 55px;">
            </li>
            <div class="g-signin2" data-onsuccess="onSignIn" style="padding:25px;padding-bottom: 28px"></div>
            <li><a href="index.html">Home</a></li>
            <li id="profileNav" style="display: none"><a href="profile.php">Profile</a></li>
            <li id="buddiesNav" style="display: none"><a href="buddies.php" style="background-color: rgba(62,169,223,0.1);font-weight: bold" >My Buddies</a></li>
            <li id="findNav" style="display: none"><a href="find.php">Find Buddies</a></li>
            <li><a href="about.html">About Us</a></li>
            <li id="signOutBttn" style="position:fixed; bottom: 20px;display:none"><button onclick="signOut()" style="width:200px">Sign Out</button></li>
        </ul>
    </div>

    <div id="mobile">
        <a href='index.html'><img src="images/home.png" alt="logo"></a>
        <a href='about.html'><img src="images/about.png" alt="logo"></a>
        <a href='buddies.php'><img src="images/messages-active.png" alt="logo"></a>
        <a href='find.php'><img src="images/search.png" alt="logo"></a>
        <a href='profile.php'><img src="images/profile.png" alt="logo"></a>

    </div>

    <div id="content">
        <button onclick="fullChat()" id="chatToggle">close</button>
        <div id="flex">

            <div id="buddiesList">
                <div style='border-bottom: 1px solid rgba(0,0,0,0.1);'>
                <br><br>
                <p><strong>Your Chats</strong></p>
                <br><br>
                </div>
                <?php
                    echo $signInMessage;
                    for ($i = 0; $i < count($rData); $i++){
                        echo $rData[$i];
                    }
                    for ($i = 0; $i < count($data); $i++){
                        echo $data[$i];
                    }
                ?>
            </div>

            <div id="chatWindows">

                <div class="buddyChat" style="display:block">
                    <div class="chatbox" style="height:100vh;margin:0px">
                    <br><br><br><br><br>
                    <h3>Open a chat to start chatting!</h3>
                    <br><br>
                    <img src="images/cny.png" alt="chatbubbles" style="width: 40%;">
                    <br><br><br>
                    <p><strong>Want to meet new buddies?</strong><br>
                        Go to the find buddies page to match with<br>
                        and meet new study buddies!</p>
                    <br><br>
                    </div>
                </div>
                <?php
                    for ($i = 0; $i < count($rMatcher); $i++){
                        echo $rMatcher[$i];
                    }
                    for ($i = 0; $i < count($matcher); $i++){
                        echo $matcher[$i];
                    }
                ?>

            </div>

        </div>
    </div>
    <script>
    function deleteBuddy(email,username) {
        if (confirm("Are you sure you want to delete "+username+"?")){
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: {email, email}
        }).done(function( data) {
            console.log( "Buddy Deleted" );
        });

        hideMatch(email);
        if (screen.width < 940){
        fullChat();}
        alert("You've deleted "+username);
        }
    }

    function addBuddy(email,username) {
        $.ajax({
            type: "POST",
            url: "accept.php",
            data: {email, email}
        }).done(function( data) {
            console.log( "Buddy Added" );
        });

        hideMatch(email);
        if (screen.width < 940){
        fullChat();}
        alert("You accepted "+username+"'s request");
        location.reload();
    }
    function declineBuddy(email,username) {
        $.ajax({
            type: "POST",
            url: "decline.php",
            data: {email, email}
        }).done(function( data) {
            console.log( "Buddy Added" );
        });

        hideMatch(email);
        if (screen.width < 940){
        fullChat();}
        alert("You declined "+username+"'s request");
        location.reload();
    }

    </script>
</body>

</html>