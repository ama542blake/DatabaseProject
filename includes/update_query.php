<?php 
    include_once("common_query.php");
    
    /* This module used to send UPDATE queries to the DB*/
    // TODO: as of now, this only supports single valued artists, albums, producers, and genres, so
        //this will need to be updated to accommodate multiple later

    /* update queries */
    function updateArtist($conn, $artistID, $artistIsBand) {
        $query = "UPDATE artist SET artist_is_band = ${artistIsBand} WHERE artist_id = ${artistID}";
        mysqli_query($conn, $query);
    }
    function updateAlbum ($conn, $albumID, $albumArtworkArtist, $albumReleasedYear){
        $query = "UPDATE album SET album_artwork_artist = ${albumArtworkArtist},  album_released_year = ${albumReleasedYear} WHERE album_id = ${albumID}";
        mysqli_query($conn, $query);
    }

    function updateSong($conn, $songID, $producerID, $genreID) {
        if (!($producerID)) {$producerID = "NULL";}
        if (!($genreID)) {$genreID = "NULL";}
        $query = "UPDATE song SET song_producer = ${producerID}, song_genre = ${genreID} WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    /* deletion quries */

    function deleteArtistAlbum($conn, $albumID) {
        $query = "DELETE FROM artist_album WHERE album_id = ${albumID}";
        mysqli_query($conn, $query);
    }
    
    function deleteArtistSong($conn, $songID) {
        $query = "DELETE FROM artist_song WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    /* idType specifies whether album ID ($idType === "album") is being used 
    to delete, or song ID ($idType === "song"); */
    function deleteAlbumSong($conn, $id, $idType) {
        if ($idType === "song") {
            $query = "DELETE FROM album_song WHERE song_id = ${id}";
        } else if ($idType === "album") {
            $query = "DELETE FROM album_song WHERE album_id = ${id}";
        } else {
            return;
        }
        mysqli_query($conn, $query);
    }
?>