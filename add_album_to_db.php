<?php
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    error_reporting(E_ALL);

    if ((isset($_POST['album_name'])) && (isset($_POST['album_artist']))) {
        $albumName = $_POST['album_name'];
        $artistName = $_POST['album_artist'];
        $artworkArtistName = $_POST['album_artwork_artist'];
        $releasedYear = $_POST['album_year_released'];
        
        if ($artworkArtistName) {
            $artworkArtistID = getArtworkArtistID($conn, $artworkArtistName);
            if(!$artworkArtistID) {
                $artworkArtistID = insertArtworkArtist($conn, $artworkArtistName);
            }
        } else {
            $artworkArtistID = NULL;
        }
        
        // check if an album with the name exists
        // TODO need to make add artwork artist search and insert
        $artistID = getArtistID($conn, $artistName);
        if ($artistID) {
            if (getAlbumID($conn, $artistID, $albumName, $artworkArtistID)) {
                echo "${albumName} by ${artistName} is already in the database.";
            } else {
                echo insertAlbum($conn, $artistID, $albumName, $artworkArtistID, $releasedYear);
            }
        } else {
            // album is not in database if the artist is not in the database
            // (can't have an album if there was no artist to create it)
            // TODO find a way to allow user to choose whether the artist is a band or solo, for now assume yes
            $newArtistID = insertArtist($conn, $artistName, 1);
            echo insertAlbum($conn, $newArtistID, $albumName, $artworkArtistID, $releasedYear);
        }
    }   

?>