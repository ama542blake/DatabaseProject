<?php
    // this module is for queries and functions that will be used in many places

    /* user queries */
    // return the ID if the user exists, 0 if not
    function getUserID($conn, $username) {
        $query = "SELECT user_id FROM user WHERE user_username = '${username}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['user_id'];
        } else {
            return 0;
        }
    }

    // return the name of the user given the user's ID
    function getUserName($conn, $userID) {
        $query = "SELECT user_username FROM user WHERE user_id = '${userID}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['user_username'];
        } else {
            return "";
        }
    }
    
    function userPasswordIsCorrect($conn, $userID, $password) {
        $query = "SELECT COUNT(*) AS count FROM user WHERE user_id = ${userID} AND user_pword = '${password}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['count'];
        } else {
            return -1;
        }
    }

    function userEmailAlreadyUsed($conn, $userEmail) {
        $query = "SELECT COUNT(*) AS count FROM user WHERE user_email = '${userEmail}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['count'];
        } else {
            return -1;
        }
    }

    /* artist queries */

    // inserts an artist in to the database
    function insertArtist($conn, $name, $isband, $addUserID) {
        $query = "INSERT INTO artist (artist_name, artist_is_band, artist_update_user) VALUES ('${name}', ${isband}, ${addUserID})";
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
        if ($result) {
            return mysqli_fetch_assoc($result)['artist_is_band'];
        } else {
            // error
            return -1;
        }
    }

    // get the name of the artist given the artist ID
    // TODO: replace this function in all places it is used with a function
    // which takes an array of IDs and returns an array, order preserved,
    // of all of the names of the artists called getArtistNames (NOTE the added s)
    function getArtistName($conn, $artistID) {
        $query = "SELECT artist_name FROM artist WHERE artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['artist_name'];
        } else {
            // error
            return array(); // needs to return an iterable object
        }
    }


    /* album queries */

    // inserts an album in to the database
    // note that the artist id is passed in to call insertArtistAlbum so the relationship can be created
    // automatically when an album is inserted
    // TODO change value for artwork_artist from 0 to $artwork_artist_id once that is figured out
    function insertAlbum($conn, $artistID, $albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID) {
        $query = insertAlbumStringBuilder($albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID);
        $result = mysqli_query($conn, $query);
        if ($result) {
            $albumID = mysqli_insert_id($conn);
            insertArtistAlbum($conn, $artistID, $albumID);
            return $albumID;
        }
    }
    
    // like insertAlbum, but for albums with multiple contributing artists; user for mutliple artists creating an album,
    // since a new album is only created once, not for each artist, and insertAlbum would insert a new one for each
    function insertMultipleArtistAlbum($conn, $artistIDs, $albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID) {
        $albumQuery = insertAlbumStringBuilder($albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID);
        $albumResult = mysqli_query($conn, $albumQuery);
        if ($albumResult) {
            $albumID = mysqli_insert_id($conn);
            foreach($artistIDs as $artistID) {
                insertArtistAlbum($conn, $artistID, $albumID);
            }
            return $albumID;
        } else {
            return 0;
        }
    }

    // creates the query for inserting an album based on what variables are null/not null
    function insertAlbumStringBuilder($albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID) {
        $query = "INSERT INTO album (album_name";
        if ($artworkArtistID) {$query .= ", album_artwork_artist";}
        if ($producerID) {$query .= ", album_producer";}
        if ($releasedYear) {$query .= ", album_released_year";}
        if ($addUserID) {$query .= ", album_update_user";}
        $query .= ") VALUES ('${albumName}'";
        if ($artworkArtistID) {$query .= ", ${artworkArtistID}";}
        if ($producerID) {$query .= ", ${producerID}";}
        if ($releasedYear) {$query .= ", ${releasedYear}";}
        if ($addUserID) {$query .= ", ${addUserID}";}
        $query .= ")";
        return $query;
    }

    // returns the id of the album if exists; returns 0 if the album isn't found
    function getAlbumID($conn, $artistID, $albumName) {
        $query = "SELECT album_id FROM view_artist_album WHERE album_name = '${albumName}' AND artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_id'];
        } else {
            return 0;
        }
    }

    // get the name of the album given the album ID
    function getAlbumName($conn, $albumID) {
        $query = "SELECT album_name FROM album WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_name'];
        } else {
            // error
            return NULL;
        }
    }
    
    // get the producer of the album given the album ID
    function getAlbumProducerID($conn, $albumID) {
        $query = "SELECT album_producer FROM album WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_producer'];
        } else {
            // error
            return NULL;
        }
    }

    // get the year of the album given the album ID
    function getAlbumYear($conn, $albumID) {
        $query = "SELECT album_released_year FROM album WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_released_year'];
        } else {
            // error
            return NULL;
        }
    }

    // returns the ID and track number of all songs on an album
    function getAlbumSongIDs($conn, $albumID) {
        // used to index $idArray
        $resultCount = 0;
        // will be used to return all ID's from the query
        $idArray = array();
        
        $query = "SELECT song_id, song_track_number FROM album_song WHERE album_id = ${albumID} ORDER BY song_track_number";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = array(
                                            'song_id' => $row['song_id'],
                                            'track_number' => $row['song_track_number']
                                        );
                $resultCount++;
            }
            return $idArray;
        } else {
            // error
            return array(); // results of function must implement countable, so return empty array
        }
    }
    
    // get the ID of the artist that did the artwork for the album
    //TODO make this allow multiple artwork artists per album (will require changes to DB structure)
    function getAlbumArtworkArtistID($conn, $albumID) {
        $query = "SELECT album_artwork_artist FROM album WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_artwork_artist'];
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

    // returns the id of the album artwork artist if exists; returns 0 if the artwork artist isn't found
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

    // returns the name of an artwork artist given the ID
    function getArtworkArtistName($conn, $id) {
        $query = "SELECT artwork_artist_name FROM artwork_artist WHERE artwork_artist_id = ${id}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['artwork_artist_name'];
        } else {
            return 0;
        }
    }

    function getAlbumAndArtistByArtworkArtist($conn, $artworkArtistID) {
        $query = "SELECT * FROM view_artworkartist_album_artist WHERE artwork_artist_id = ${artworkArtistID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $resultArray = array();
            $previousAlbumID = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $albumID = $row['album_id'];
                // array is first indexed by album, then per album, each artist is retrieved
                if ($albumID != $previousAlbumID) { //reset artist count when new album is reached
                    $artistCount = 0;
                    $previousAlbumID = $albumID;
                }    
                $resultArray[$albumID][$artistCount] = array(
                                                                'albumName' => $row['album_name'],
                                                                'artistID' => $row['artist_id'],
                                                                'artistName' => $row['artist_name']
                                                              );
                $artistCount++;
            }
            return $resultArray;
        } else {
            return array();
        }
    }

    /* song queries */

    // insert a song in to the database
    // note that the id of the album and artist are passed so that the relationships among the song/artist.album can 
    // automatically be created
    function insertSong($conn, $songName, $albumID, $artistID, $genreName, $trackNumber, $addUserID) {
        $query = insertSongStringBuilder($songName, $genreName, $addUserID);
        $result = mysqli_query($conn, $query);
        if ($result) {
            $songID = mysqli_insert_id($conn);
            insertArtistSong($conn, $artistID, $songID);
            insertAlbumSong($conn, $albumID, $songID, $trackNumber);
            return $songID;
        } else {
            return 0;
        }
    }

    // like insertSong, but for songs with multiple contributing artists; used for mutliple artists
    // creating a song since a new song is only created once, not for each artist, and insertAlbum
    //  would insert a new one for each
    function insertMultipleArtistSong($conn, $songName, $albumID, $artistIDs, $genreName, $trackNumber, $addUserID) {
        $query = insertSongStringBuilder($songName, $genreName, $addUserID);
        $result = mysqli_query($conn, $query);
        if ($result) {
            $songID = mysqli_insert_id($conn);
            foreach($artistIDs as $artistID) {
                insertArtistSong($conn, $artistID, $songID);
            }
            insertAlbumSong($conn, $albumID, $songID, $trackNumber);
            return $songID;
        } else {
            return 0;
        }
    }

    function insertSongStringBuilder($songName, $genreName, $addUserID) {
        $query = "INSERT INTO song (song_name";
        if ($genreName) {$query .= ", song_genre";}
        if ($addUserID) {$query .= ", song_update_user";}
        $query .= ") VALUES ('${songName}'";
        if ($genreName) {$query .= ", '${genreName}'";}
        if ($addUserID) {$query .= ", ${addUserID}";}
        $query .= ")";
        return $query;
    }

    // returns the id of the song if exists; returns 0 if the song isn't found
    function getSongID($conn, $name, $albumID) {
        $query = "SELECT song_id FROM view_artist_album_song WHERE song_name = '${name}' AND album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['song_id'];
        } else {
            return 0;
        }
    }

    // get the name of the song given the song ID
    function getSongName($conn, $songID) {
        $query = "SELECT song_name FROM song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['song_name'];
        } else {
            // error
            return NULL;
        }
    }

    function getSongTrackNumber($conn, $albumID, $songID) {
        $query = "SELECT song_track_number FROM album_song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['song_track_number'];
        } else {
            return 0;
        }
    }
    
    // get the ID of the genre(s) of a song
    // TODO: allow multiple genres for a song (will require changing DB sturcture)
    function getSongGenre($conn, $songID) {
        $query = "SELECT song_genre FROM song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['song_genre'];
        } else {
            return NULL;
        }
    }

    // get the ID of the producer(s) of a song
    // TODO: allow multiple producers for a song (will require changing DB sturcture)
    function getSongProducer($conn, $songID) {
        $query = "SELECT song_producer FROM song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['song_producer'];
        } else {
            return NULL;
        }
    }

    // inserts a producer in to the database
    function insertProducer($conn, $name) {
        $query = "INSERT INTO producer (producer_name) " 
               . "VALUES ('${name}')";
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
            return $row['producer_id'];
        } else {
            return 0;
        }
    }

    // get the name of the producer given the producer ID
    function getProducerName($conn, $producerID) {
        $query = "SELECT producer_name FROM producer WHERE producer_id = ${producerID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['producer_name'];
        } else {
            // error
            return NULL;
        }
    }

    function getAlbumAndArtistByProducer($conn, $producerID) {
        $query = "SELECT * FROM view_producer_album_artist WHERE producer_id = ${producerID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $resultArray = array();
            $previousAlbumID = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $albumID = $row['album_id'];
                // array is first indexed by album, then per album, each artist is retrieved
                if ($albumID != $previousAlbumID) { //reset artist count when new album is reached
                    $artistCount = 0;
                    $previousAlbumID = $albumID;
                }    
                $resultArray[$albumID][$artistCount] = array(
                                                                'albumName' => $row['album_name'],
                                                                'artistID' => $row['artist_id'],
                                                                'artistName' => $row['artist_name']
                                                              );
                $artistCount++;
            }
            return $resultArray;
        } else {
            return array();
        }
    }

    /* relationship queries */

    // create a relationship between an artist and an album
    function insertArtistAlbum($conn, $artistID, $albumID) {
        $query = "INSERT INTO artist_album (artist_id, album_id) "
               . "VALUES (${artistID}, ${albumID})";
        mysqli_query($conn, $query);
    }

    // get all artists that contributed to an album
    function getArtistIDsFromArtistAlbum($conn, $albumID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT artist_id FROM artist_album WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['artist_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return NULL;
        }
    }

    // get all albums an artist has contributed to
    function getAlbumIDsFromArtistAlbum($conn, $artistID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT album_id FROM artist_album WHERE artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['album_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return array();
        }
    }

    // checks to see if there is a relationship between an artist and album, given the artist ID and album name;
    // return the album ID if it does exist, 0 otherwise
    function getArtistIsOnAlbum($conn, $artistID, $albumName) {
        $query = "SELECT album_id FROM view_artist_album WHERE artist_id = ${artistID} AND album_name = '${albumName}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return mysqli_fetch_assoc($result)['album_id'];
        } else {
            return 0;
        }
    }

    // create a relationship between an artist and an song
    function insertArtistSong($conn, $artistID, $songID) {
        $query = "INSERT INTO artist_song (artist_id, song_id) "
               . "VALUES (${artistID}, ${songID})";
        mysqli_query($conn, $query);
    }

    // TODO: update getArtistIDsFromArtistSong to return artist name
    // so there is no need to requery the db to get their names
    // get all artists that contributed to a song
    function getArtistIDsFromArtistSong($conn, $songID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT artist_id FROM artist_song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['artist_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return NULL;
        }
    }

    // get all songs the artist has contributed to
    function getSongIDsFromArtistSong($conn, $artistID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT song_id FROM artist_song WHERE artist_id = ${artistID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['song_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return NULL;
        }
    }


    // create a relationship between an album and a song
    function insertAlbumSong($conn, $albumID, $songID, $trackNumber) {
        $query = "INSERT INTO album_song (album_id, song_id, song_track_number) "
               . "VALUES (${albumID}, ${songID}, ${trackNumber})";
        mysqli_query($conn, $query);
    }

    // get all albums a given song appears on
    function getAlbumIDsFromAlbumSong($conn, $songID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT album_id FROM album_song WHERE song_id = ${songID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['album_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return NULL;
        }
    }

    // get all songs that appear on an album
    function getSongIDsFromAlbumSong($conn, $albumID) {
        // used to index $idArray
        $resultCount = 0;
        // stores returned IDs from the query
        $idArray = array();
        
        $query = "SELECT song_id FROM album_song WHERE album_id = ${albumID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $idArray[$resultCount] = $row['song_id'];
                $resultCount++;
            }
            return $idArray;
        } else {
            return NULL;
        }
    }
    
    // create a relationship between a solo artist and band
    function insertMembership($conn, $bandID, $soloID) {
        $query = "INSERT INTO band_membership (band_id, solo_id) VALUES ($bandID, $soloID)";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }

    // for artists that are solo, get bands they are in 
    function getArtistBands($conn, $soloID) {
        // use this to index $bandArray
        $bandCount = 0;
        $bandArray = array();
        
        //TODO add validation to ensure that soloID is actually a solo artist
        $query = "SELECT band_id FROM band_membership WHERE solo_id = ${soloID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bandArray[$bandCount] = $row['band_id'];
                $bandCount++;
            }
            return $bandArray;
        } else {
            return NULL;
        } 
    }

    // for artists that are bands, get the band members 
    function getBandMembers($conn, $bandID) {
        // use this to index $memberArray
        $memberCount = 0;
        $memberArray = array();
        
        //TODO add validation to ensure that bandID is actually a band
        $query = "SELECT solo_id FROM band_membership WHERE band_id = ${bandID}";
        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $memberArray[$memberCount] = $row['solo_id'];
                $memberCount++;
            }
            return $memberArray;
        } else {
            return NULL;
        } 
    }

    // queries view_artist_album_song to get all combinations for an artist
    // and simply returns the mysqli_result object, where the client that calls this
    // function may use it to retrieve whatever information is required in its own way
    function getArtistAlbumSongByArtist($conn, $artistID) {
        $query = "SELECT * FROM view_artist_album_song WHERE artist_id = ${artistID} ORDER BY album_id, song_track_number";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        } else {
            return NULL;
        }
    }
?>
