<?php
    include_once('includes/common_query.php');
    include_once('includes/connection.php');

    if (isset($_POST['song_name']) && isset($_POST['artist_name']) && isset($_POST['album_name'])) {
        // gather names and ID's of things
        $songName = $_POST['song_name'];
        $artistName = $_POST['artist_name'];
        $artistID = getArtistID($conn, $artistName);
        $albumName = $_POST['album_name'];
        $albumID = getAlbumID($conn, $artistID, $albumName);
        // determine the id of the producer
        if (isset($_POST['producer_name'])) {
            $producerName = $_POST['producer_name'];
            $producerID = getProducerID($conn, $producerName);
            if (!$producerID) {
                $producerID = insertProducer($conn, $producerName);
            }
        } else {
            $producerID = NULL;
        }
        // determine the id of the genre
        if (isset($_POST['genre'])) {
            $genreName = $_POST['genre'];
            $genreID = getGenreID($conn, $genreName);
            echo $genreName;
            if (!$genreID) {
                $genreID = insertGenre($conn, $genreName);
            }
        } else {
            $genreID = NULL;
        }
        
        
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
            insertSong($conn, $songName, $albumID, $artistID, $producerID, $genreID);
        }
    }

?>