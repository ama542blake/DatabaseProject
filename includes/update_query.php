<?php
    /* This module used to send UPDATE queries to the DB*/
    /*
        Alright, this is going to be really complicated: 
        (1) We need to break all relationships in artist_song and album_song
        when a song is updated, the recreate these relationships with the newly entered values
            (a) this means we will need the IDs of the artist, album, and song
        (2) if the artist(s), album(s), prducer(s), genre(s) are not already in the database,
        they need to be added
            (2a) this will require a list of these values
        (3) as of now, this only supports single valued artists, albums, producers, and genres, so
        this will need to be updated to accommodate multiple later, which is on the TODO list
    */

    /* update queries */
    function updateSong($conn, $songID, $artistName, $isband, $bandMembership, $albumName, $producer, $genre) {
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
        
        // break all relationships
        deleteArtistSong($conn, $songID);
        deleteAlbumSong($conn, $albumID, $songID);
        
        // check to make sure entries for the user entered data exist, if not, insert them
        if ($getArtistID($conn, $artistName)) { // artist in DB
            
        } else {
            insertArtist();
        }
        
        $query = updateSongStringBuilder($conn, $songID);
        mysqli_query($conn, $query);
    }

    function updateSongStringBuilder($conn, $songID, $producerID, $genreID) {
        $query = "UPDATE song SET song_artist = $"
               . "WHERE song_id = ${songID}";
    }
    
    function deleteArtistSong($conn, $songID) {
        $query = "DELETE FROM artist_song WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    function deleteAlbumSong($conn, $songID) {
        $query = "DELETE FROM album_song WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    //function to use as reference
//    function insertSongStringBuilder($songName, $producerID, $genreID) {
//        $query = "INSERT INTO song (song_name";
//        if ($producerID) {$query .= ", song_producer";}
//        if ($genreID) {$query .= ", song_genre";}
//        $query .= ") VALUES ('${songName}'";
//        if ($producerID) {$query .= ", ${producerID}";}
//        if ($genreID) {$query .= ", ${genreID}";}
//        $query .= ")";
//        return $query;
//    }
?>