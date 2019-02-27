<?php 
    $db_username = "root";
    $db_password = "";
    $db_name = "music_site";
    // use $conn in mysqli_query
    $conn = mysqli_connect("localhost", $db_username, $db_password, $db_name);
    
    if ($conn->connect_error) {
        echo "<h1>Failled to connect to database: terminating</h1>";
        die("Program terminated");
    }
?>