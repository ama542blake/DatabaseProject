<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artowrk artist albums</title>
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
?>

<div class="container-fluid displayContainer jumbotron p-0 pb-2 text-center">

<?php
    if (isset($_GET['artwork_artist_id'])) {
        $artworkArtistID = $_GET['artwork_artist_id'];
        $artworkArtistName = getArtworkArtistName($conn, $artworkArtistID);
        echo "<div class='card container-fluid displayTitle'>";
		 echo "<h2>${artworkArtistName}</h2>";
        echo "</div>";
        // this contains a 3D array, see common_query.php for notes on how this is formed
		$albums = getAlbumAndArtistByArtworkArtist($conn, $artworkArtistID);
        foreach($albums as $albumID => $album) {
            // get artist name from 0th index of the array, since there will always be at least
            // one artist (0th index will exist)
            echo "<div class='albumListDiv card container-fluid my-2 p-2'>";
			$albumName = $album[0]['albumName'];
            echo "<h3>Album: <a href='display_album.php?album_id=${albumID}'>${albumName}</a></h3><br>";
            $artistLinks = array();
            foreach($album as $i => $artist) {
                $artistID = $artist['artistID'];
                $artistName = $artist['artistName'];
                $artistLinks[$i] = "<a href='display_artist.php?artist_id=${artistID}'>${artistName}</a>";
            }
            echo "<p>By: " . implode(", ", $artistLinks) . "</p>";
			echo "</div>";
        }
        
        echo "</div>";
    }
    include_once("includes/footer.php");
?>
</div>