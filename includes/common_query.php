<?php
    // this module is for queries and functions that will be used in many places

    // check whether an artist is alredy in a database
    // returns the ID of the artist if exists, 0 if it does not, -1 if an error occurs
    function getArtistID($conn, $name) {
        $query = "SELECT artist_id FROM artist WHERE artist_name LIKE '${name}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['artist_id'];
        } else {
            return 0;
        }
    }

    function getArtistIsBand($conn, $artistID) {
        $query = "SELECT artist_is_band FROM artist WHERE artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (count($row) === 1) {
            return $row['artist_is_band'];
        } else {
            // error
            return -1;
        }
    }

    function getAlbumID($conn, $artistID, $albumName) {
            $query = "SELECT artist_album.album_id, album.album_name FROM artist_album "
                . "JOIN album ON artist_album.album_id = album.album_id " 
                . "WHERE artist_album.artist_id = ${artistID}";
            $result = mysqli_query($conn, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['album_name'] === $albumName) {
                        return $row['album_id'];
                    }
                }
            } else {
                return 0;
            }
    }
?>
