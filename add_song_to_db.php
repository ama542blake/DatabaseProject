<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adding to the database</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

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
        
        if (isset($_POST['genre'])) {
            $genreName = $_POST['genre'];
        } else {
            $genreName = "NULL";
        }
        
        // artist and album related entries
        if ($artistID) { // artist is in DB
            if (!$albumID) { // album and therefore song are not in database, so create album
                $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL, $userID);
            } // else album is in DB, so don't need to create
        } else {  // artist and therefore album are not in database, so create artist then album
            // TODO: allow user to decide if the artist is a band, for now assume band
            $artistID = insertArtist($conn, $artistName, 1, $userID);
            // TODO: find a way to allow user to enter in album released year and artwork artist
            $albumID = insertAlbum($conn, $artistID, $albumName, NULL, NULL, $userID);
        }
        
        // finally, check if song is in database, if not, create it
        if (getSongID($conn, $songName, $albumID)) {
            // song is in database
			header( "refresh:2; url=add_song.php" ); //displays message before redirecting
            echo "${songName} by ${artistName} on the album ${albumName} is already in the database. Redirecting...";
			exit; //redirects back to song page
        } else {
            $songID = insertSong($conn, $songName, $albumID, $artistID, $genreName, $trackNumber, $userID);
			header( "location: display_song.php?song_id=${songID}");
        }
    }

?>