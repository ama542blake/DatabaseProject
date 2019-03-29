<?php
    include_once('includes/common_query.php');
    include_once('includes/connection.php');
    session_start();
    
    if (isset($_POST['song_name']) && isset($_POST['artist_name']) && isset($_POST['album_name']) && isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id'];
        
        // gather names and ID's of things
        $songName = mysqli_real_escape_string($conn, $_POST['song_name']);
        $artistName = mysqli_real_escape_string($conn, $_POST['artist_name']);
        $artistID = getArtistID($conn, $artistName);
        $albumName = mysqli_real_escape_string($conn, $_POST['album_name']);
        $albumID = getAlbumID($conn, $artistID, $albumName);
        
        // determine the track number that it is on the album
        if (isset($_POST['song_track_number'])) {
            $trackNumber = $_POST['song_track_number'];
        } else {
            // must be string for proper insertion querying in addAlbumSong
            $trackNumber = 'NULL';
        }
        
        // determine the id of the producer; need to check if it's set and nonempty
        if (isset($_POST['producer_name']) && ($_POST['producer_name'])) {
            $producerName = mysqli_real_escape_string($conn, $_POST['producer_name']);
            $producerID = getProducerID($conn, $producerName);
            if (!($producerID)) {
                $producerID = insertProducer($conn, $producerName);
            }
        } else {
            $producerID = NULL;
        }
        // determine the id of the genre; need to check if its set and nonempty
        if (isset($_POST['genre']) && ($_POST['producer_name'])) {
            $genreName = mysqli_real_escape_string($conn, $_POST['genre']);
            $genreID = getGenreID($conn, $genreName);
            if (!$genreID) {
                $genreID = insertGenre($conn, $genreName);
            }
        } else {
            $genreID = NULL;
        }
        
        if (!($artistID)) { // artist and therefore album are not in database, so create artist then album
            // TODO: allow user to decide if the artist is a band, for now assume band
            $artistID = insertArtist($conn, $artistName, 1, $userID);
            // TODO: find a way to allow user to enter in album released year and artwork artist
            $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL, $userID);
        } else { // artist is in database
            if (!$albumID) { // album and therefore song are not in database, so create album
                $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL, $userID);
            }
        }
        // finally, check if song is in database, if not, create it
        if (getSongID($conn, $songName, $albumID)) {
            // song is in database
			header( "refresh:2; url=add_song.php" ); //displays message before redirecting
            echo "${songName} by ${artistName} on the album ${albumName} is already in the database. Redirecting...";
			exit; //redirects back to song page
        } else {
            echo insertSong($conn, $songName, $albumID, $artistID, $producerID, $genreID, $trackNumber, $userID);
			header( "refresh:2; url=add_song.php" );
			echo " ${songName} by ${artistName} successfully added. Redirecting...";
			exit;
			
        }
    }

?>