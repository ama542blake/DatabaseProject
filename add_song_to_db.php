<?php
    include_once('includes/common_query.php');
    include_once('includes/connection.php');

    if (isset($_POST['song_name']) && isset($_POST['artist_name']) && isset($_POST['album_name'])) {
        $songName = $_POST['song_name'];
        $artistName = $_POST['artist_name'];
        $albumName = $_POST['album_name'];
        if (isset($_POST['producer_name']) {
            $producerName = $_POST['producer_name'];
            $producerID = getProducerID($conn, $producerName);
            if (!$producerID) {
                insertProducer($conn, $producerName);
            }
        } else {
            $producerID = NULL;
        }
        
        // if artist in db, check if album is
        if (getArtist($conn, $artistName)) {
            // if album in db, proceed to adding song and relationships between artist and song
        } else { // artist and therefore album and song are not in database, so create all 3 and their relationships
            // TODO: allow user to decide if the artist is a band, for now assume band
            $artistID = insertArtist($conn, $artistName, 1);
            // TODO: find a way to allow user to enter in album released year and artwork artist
            $albumID = insertAlbum($conn, $albumName, $artistID, NULL, NULL);
            $songID = insertSong($conn, $songName, $albumID, $artistID, $producerID);
            
        }
    } 

?>