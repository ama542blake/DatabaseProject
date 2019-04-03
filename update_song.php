<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Song updating</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");
    session_start();

    /* action for form in display_song.php */ 

//TODO make this accommodate multiple values for each field
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists'])) && (isset($_POST['albums'])) && (isset($_SESSION['user_id']))) {
        // don't commit changes if failure occurs
        mysqli_autocommit($conn, FALSE);
        
        // user info
        $userID = $_SESSION['user_id'];
        
        $songID = $_POST['song_id'];
        
        // gather names and IDs of artist that created the song
        // TODO: this code is used in 3 places, put it in some file accessible to all places
        $rawArtistString = mysqli_real_escape_string($conn, $_POST['artists']);
        // TODO: make all other inputs in other files that use comma seperate lists use array_map with trim
        $artistNames = array_map('trim', explode(",", $rawArtistString));
        $artistIDs = array();
        // holds the names of artists that aren't in the database
        $newArtistNames = array();
        foreach ($artistNames as $i => $name) {
            if (!($artistIDs[$i] = getArtistID($conn, $name))) {
                $newArtistNames[$i] = $artistNames[$i];
            }
        }
        
        // if any of the artists the user has entered isn't in the database, force user to first add the artist
        if (count($newArtistNames)) {
                    mysqli_rollback($conn);
                    echo "<div class='alert alert-danger' role='alert'>"
                        . implode(", ", $newArtistNames)
                        . " must be added to the database before being associated with a song. "
                        . "You will also need to create an album associated with that artist "
                        . "before you can add the song. "
                        . "Add an artist <a href='add_artist.php'>here</a>."
                        . "</div>";
                    exit;
        }
        
        // TODO: finding an album based on multiple input artists is used in multiple
        // places. Find a way to put this in one central place for use by many functions
        // gather info about the album and track number of the song
        $albumName = mysqli_real_escape_string($conn, $_POST['albums']);
        /* for each artist, make sure of 2 things, and exit if these two things are not true:
            1: the albumID returned in each query for the given album name is the same,
            because if it isn't, then each artist is not featured on the same album.
            The ID will be whatever album ID is returned by getAlbumID with the ID
            of the first artist in the artistIDs array.
            This likely won't happen often, but it needs to be considered.
            2: make sure that the artist is associated with an album of that name; if not,
            make the user create an album with all of these artists.
        */
        $albumID = getAlbumID($conn, $artistIDs[0], $albumName);
        foreach($artistIDs as $artistID) {
            $thisAlbumID = getAlbumID($conn, $artistID, $albumName);
            if (($thisAlbumID != $albumID) || (!$thisAlbumID)) {
                mysqli_rollback($conn);
                echo "<div class='alert alert-danger' role='alert'>"
                        . "<p>An error has occurred. Please make sure that "
                        . "the album you are trying to add a song to is in our database, "
                        . "as well as all artists that contributed to the song. "
                        . "You can add an artist <a href='add_artist.php'>here</a>, "
                        . "create the album that the song is on <a href='add_album.php'>here</a>, "
                        . "or edit the album this song is on to include all of the artists <a href='display_album.php?album_id=${albumID}'>here</a>, "
                        . "</div>";
                    exit;
            }
        }
        
        // genre info
        if (isset($_POST['genre'])) {
            $genreName = $_POST['genre'];
        } else {
            $genreName = NULL;
        }
        
        // determine the track number that it is on the album
        if (isset($_POST['song_track_number'])) {
            $trackNumber = $_POST['song_track_number'];
        } else {
            // must be string for proper insertion querying in addAlbumSong
            $trackNumber = 'NULL';
        }
        /* database stuff */
        updateSong($conn, $songID, $genreName, $userID);
        // destroy artist_song and album_song relationships
        deleteArtistSong($conn, $songID);
        deleteAlbumSong($conn, $songID, "song");
        // recreate artist_song and album_song relationships
        foreach ($artistIDs as $artistID) {
            insertArtistSong($conn, $artistID, $songID);
        }
        insertAlbumSong($conn, $albumID, $songID, $trackNumber);
        
        mysqli_commit($conn);
        
        $redirID = $_POST['redir_id'];
        header("Location: display_song.php" . $redirID);
        
    } else {
        echo "You must set values for artists and albums. The genre field is optional. Try again.";
    }
?>