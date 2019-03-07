<?php
    include_once('includes/common_query.php');
    include_once('includes/connection.php');

    if (isset($_POST['song_name']) && isset($_POST['artist_name']) && isset($_POST['album_name'])) {
        $songName = $_POST['song_name'];
        $artistName = $_POST['artist_name'];
        $albumName = $_POST['album_name'];

        if (isset($_POST['producer_name'])) {
            $producerName = $_POST['producer_name'];
            $producerID = getProducerID($conn, $producerName);
            if (!$producerID) {
                insertProducer($conn, $producerName);
            }
        } else {
            $producerID = NULL;
        }
        
        $artistID = getArtistID($conn, $artistName);
        $albumID = getAlbumID($conn, $artistID, $albumName);
        
        if (!$artistID) { // artist and therefore album are not in database, so create artist then album
            // TODO: allow user to decide if the artist is a band, for now assume band
            $artistID = insertArtist($conn, $artistName, 1);
            // TODO: find a way to allow user to enter in album released year and artwork artist
            $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL);
        } else { // artist is in database
            if (!$albumID) { // album and therefore song are not in database, so create album
                $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL);
            }
        }
        // finally, check if song is in database, if not, create it
        if (getSongID($conn, $songName, $albumID, $artistID)) {
            // song is in database
            echo "${songName} by ${artistName} on the album ${albumName} is already in the database.";
        } else {
            insertSong($conn, $songName, $albumID, $artistID, $producerID);
        }
    }

?>