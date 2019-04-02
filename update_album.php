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

//TODO make this accommodate multiple values for each field
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists'])) && (isset($_POST['album_id'])) && (isset($_SESSION['user_id']))) {
        $userID = $_SESSION['user_id'];
        
        $albumID = $_POST['album_id'];   
        
        // gather info about the artist
        $artistName = $_POST['artists'];
        if (isset($_POST['isband'])) {
            $isBand = $_POST['isband'];
        } else {
            $isBand = 0;
        }
        $artistID = getArtistID($conn, $artistName);
        if (!($artistID)) {
            $artistID = insertArtist($conn, $artistName, $isBand, $userID);
        }
        
        // year info
        if (isset($_POST['year'])) {
            $albumYear = $_POST['year'];
            if (!($albumYear)) { // album year left blank
                $albumYear = NULL;
            }
        } else {
            $albumYear  = NULL;
        }
        
        // get IDs of all songs on the album
        if (isset($_POST['song_ids'])) {
            $albumSongIDs = $_POST['song_ids'];
        } else {
            $albumSongIDs = NULL;
        }
        
        //album artwork artist
        if (isset($_POST['artwork_artist'])) {
            $artworkArtistName = $_POST['artwork_artist'];
            if ($artworkArtistName){ // not empty string
                $artworkArtistID = getArtworkArtistID($conn, $artworkArtistName);
                if (!($artworkArtistID)) {
                    $artworkArtistID = insertArtworkArtist($conn, $artworkArtistName);
                }   
            } else {
                $artworkArtistID = NULL;
            }
        } else {
            $artworkArtistID = NULL;
        }
           
        updateAlbum($conn, $albumID, $artworkArtistID, $albumYear, $userID);
        // destroy and recreate artist_album and album_song relationships
        deleteArtistAlbum($conn, $albumID);
        insertArtistAlbum($conn, $artistID, $albumID);
    
        $redirID = $_POST['redir_id'];
        header("Location: display_album.php" . $redirID);
    } else {
        echo "You have reached this page in error. Try again.";
    }
?>