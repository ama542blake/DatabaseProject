<?php
    include_once('includes/connection.php');
    include_once('includes/common_query.php');
    include_once('add_artist_to_db.php');

error_reporting(E_ALL);

    if ((isset($_POST['album_name'])) && (isset($_POST['album_artist']))) {
        $albumName = $_POST['album_name'];
        $artistName = $_POST['album_artist'];
        
        // check if an album with the name exists
        // TODO need to make add artwork artist search and insert
        $artistID = getArtistID($conn, $artistName);
        if ($artistID) {
            if (getAlbumID($conn, $artistID, $albumName)) {
                echo " -- 1";
                echo "${albumName} by ${artistName} is already in the database.";
            } else {
                echo " -- 2";
                insertAlbum($conn, $artistID, $albumName);
            }
        } else {
            // album is not in database if the artist is not in the database
            // (can't have an album if there was no artist to create it)
            // TODO find a way to allow user to choose whether the artist is a band or solo, for now assume yes
            echo " -- 3";
            $newArtistID = insertArtist($conn, $name, 1);
            insertAlbum($conn, $newArtistID, $albumName);
        }
    }

    // TODO change value for artwork_artist from 0 to $artowrk_artist_id once that is figured out
    function insertAlbum($conn, $artistID, $albumName) {
        $query = "INSERT INTO album (album_name)"
               . " VALUES ('${albumName}')";
        $result = mysqli_query($conn, $query);
        echo "<br>";
        var_dump($result);
        if ($result) {
            $albumID = mysqli_insert_id($conn);
            insertArtistAlbum($conn, $artistID, $albumID);
        }
    }

    function insertArtistAlbum($conn, $artistID, $albumID) {
        $query = "INSERT INTO artist_album (artist_id, album_id)"
               . "VALUES (${artistID}, ${albumID})";
        mysqli_query($conn, $query);
    }
?>