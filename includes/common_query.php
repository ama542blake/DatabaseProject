<?php
    include_once('connection.php'); // global $conn
    // this module is for queries and functions that will be used in many places

    // check whether an artist is alredy in a database
    // returns the ID of the artist if exists, 0 if it does not, -1 if an error occurs
    function getArtistID($name) {
        global $conn;
        $query = "SELECT artist_id FROM artist WHERE artist_name = '${name}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) === 0) {
            return 0;
        } else if (count($row) === 1) {
            return $row['artist_id'];
        } else {
            // error
            return -1;
        }
    }

    function getArtistIsBand($artistID) {
        global $conn;
        $query = "SELECT artist_is_band FROM artist WHERE artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) === 1) {
            return $row['artist_is_band'];
        } else {
            // error
            return -1;
        }
    }

?>