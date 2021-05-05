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

        $byMajor = ($_POST['byMajor'] == 'on');
        $byGraduation = ($_POST['byGraduation'] == 'on');
        $bySchool = ($_POST['bySchool'] == 'on');
        $byAll = ($_POST['byAll'] == 'on');

        $server = "sql206.epizy.com";
        $user = "epiz_28508303";
        $pass = "Y3MeBiyLaW0BM";
        $database = "epiz_28508303_database";

        $conn = new mysqli($server, $user, $pass);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($database);

        $query = "SELECT buddies, major, school, graduation
        FROM users WHERE email='".$_COOKIE['email']."'";

        $buddies = "";
        $major = '';
        $school = '';
        $graduation = 0;

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $buddies = $row["buddies"];
            $major = $row["major"];
            $school = $row["school"];
            $graduation = $row["graduation"];
          }
        }

        $buddiesArray = explode(",", $buddies);

        $query = $query = "SELECT * FROM users";

        $displayQuery = '<br><br><strong>Showing results:</strong><br>';

        if ($byAll){
            $query = "SELECT * FROM users";
            $displayQuery = $displayQuery.'All buddies';
        } else {
            $filters = array();
            $filtersDisplay = array();
            if($byMajor) {
                array_push($filters, "major='".$major."'");
                array_push($filtersDisplay, "same major");
            }
            if($bySchool) {
                array_push($filters, "school='".$school."'");
                array_push($filtersDisplay, "same school");
            }
            if($byGraduation) {
                array_push($filters, "graduation='".$graduation."'");
                array_push($filtersDisplay, "same graduation year");

            }
            if(count($filters)>0){
                $query = "SELECT * FROM users WHERE ".join(" OR ", $filters);
                $displayQuery = $displayQuery."Buddies in the ".join(", ", $filtersDisplay);
            } else {
                $query = "SELECT * FROM users WHERE 0";
                $displayQuery = $displayQuery."No filters selected";
            }

        }


        $data = array();
        $matcher = array();

        $count = 0;
        $result = $conn->query($query);
        if ($result->num_rows > 1) {
            while($row = $result->fetch_assoc()) {
                if(!in_array($row["email"],$buddiesArray)){
                    if($row["email"]!=$_COOKIE["email"]){
                    $count++;
                    $user = "<div class='buddySummary' id='match".$row["email"]."'
                    onclick=\"openChat(event, '".$row["email"]."')\">";
                    $user = $user."<p><strong>".$row["username"]."</strong></p>";
                    $user = $user."<p style='font-size:14px;line-height:18px;'>".$row["school"].", Class of ".$row["graduation"]."<br>";
                    $user = $user."<i>".$row["major"]."</i></p></div>";
                    array_push($data, $user);
                    $match = "<div id='".$row["email"]."' class='buddyChat'>";
                    $match = $match."<img src=\"images/blue.png\" alt=\"chatbubbles\" style=\"width: 40%;\">
                    <br><br><br><p>You matched with <strong>".$row["username"]."</strong>.
                    <br>Would you like to become buddies?</p>";
                    $match = $match."<br><button onclick=\"addBuddy('".$row["email"]."','".$row["username"]."')\">send request</button>&nbsp&nbsp&nbsp
                    <button onclick=\"hideMatch('".$row["email"]."')\">hide match</button><br>";
                    $match = $match."</div>";
                    array_push($matcher, $match);
                    }
                }
            }
        } if ($count==0) {
            $user = "<div><br><br><br><p>Sorry, we couldn't find any buddies that match your requirements. Try changing your search parameters!</p></div>";
                    array_push($data, $user);
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
            <li id="buddiesNav" style="display: none"><a href="buddies.php" >My Buddies</a></li>
            <li id="findNav" style="display: none"><a href="find.php"style="background-color: rgba(62,169,223,0.1);font-weight: bold" >Find Buddies</a></li>
            <li><a href="about.html">About Us</a></li>
            <li id="signOutBttn" style="position:fixed; bottom: 20px;display:none"><button onclick="signOut()" style="width:200px">Sign Out</button></li>
        </ul>
    </div>

    <div id="mobile">
        <a href='index.html'><img src="images/home.png" alt="logo"></a>
        <a href='about.html'><img src="images/about.png" alt="logo"></a>
        <a href='buddies.php'><img src="images/messages.png" alt="logo"></a>
        <a href='find.php'><img src="images/search-active.png" alt="logo"></a>
        <a href='profile.php'><img src="images/profile.png" alt="logo"></a>

    </div>

    <div id="content">
        <button onclick="fullChat()" id="chatToggle">close</button>
        <div id="flex">

            <div id="buddiesList">
                <div class="buddySummary" onclick="openChat(event, 'filter')">
                    <p style='font-size:18px;line-height: 26px'><strong>Filter Results</strong></br></p>
                    <p style='font-size:15px;line-height:20px;'>Click to toggle how you want to find other buddies
                    <?php echo $displayQuery; ?>
                    </p>
                </div>
                <?php
                    for ($i = 0; $i < count($data); $i++){
                        echo $data[$i];
                    }
                ?>

            </div>

            <div id="chatWindows">
                <div class="chatbox" style='margin:0px'>
                <div id="filter" class="buddyChat" style="display: block;margin:0px">
                    <h3>I want to find all buddies that are: </h3>
                    <br>
                    <form method='post'>
                        <label class="container">In the same major as me
                          <input name='byMajor' type="checkbox">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">In the same class year as me
                          <input name='byGraduation' type="checkbox">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">In the same school as me
                          <input name='bySchool' type="checkbox">
                          <span class="checkmark"></span>
                        </label>
                        <label class="container">No preferences (find me all the buddies!)
                          <input name='byAll' type="checkbox">
                          <span class="checkmark"></span>
                        </label>
                        <br>
                        <input type="submit" value="Find buddies" id="button">
                    </form>
                <br><br>
                <img name='match' src="images/match.png" alt="img">
                <br><br><br>
                </div>

                <?php
                    for ($i = 0; $i < count($matcher); $i++){
                        echo $matcher[$i];
                    }
                ?>

            </div>

        </div>
    </div>
<script>
    function addBuddy(email,username) {
        var loggedIn = <?php echo json_encode('1'.$_COOKIE['email']);?>;
        if (loggedIn != '1'){
        $.ajax({
            type: "POST",
            url: "add.php",
            data: {email, email}
        }).done(function( data) {
            console.log( "Buddy Added" );
        });
        if (screen.width < 940){
            fullChat();
        }
        hideMatch(email);
        alert("You send a chat request to "+username);
        } else {
            alert("Please sign in to add buddies");
            if (screen.width < 940){
            fullChat();}
        }
    }
</script>
</body>

</html>