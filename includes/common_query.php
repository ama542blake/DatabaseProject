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

    // inserts an artist in to the database
    function insertArtist($conn, $name, $isband) {
        $query = "INSERT INTO artist (artist_name, artist_is_band) VALUES ('${name}', '${isband}')";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }

    // inserts a band membership record in the band_membership table
    function insertMembership($conn, $bandID, $soloID) {
        $query = "INSERT INTO band_membership (band_id, solo_id) VALUES ($bandID, $soloID)";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
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

    // TODO change value for artwork_artist from 0 to $artwork_artist_id once that is figured out
    function insertAlbum($conn, $artistID, $albumName, $artworkArtistID) {
        if ($artworkArtistID) {
            $query = "INSERT INTO album (album_name, album_artwork_artist)"
               . " VALUES ('${albumName}', '${artworkArtistID}')";
            $result = mysqli_query($conn, $query);
            } else { // query without an artwork artist id
                $query = "INSERT INTO album (album_name)"
                       . " VALUES ('${albumName}')";
                $result = mysqli_query($conn, $query);
                echo "<br>";
                var_dump($result);
            }
        if ($result) {
            $albumID = mysqli_insert_id($conn);
            insertArtistAlbum($conn, $artistID, $albumID);
            return $albumID;
        }
    }

    function insertArtistAlbum($conn, $artistID, $albumID) {
        $query = "INSERT INTO artist_album (artist_id, album_id) "
               . "VALUES (${artistID}, ${albumID})";
        mysqli_query($conn, $query);
    }

    function getArtworkArtistID($conn, $name) {
        $query = "SELECT artwork_artist_id FROM artwork_artist WHERE artwork_artist_name LIKE '${name}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['artwork_artist_id'];
        } else {
            return 0;
        }
    }

    function insertArtworkArtist($conn, $name) {
        $query = "INSERT INTO artwork_artist (artwork_artist_name) "
               . "VALUES ('${name}')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_insert_id($conn);
        } else {
            return 0;
        }
    } 
?>
