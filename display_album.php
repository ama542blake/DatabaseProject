<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Album information</title>
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
    // make sure the essential variables are set
    if ((isset($_GET['album_id']))) {
        $albumID = $_GET['album_id'];
        $albumName = getAlbumName($conn, $albumID);
        $albumYear = getAlbumYear($conn, $albumID);
        $albumArtworkArtistID = getAlbumArtworkArtistID($conn, $albumID);
        if ($albumArtworkArtistID) {
            $albumArtworkArtistName = getArtworkArtistName($conn, $albumArtworkArtistID);
        } else {
            $albumArtworkArtistName = NULL;
        }
        
        // get the list of artists associated with the album
        $albumArtistIDs = getArtistIDsFromArtistAlbum($conn, $albumID);
        for ($i = 0; $i < count($albumArtistIDs); $i++) {
            $albumArtistNames[$i] = getArtistName($conn, $albumArtistIDs[$i]);
        }
        
        // find the songs on the album
        $albumSongIDs = getAlbumSongIDs($conn, $albumID);
        $albumSongNames = array();
        for ($i = 0; $i < count($albumSongIDs); $i++) {
            $albumSongNames[$i] = getSongName($conn, $albumSongIDs[$i]['song_id']);
        }
        // get information about the most recent update of information
        $updateInfo = getUpdateInformation($conn, $albumID, "album");
        $updateUserID = $updateInfo['album_update_user'];
        if (!($updateUserName = getUserName($conn, $updateUserID))) {
            $updateUserName = "";
        }
        $updateTime = $updateInfo['album_update_time'];
        
        // set up the printing of the information
        echo "<div class='container container-fluid p-0' id='results'>";
        echo "<div class='card container-fluid displayTitle'>";
        echo "<h2>${albumName}</h2>";
        echo "</div>";
        echo "<div class='displayDetails'>";
        echo "<p><b>Year Released: </b><span id='albumYear'>${albumYear}</span></p>";
        // TODO eventually make a link that takes to a page that display all albums
        // the artwork artist has done art for (will require creation of diplay_artwork_artist.php, or something like it)
        echo "<p id='albumArtwork'><b>Artwork Artist: </b><span id='albumArtworkArtistName'.<a href=''>${albumArtworkArtistName}</a></span></p>";
        
        // display the artists        
        echo "<p><b>By: </b></p><span id='album-artists'>";
        $artists = array();
        for ($i = 0; $i < count($albumArtistNames); $i++) {
            $artists[$i] = "<a href='display_artist.php?artist_id=${albumArtistIDs[$i]}'>${albumArtistNames[$i]}</a>";
        }
        // this displays the links to the artists in a comma seperated list
        echo implode(", ", $artists);
        echo "</span><br><br>";
        
        // display the songs
        echo "<p><b>Songs: </b></p><ul class='list-unstyled'>";
        for ($i = 0; $i < count($albumSongNames); $i++) {
            $id = $albumSongIDs[$i]['song_id'];
            $trackNum = $albumSongIDs[$i]['track_number'];
            echo "<li>Track ${trackNum}: <a href='display_song.php?song_id=${id}'>${albumSongNames[$i]}</a></li>"
            . "<input type='hidden' name='song_ids[]' value='${id}'>";
        } 
        echo "</ul>";
        if (isset($_SESSION['username'])){
                echo "<button class='btn btn-block btn-primary' type='button' type='button' id='edit-album-info'>Edit this page</button>";
        } else {
            echo "<p>If you would like to edit or add to the information you see here, you must <a href='login_signup.php'>log in or sign up</a> before editing the page.";
        }
        echo "</div>";
        echo "<p id='update-info'>Last edited by ${updateUserName} at ${updateTime}</p>";
        echo "</div>";
    } else {
    }
    
    include_once("includes/footer.php");
?>
</div>