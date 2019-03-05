<?php
    // this module is for queries and functions that will be used in many places

    /* artist queries */

    // inserts an artist in to the database
    function insertArtist($conn, $name, $isband) {
        $query = "INSERT INTO artist (artist_name, artist_is_band) VALUES ('${name}', '${isband}')";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }

    // returns the id of the artist if exists; returns 0 if the artist isn't found
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

    // check if the artist is a band or solo artist; return -1 for error
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


    /* album queries */

    // inserts an album in to the database
    // note that the artist id is passed in to call insertArtistAlbum so the relationship can be created
    // automatically when an album is inserted
    // TODO change value for artwork_artist from 0 to $artwork_artist_id once that is figured out
    function insertAlbum($conn, $artistID, $albumName, $artworkArtistID, $releasedYear) {
        $query = insertAlbumStringBuilder($albumName, $artworkArtistID, $releasedYear);
        $result = mysqli_query($conn, $query);
        if ($result) {
            $albumID = mysqli_insert_id($conn);
            insertArtistAlbum($conn, $artistID, $albumID);
            return $albumID;
        }
    }

    // creates the query for inserting an album based on what variables are null/not null
    function insertAlbumStringBuilder($albumName, $artworkArtistID,  $releasedYear) {
        $query = "INSERT INTO album (album_name";
        if ($artworkArtistID) {$query .= ", album_artwork_artist";}
        if ($releasedYear) {$query .= ", album_released_year";}
        $query .= ") VALUES ('${albumName}'";
        if ($artworkArtistID) {$query .= ", ${artworkArtistID}";}
        if ($releasedYear) {$query .= ", ${releasedYear}";}
        $query .= ")";
        return $query;
    }

    // returns the id of the album if exists; returns 0 if the album isn't found
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

    // inserts an artwork artist in to the database
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

    // returns the id of the album artwrok artist if exists; returns 0 if the artwork artist isn't found
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

    /* song queries */

    // insert a song in to the database
    // note that the id of the album and artist are passed so that the relationships among the song/artist.album can 
    // automatically be created
    function insertSong($conn, $songName, $albumID, $artistID, $producerID) {
        $query = insertSongStringBuilder($songName, $producerID);
        $result = mysqli_query($conn, $query);
        if ($result) {
            $songID = mysqli_insert_id($conn);
            insertArtistSong($conn, $artistID, $songID);
            insertAlbumSong($conn, $albumID, $songID);
            return $songID;
        }
    }

    function insertSongStringBuilder($songName, $producerID) {
        $query = "INSERT INTO song (song_name";
        if ($producerID) {$query .= ", song_producer"}
        $query .= ") VALUES ('${songName}'";
        if ($producerID) {$query .= ", ${producerID}"}
        $query .= ")";
        return $query;
    }
    

    // inserts a producer in to the database
    function insertProducer($conn, $name) {
        $query = "INSERT INTO producer (producer_name) " 
               . "VALUES ${name}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_insert_id($conn);
        } else {
            return 0;
        }
     }

    // returns the id of the producer if exists; returns 0 if the producer isn't found
    function getProducerID($conn, $name) {
        $query = "SELECT producer_id FROM producer WHERE producer_name LIKE '${name}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['producerID'];
        } else {
            return 0;
        }
    }

    /* relationship queries */

    // create a relationship between an artist and an album
    function insertArtistAlbum($conn, $artistID, $albumID) {
        $query = "INSERT INTO artist_album (artist_id, album_id) "
               . "VALUES (${artistID}, ${albumID})";
        mysqli_query($conn, $query);
    }
    
    // create a relationship between an artist and an song
    function insertArtistSong($conn, $artistID, $songID) {
        $query = "INSERT INTO artist_song (artist_id, song_id) "
               . "VALUES (${artistID}, ${songID})";
        mysqli_query($conn, $query);
    }

    // create a relationship between an album and a song
    function insertAlbumSong($conn, $albumID, $songID) {
        $query = "INSERT INTO album_song (album_id, song_id) "
               . "VALUES (${albumID}, ${songID})";
        mysqli_query($conn, $query);
    }

    // create a relationship between a solo artist and band
    function insertMembership($conn, $bandID, $soloID) {
        $query = "INSERT INTO band_membership (band_id, solo_id) VALUES ($bandID, $soloID)";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }
?>
