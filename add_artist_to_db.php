<?php
    include_once('includes/connection.php');
    if (isset($_POST['artist_name'])) {
        $name = $_POST['artist_name'];
        $isband = $_POST['isband'];
        $query = "INSERT INTO artist (artist_name, artist_is_band) VALUES ('${name}', '${isband}')";
        mysqli_query($conn, $query);
        echo "Artist added successfully, page will redirect after 5 seconds";
        sleep(5);
        header("Location: index.php");
    }
?>