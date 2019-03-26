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
    function updateSong($conn, $artists, $albums, $producer, $genre) {
        
    }

    function updateSongStringBuilder($artists, $albums, $producer, $genre) {}
    
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