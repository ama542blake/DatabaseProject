<?php 
    include_once("common_query.php");
    
    /* This module used to send UPDATE queries to the DB*/
    // TODO: as of now, this only supports single valued artists, albums, producers, and genres, so
        //this will need to be updated to accommodate multiple later

    /* update queries */

    function updateArtist($conn, $artistID, $updateUserID) {
        $query = "UPDATE artist SET artist_update_user = ${updateUserID}, artist_update_time = CURRENT_TIMESTAMP WHERE artist_id = ${artistID}";
        mysqli_query($conn, $query);
    }
    function updateAlbum ($conn, $albumID, $albumArtworkArtistID, $albumReleasedYear, $updateUserID) {
        if (!($albumArtworkArtistID)) {$albumArtworkArtistID = "NULL";}
        if (!($albumReleasedYear)) {$albumReleasedYear = "NULL";}
        $query = "UPDATE album SET album_artwork_artist = ${albumArtworkArtistID},  album_released_year = ${albumReleasedYear}, album_update_user = ${updateUserID}, album_update_time = CURRENT_TIMESTAMP WHERE album_id = ${albumID}";
        mysqli_query($conn, $query);
    }

    function updateSong($conn, $songID, $producerID, $genreID, $updateUserID) {
        if (!($producerID)) {$producerID = "NULL";}
        if (!($genreID)) {$genreID = "NULL";}
        $query = "UPDATE song SET song_producer = ${producerID}, song_genre = ${genreID}, song_update_user = ${updateUserID}, song_update_time = CURRENT_TIMESTAMP WHERE song_id = ${songID}";
        mysqli_query($conn, $query);
    }

    function deleteBandMembership($conn, $bandID, $memberID) {
        $query = "DELETE FROM band_membership WHERE band_id = ${bandID} AND solo_id = ${memberID}";
        mysqli_query($conn, $query);
    }

        function getUpdateInformation($conn, $id, $entityType) {
            switch ($entityType) {
                case "artist":
                    $query = "SELECT artist_update_user, artist_update_time FROM artist WHERE artist_id = ${id}";
                    break;
                case "album":
                    $query = "SELECT album_update_user, album_update_time FROM album WHERE album_id = ${id}";
                    break;
                case "song":
                    $query = "SELECT song_update_user, song_update_time FROM song WHERE song_id = ${id}";
                    break;
                default:
                    return;
            }
            
            $result = mysqli_query($conn, $query);
            if ($result) {
                        return mysqli_fetch_assoc($result);
                    } else {
                        return NULL;
                    }
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