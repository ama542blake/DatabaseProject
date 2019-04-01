<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Song information</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<?php
    session_start();
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    include_once("includes/update_query.php");
?>
<div class="container-fluid displayContainer jumbotron p-0 pb-2 text-center">
<?php    
    // make sure the variable is set
    if (isset($_GET['song_id'])) {
        $songID = $_GET['song_id'];
        $songName = getSongName($conn, $songID);
        // find all albums that the song appears on
        $albumIDs = getAlbumIDsFromAlbumSong($conn, $songID);
        $albumNames = array();
        for ($i = 0; $i < count($albumIDs); $i++) {
            $albumNames[$i] = getAlbumName($conn, $albumIDs[$i]);
        }
        // create HTML links for each of the albums
        $albums = array();
        for ($i = 0; $i < count($albumNames); $i++) {
            $albums[$i] = "<a href='display_album.php?album_id=${albumIDs[$i]}'>${albumNames[$i]}</a>";
        }
        
        // find all artists that contributed
        $artistIDs = getArtistIDsFromArtistSong($conn, $songID);
        $artistNames = array();
        for ($i = 0; $i < count($artistIDs); $i++) {
            $artistNames[$i] = getArtistName($conn, $artistIDs[$i]);
        }
        // create HTML links for each of the artist
        $artists = array();
        for ($i = 0; $i < count($artistNames); $i++) {
            $artists[$i] = "<a href='display_artist.php?artist_id=${artistIDs[$i]}'>${artistNames[$i]}</a>";
        }
        
        // get the name of the producer
        $producerID = getSongProducer($conn, $songID);
        $producerName = getProducerName($conn, $producerID);
        
        // get the name of the genre
        $genreID = getSongGenre($conn, $songID);
        $genreName = getGenreName($conn, $genreID);
        
        // get information about the most recent update of information
        $updateInfo = getUpdateInformation($conn, $songID, "song");
        $updateUserID = $updateInfo['song_update_user'];
        if (!($updateUserName = getUserName($conn, $updateUserID))) {
            $updateUserName = "";
        }
        $updateTime = $updateInfo['song_update_time'];
        
        echo "<div class='container container-fluid p-0' id='results'>";
        echo "<div class='card container-fluid displayTitle'>";
        echo "<h2>${songName}</h2>";
        echo "</div>";
        echo "<div class='displayDetails'>";
        // print out the artists that contributed to the song
        echo "<p><b>By:</b> <span id='artists'>" . implode(", ", $artists) . "</span></p>";
        
        // print out the albums that the song appears on
        echo "<p><b>Appears on: </b> <span id='albums'>" . implode(", ", $albums) . "</span></p>"
                . "<p id='producer-name'><b>Producer: </b> <span id='producer'><a href='#' disabled>${producerName}</a></span></p>"
                . "<p id='artist-name'><b>Genre: </b><span id='genre'><a href=''>${genreName}</a></span></p>";
        
        if (isset($_SESSION['username'])) {
            echo "<button class='btn btn-block btn-primary' type='button' id='edit-song-info'>Edit this page</button>";
        } else {
            echo "<p>If you would like to edit or add to the information you see here, you must <a href='login_signup.php'>log in or sign up</a> before editing the page.";
        }
		echo "<p id='update-info'></p>";
        echo "</div>";
        echo "<p id='update-info'>Last edited by ${updateUserName} at ${updateTime}</p>";
        echo "</div>";
        echo "</div>";
    } else {
        
    }
    
    include_once("includes/footer.php");
?>
</div>