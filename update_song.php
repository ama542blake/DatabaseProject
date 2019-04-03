<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");
    session_start();

    /* action for form in display_song.php */ 

//TODO make this accommodate multiple values for each field
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists'])) && (isset($_POST['albums'])) && (isset($_SESSION['user_id']))) {
        $songID = $_POST['song_id'];
        
        // gather info about the artist
        $artistName = $_POST['artists'];
        if (isset($_POST['isband'])) {
            $isBand = $_POST['isband'];
        } else {
            $isBand = 0;
        }
        $artistID = getArtistID($conn, $artistName);
        if (!($artistID)) {
            $artistID = insertArtist($conn, $artistName, $isBand);
        }
        
        // gather info about the album and track number of the song
        $albumName = $_POST['albums'];
        $albumID = getAlbumID($conn, $artistID, $albumName);
        if (!($albumID)) {
            $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL, $userID);
            $trackNumber = 'NULL';
        } else {
            $trackNumber = getSongTrackNumber($conn, $albumID, $songID);
            if (!($trackNumber)) {
                $trackNumber = "NULL";
            }
        }
        
        // genre info
        if (isset($_POST['genre'])) {
            $genreName = $_POST['genre'];
        } else {
            $genreName = NULL;
        }
        
        // user info
        $userID = $_SESSION['user_id'];
        
        /* database stuff */
        updateSong($conn, $songID, $genreName, $userID);
        // destroy artist_song and album_song relationships
        deleteArtistSong($conn, $songID);
        deleteAlbumSong($conn, $songID, "song");
        // recreate artist_song and album_song relationships
        insertArtistSong($conn, $artistID, $songID);
        insertAlbumSong($conn, $albumID, $songID, $trackNumber);
        
        $redirID = $_POST['redir_id'];
        header("Location: display_song.php" . $redirID);
        
    } else {
        echo "You must set values for artists and albums. The genre field is optional. Try again.";
    }
?>