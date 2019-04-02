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
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');
    session_start();

    if ((isset($_POST['album_name'])) && (isset($_POST['album_artists'])) && (isset($_SESSION['user_id']))) {
        // don't commit changes if failure occurs
        mysqli_autocommit($conn, FALSE);
        
        $userID = $_SESSION['user_id'];
        
        $albumName = mysqli_real_escape_string($conn, $_POST['album_name']);
        $artworkArtistName = mysqli_real_escape_string($conn, $_POST['album_artwork_artist']);
        $releasedYear = mysqli_real_escape_string($conn, $_POST['album_year_released']);
        
        // gather names and IDs of artist that created the album
        $rawArtistString = mysqli_real_escape_string($conn, $_POST['album_artists']);
        // TODO: make all other inputs in other files that use comma seperate lists use array_map with trim
        $artistNames = array_map('trim', explode(",", $rawArtistString));
        $artistIDs = array();
        // use this to determine whether album may already exist; if true, this means none of the artists are in the DB,
        // and therefore, the album definitely isn't either
        $allArtistsNew = true;
        foreach ($artistNames as $i => $name) {
            if ($artistIDs[$i] = getArtistID($conn, $name)) {
                $allArtistsNew = false;
            } else {
                //TODO: find way to allow user to determine if each artist is band or solo, for now assume band
                $artistIDs[$i] = insertArtist($conn, $artistNames[$i], 1, $userID);
            }
        }
        
        if ($artworkArtistName) {
            $artworkArtistID = getArtworkArtistID($conn, $artworkArtistName);
            if(!$artworkArtistID) {
                $artworkArtistID = insertArtworkArtist($conn, $artworkArtistName);
            }
        } else {
            $artworkArtistID = NULL;
        }
        
        // Now actually insert info
        /* STRUCTURE FOR FOLLOWING IF BLOCK
           1 artist: 
           (a) IF new ($allArtistsNew), album needs to be created because it can't exist without the artist,
           but artist has already been inserted
           (b) ELSE (the artist exists), check if the album exists; create album if it doesn't exist 
           (which automatically creates the relationship)
         
           2+ artists:
           (c) IF all are new ($allArtistsNew) just create the album using insertMultipleArtistAlbum and add
           the artist_album relationship for each (since this isn't automatically done by insertMultipleArtistAlbum like it
           is by the normal insertAlbum)
           (d) ELSE check if ANY one of the artists already is associated with the album the user is trying to 
           create, and none are, create the album and the relationships (this isn't done by insertMultipleArtistAlbum)
        */
        $numArtists = count($artistIDs);
        if ($numArtists === 1) { // (a) or (b)
            if ($allArtistsNew) { // (a)
                $albumID = insertAlbum($conn, $artistIDs[0], $albumName, $artworkArtistID, $releasedYear, $userID);
                if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				header("location: display_album.php?album_id=${albumID}");
                exit;
            } else { // (b)
                if (getAlbumID($conn, $artistIDs[0], $albumName)) {
                    mysqli_rollback($conn);
				    header( "refresh:2; url=add_album.php" );
                    echo "<div class='alert alert-danger' role='alert'>${albumName} by ${artistNames[0]} is already in the database.</div>";
				    exit;
                } else {
				    $albumID = insertAlbum($conn, $artistIDs[0], $albumName, $artworkArtistID, $releasedYear, $userID);
                    if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				    header("location: display_album.php?album_id=${albumID}");
                    exit;
                }
            }
        } else { // (c) or(d)
            if ($allArtistsNew) { // (c)
                $albumID = insertMultipleArtistAlbum($conn, $artistIDs, $albumName, $artworkArtistID, $releasedYear, $addUserID);
                if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				header("location: display_album.php?album_id=${albumID}");
                exit;
            } else { // (d)
                // if any of the artists already appear on an album with the name, assume that the album has already been
                // created, and the user should edit that page
                /* TODO: find a better way to check if an album with multiple contributing artists exists.
                   Though unlikely, it's possible that an artist could be on two albums of the same name
                   with different sets of artists */
                foreach ($artistIDs as $artistID) {
                    if ($albumID = getAlbumID($conn, $artistID, $albumName)) {
                        $artistName = getArtistName($conn, $artistID);
                        echo "<div class='alert alert-danger' role='alert'>${albumName} by ${artistName} is already in the database. " 
                            . "If you are trying to add other artists as album contributors, please edit the " 
                            . "<a href='display_album.php?album_id=${albumID}'>album information page</a> for this album.</div>";
                        mysqli_rollback($conn);
				        exit;
                    }
                }
                // if execution reaches this point, we know that the artist-album combo doesn't exists for any of the 
                // artists the user entered
                $albumID = insertMultipleArtistAlbum($conn, $artistIDs, $albumName, $artworkArtistID, $releasedYear, $addUserID);
                if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				header("location: display_album.php?album_id=${albumID}");
                exit;
            }
        }
        // execution should never reach this point, so if it does, something has gone wrong and the changes need to be undone
        mysqli_commit($conn);
    } else {
        
    }    

    include_once('includes/footer.php');
?>