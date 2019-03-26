<?php 
    include_once("common_query.php");
    
    /* This module used to send UPDATE queries to the DB*/
    // TODO: as of now, this only supports single valued artists, albums, producers, and genres, so
        //this will need to be updated to accommodate multiple later

    /* update queries */
    function updateSong($conn, $songID, $artistName, $isband, $bandMembership, $albumName, $producerName, $genreName) {
        // check for the ID of the artist; insert if not in DB
        $artistID = getArtistID($conn, $artistName);
        if (!($artistID)) {
            $artistID = insertArtist($conn, $artistName, $isband);
             // need to create the relationship between the artist and their band if solo
            if (!($isband)) { // is solo
                if ($bandMembership) {
                    $bandID = getArtistID($conn, $bandMembership);
                    if (!($bandID)) {
                        $bandID = insertArtist($conn, $bandMembership, 1);
                    }
                    insertMembership($conn, $bandID, $artistID);
                }
            }
        }
        
        // check for the ID of the album insert if not in DB
        $albumID = getAlbumID($conn, $albumName);
        if (!($albumID)) {
            $albumID = insertAlbum($conn, $albumName);
        } 
        
        // check for the ID of the producer; insert if not in DB
        if ($producerName) {
            $producerID = getProducerID($conn, $producerName);
            if (!($producerID)) {
                $producerID = insertProducer($conn, $producerName);
            } 
        } else {
            $producerID = NULL;
        }
        
        // check for the ID of the genre; insert if not in DB
        if ($genreName) {
            $genreID = getGenreID($conn, $genreName);
            if (!($genreID)) {
                $genreID = insertGenre($conn, $genreName);
            } 
        } else {
            $genreID = NULL;
        }
        
        // break all relationships
        /* TODO: this is really inefficient because even if album/artist don't change, relationships are still destroyed and 
            recreated, so need to improve this */
        deleteArtistSong($conn, $songID);
        deleteAlbumSong($conn, $songID);
        
        // update song
        $songQuery = "UPDATE song SET song_producer = ${producerID}, song_genre = ${genreID}"
               . " WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
        
        // update relationships
        insertArtistSong($conn, $artistID, $songID);
        insertAlbumSong($conn, $albumID, $songID);
    }
    
    function deleteArtistSong($conn, $songID) {
        $query = "DELETE FROM artist_song WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    function deleteAlbumSong($conn, $songID) {
        $query = "DELETE FROM album_song WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }
?>