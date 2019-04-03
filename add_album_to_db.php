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
        
        // determine the id of the producer; need to check if it's set and nonempty
        if (isset($_POST['producer_name'])) {
            $producerName = mysqli_real_escape_string($conn, $_POST['producer_name']);
            if ($producerName) {
                $producerID = getProducerID($conn, $producerName);
                if (!($producerID)) {
                    $producerID = insertProducer($conn, $producerName);
                }
            } else {
                $producerID = "NULL";
            }
        } else {
            $producerID = "NULL";
        }
        
        $releasedYear = mysqli_real_escape_string($conn, $_POST['album_year_released']);
        
        // gather names and IDs of artist that created the album
        $rawArtistString = mysqli_real_escape_string($conn, $_POST['album_artists']);
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
                    echo "<div class='alert alert-danger' role='alert'>"
                        . implode(", ", $newArtistNames)
                        . " must be added to the database before being associated with an album. "
                        . "Add an artist <a href='add_artist.php'>here</a>."
                        . "</div>";
                    exit;
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
        $numArtists = count($artistIDs);
        if ($numArtists === 1) { // check if the album exists; create album if it doesn't exist 
            if (getAlbumID($conn, $artistIDs[0], $albumName)) {
                mysqli_rollback($conn);
				header( "refresh:2; url=add_album.php" );
                echo "<div class='alert alert-danger' role='alert'>${albumName} by ${artistNames[0]} is already in the database.</div>";
				exit;
            } else {
				$albumID = insertAlbum($conn, $artistIDs[0], $albumName, $artworkArtistID, $producerID, $releasedYear, $userID);
                if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				header("location: display_album.php?album_id=${albumID}");
                exit;
            }
        } else {
            // if any of the artists already appear on an album with the name, assume that the album has already been
            // created, and the user should edit that page
            /* TODO: find a better way to check if an album with multiple contributing artists exists.
               Though unlikely, it's possible that an artist could be on two albums of the same name
               with different sets of artists */
            foreach ($artistIDs as $artistID) {
                if ($albumID = getAlbumID($conn, $artistID, $albumName)) { // check if ANY one of the artists already is associated with the album the user is trying tocreate, and none are, create the album
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
                $albumID = insertMultipleArtistAlbum($conn, $artistIDs, $albumName, $artworkArtistID, $producerID, $releasedYear, $addUserID);
                if ($albumID) {mysqli_commit($conn);} else {mysqli_rollback($conn);}
				header("location: display_album.php?album_id=${albumID}");
                exit;
            }
            // execution should never reach this point, so if it does, something has gone wrong and the changes need to be undone
            mysqli_commit($conn);
        } else {
        
    }    

    include_once('includes/footer.php');
?>