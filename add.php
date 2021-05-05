<?php

        $toAdd = $_POST['email'];
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


        $query = "SELECT buddies FROM users WHERE email='".$email."'";

        $buddies = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $buddies = $row["buddies"];
          }
        } else {
          echo "0 results";
        }

        $buddiesArray = explode(",", $buddies);
        array_push($buddiesArray, $toAdd);
        $buddies = join(",", $buddiesArray);

        $query = "UPDATE users SET buddies = '".$buddies."' WHERE email='".$email."'";

        $results = $conn->query($query);


        $query = "SELECT requests FROM users WHERE email='".$toAdd."'";

        $requests = "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $requests = $row["requests"];
          }
        } else {
          echo "0 results";
        }

        $requestsArray = explode(",", $requests);
        if(!in_array($email, $requestsArray)){
        array_push($requestsArray, $email);}
        $requests = join(",", $requestsArray);

        $query = "UPDATE users SET requests = '".$requests."' WHERE email='".$toAdd."'";

        $results = $conn->query($query);

        $newFileNames = array();
        array_push($newFileNames, $email);
        array_push($newFileNames, $toAdd);
        sort($newFileNames);
        $newFileName = join("", $newFileNames);
        $new = fopen("chatlogs/".$newFileName.".html", "w");
        fwrite($new, "");
        fclose($new);

        $conn->close();
?>