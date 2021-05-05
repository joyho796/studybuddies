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
    <style>
        #header{
            padding-top: 70px;
            padding-bottom: 120px;
        }
    </style>
</head>

<body>
    <?php

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

        $query = "DELETE FROM users WHERE email='".$_POST["email"]."'";
        $result = $conn->query($query);


        $query = "INSERT INTO users (email, username, school, graduation, major)
            VALUES ('".$_POST["email"]."','".$_POST["username"]."','".$_POST["school"]."','".
            $_POST["graduation"]."','".$_POST["major"]."');";

        if ($_POST["email"] != "") {
            $results = $conn->query($query);
        }

        $query = "SELECT * FROM users WHERE email='".$_GET["email"]."'";

        $data = array();

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($data, $row["email"],$row["username"],$row["school"],
                    $row["graduation"],$row["major"],);
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
            <li id="profileNav" style="display: none"><a href="profile.php"style="background-color: rgba(62,169,223,0.1);font-weight: bold">Profile</a></li>
            <li id="buddiesNav"><a href="buddies.php">My Buddies</a></li>
            <li id="findNav" style="display: none"><a href="find.php">Find Buddies</a></li>
            <li><a href="about.html">About Us</a></li>
            <li id="signOutBttn" style="position:fixed; bottom: 20px;display:none"><button onclick="signOut()" style="width:200px">Sign Out</button></li>
        </ul>
    </div>

    <div id="mobile">
        <a href='index.html'><img src="images/home.png" alt="logo"></a>
        <a href='about.html'><img src="images/about.png" alt="logo"></a>
        <a href='buddies.php'><img src="images/messages.png" alt="logo"></a>
        <a href='find.php'><img src="images/search.png" alt="logo"></a>
        <a href='profile.php'><img src="images/profile-active.png" alt="logo"></a>

    </div>

    <div id="content">
        <div id="header">
            <h1 id="welcome">Your Profile</h1>
            <p>
                Tell us a little about yourself so we can <br>
                match you with your perfect study buddy
            </p>
            <div class="g-signin2" data-onsuccess="loadData">
            </div>
        </div>

        <div>
            <br><br><br>
            <p>We recommend you fill out as much information as you can we can best match you with other buddies</p><br>
            <p>Note that your email will remain private but other users will be able to see your username, school, graduation year, and major</p>
            <br><br><br>
            <form method="post" onsubmit="return validate()">
                <table>
                    <tr>
                        <td>Email (cannot change): </td>
                        <td><input name="email" type="text" placeholder="Your Google account, you cannot change this"readonly></td>
                    </tr>
                    <tr>
                        <td>Username<sup>*</sup>: </td>
                        <td><input name="username" type="text" placeholder="This is the name that will be displayed to your buddies"></td>
                    </tr>
                    <tr>
                        <td>School: </td>
                        <td><input name="school" type="text" placeholder="The name of your college or university"></td>
                    </tr>
                    <tr>
                        <td>Graduation Year: </td>
                        <td><input name="graduation" type="text" placeholder="e.g. 2022, 2025, etc."></td>
                    </tr>
                    <tr>
                        <td>Major: </td>
                        <td><input name="major" type="text" placeholder="Your primary major"></td>
                    </tr>
                </table>
                <script language="javascript">

                function validate(){

                    // validate name to see if its valid
                    var nameRegex = /^(?![0-9]+$)(?=[a-zA-Z0-9-]{5,20}$)[a-zA-Z0-9]+(-[a-zA-Z0-9]+)*$/;
                    if(!$("input[name='username']").val()||!$("input[name='username']").val().match(nameRegex)){
                        alert("Please enter a valid username\n")
                    }

                    // validate graduation year using regex to see if its valid
                    var yearRegex = /^(20|20)\d{2}$/;
                    if(!$("input[name='graduation']").val()|| $("input[name='graduation']").val().length!=4){
                        alert("Please enter a valid graduation year")
                    }

                    //Reject input if validation fails
                    if (submit_accept == false) {
                        return false;
                    }

                    return true;
                }
                </script>

                <input type="submit" value="Update my information" id="button">
            <br><br><br>
            </form>
        </div>

        <div id="footer">
            <br><br>
            <div id="flex">
                <p>
                <a href="about.html">ABOUT</a>&nbsp|&nbsp
                <a href="contact.html">CONTACT</a>&nbsp|&nbsp
                <a href="help.html">DONATE</a>
                </p>
            </div>
            <br><br>
            <p style="font-size: 14px">&copy 2021 Study Buddies and Team Too</p>
            <br><br>
        </div>
    </div>

    <script>
        data = <?php echo json_encode($data); ?>;
        $("input[name=username]").val(data[1]);
        $("input[name=school]").val(data[2]);
        $("input[name=graduation]").val(data[3]);
        $("input[name=major]").val(data[4]);
    </script>
</body>

</html>