<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Album updating</title>
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

    /* action for form in display_album.php */ 
    /* In some places, "NULL" is used rather than NULL to allow query values to be set to NULL*/

//TODO make this accommodate multiple values for each field
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists'])) && (isset($_POST['album_id'])) && (isset($_SESSION['user_id']))) {
        $userID = $_SESSION['user_id'];
        
        $albumID = $_POST['album_id'];   
        
         // gather names and IDs of artist that created the album
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
        
        // get IDs of all songs on the album
        if (isset($_POST['song_ids'])) {
            $albumSongIDs = $_POST['song_ids'];
        } else {
            $albumSongIDs = NULL;
        }
        
        //album artwork artist
        if (isset($_POST['artwork_artist'])) {
            if ($artworkArtistName = $_POST['artwork_artist']){ // not empty string
                // insert artwork artist if doesn't exist in dv
                if (!($artworkArtistID = getArtworkArtistID($conn, $artworkArtistName))) {
                    $artworkArtistID = insertArtworkArtist($conn, $artworkArtistName);
                }
            } else {
                $artworkArtistID = "NULL";
            }
        } else {
            $artworkArtistID = "NULL";
        }
        
        // producer info
        if (isset($_POST['producer'])) {
            if ($producerName = $_POST['producer']) {
                // insert producer if it doesn't exist in db
                if (!($producerID = getProducerID($conn, $producerName))) {
                    $producerID = insertProducer($conn, $producerName);
                }
            } else {
                $producerID = "NULL";
            }
        } else {
            $producerName = "NULL";
        }
        
        // year info
        if (isset($_POST['year'])) {
            $albumYear = $_POST['year'];
            if (!($albumYear)) { // album year left blank
                $albumYear = "NULL";
            }
        } else {
            $albumYear  = "NULL";
        }
           
        updateAlbum($conn, $albumID, $artworkArtistID, $producerID, $albumYear, $userID);
        // destroy and recreate artist_album and album_song relationships
        deleteArtistAlbum($conn, $albumID);
        foreach($artistIDs as $artistID) {
            insertArtistAlbum($conn, $artistID, $albumID);
        }
    
        $redirID = $_POST['redir_id'];
        header("Location: display_album.php" . $redirID);
    } else {
        echo "You have reached this page in error. Try again.";
    }
?>