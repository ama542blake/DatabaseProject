<?php
    include_once('includes/connection.php');

echo "NAME ${_POST['artist_name']}";
echo "ISBAND ${_POST['isband']}";
    if (isset($_POST['artist_name'])) {
        $name = $_POST['artist_name'];
        $isband = $_POST['isband'];
        $query = "INSERT INTO artist (artist_name, artist_is_band) VALUES ('${name}', '${isband}')";
        mysqli_query($conn, $query);
    }
?>