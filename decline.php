<?php

        $toDelete = $_POST['email'];
        $email = $_COOKIE['email'];

        $server = "sql206.epizy.com";
        $user = "epiz_28508303";
        $pass = "Y3MeBiyLaW0BM";
        $database = "epiz_28508303_database";

        $conn = new mysqli($server, $user, $pass);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($database);


        $query = "SELECT requests FROM users WHERE email='".$email."'";

        $buddies = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $buddies = $row["requests"];
          }
        } else {
          echo "0 results";
        }

        $buddiesArray = explode(",", $buddies);
        if (($key = array_search($toDelete, $buddiesArray)) !== false) {
        unset($buddiesArray[$key]);
        }
        $buddies = join(",", $buddiesArray);

        $query = "UPDATE users SET requests = '".$buddies."' WHERE email='".$email."'";

        $results = $conn->query($query);

        $conn->close();
?>