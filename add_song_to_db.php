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

    // TODO: find way to associate 1 song with multiple albums
    
    if (isset($_POST['song_name']) && isset($_POST['artist_names']) && isset($_POST['album_name']) && isset($_SESSION['user_id'])) {
        // don't commit changes if failure occurs
        mysqli_autocommit($conn, FALSE);
        
        $userID = $_SESSION['user_id'];
        
        // gather names and ID's of things
        $songName = mysqli_real_escape_string($conn, $_POST['song_name']);
       
        // gather names and IDs of artist that created the song
        // TODO: this code is use in 2 places, put it in some file accessible to both places
        $rawArtistString = mysqli_real_escape_string($conn, $_POST['artist_names']);
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
        
        $albumName = mysqli_real_escape_string($conn, $_POST['album_name']);
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
                        . implode(", ", $artistNames)
                        . " must be associated with an album. If more than one artist has contributed, "
                        . "then then must all be associated with the album that this song is on. "
                        . "The album the song is on must also already be in the database. "
                        . "You can add an artist <a href='add_artist.php'>here</a>, "
                        . "create the album that the song is on <a href='add_album.php'>here</a>, "
                        . "or edit the album this song is on to include all of the artists <a href='display_album.php?album_id=${albumID}'>here</a>, "
                        . "</div>";
                    exit;
            }
        }
        
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
        
        if (count($artistIDs) == 1) { // only 1 artist
            if (getSongID($conn, $songName, $albumID)) {
                // song is in database
                mysqli_rollback($conn);
                header( "refresh:5; url=add_song.php" ); //displays message before redirecting
                echo "${songName} on the album ${albumName} is already in the database. Redirecting...";
                exit; //redirects back to song page
            } else {
                $songID = insertSong($conn, $songName, $albumID, $artistID, $genreName, $trackNumber, $userID);
                mysqli_commit($conn);
                header( "location: display_song.php?song_id=${songID}");
            }
        } else { // 2+ artists on the song
            foreach ($artistIDs as $artistID) {
                if (getSongID($conn, $songName, $albumID)) {
                    // song is in database
                    header( "refresh:5; url=add_song.php" ); //displays message before redirecting
                    echo "${songName} on the album ${albumName} is already in the database. Redirecting...";
                    exit; //redirects back to song page
                }
            }
            if ($songID = insertMultipleArtistSong($conn, $songName, $albumID, $artistIDs, $genreName, $trackNumber, $addUserID)) {
                // all artist have been iterated through without error, so commit
                mysqli_commit($conn);
                header("Location: display_song.php?song_id=${songID}");
            } else {
                mysqli_rollback($conn);
                echo "<div class='alert alert-danger' role='alert'>"
                        . "An unknown error has occurred."
                        . "</div>";
                    exit;
            }
        }
    } else {
        
    }

?>