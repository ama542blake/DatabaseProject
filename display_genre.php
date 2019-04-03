<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Songs by genre</title>
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
    if (isset($_GET['genre'])) {
        $genreName = $_GET['genre'];
        echo "<h2>${genreName} Songs</h2>";
        // TODO; possibly move this to common_query
        $query = "SELECT song.song_id, song.song_name, album.album_id, album.album_name, artist.artist_id, artist.artist_name " 
               . "FROM song "
               . "JOIN artist_song ON song.song_id = artist_song.song_id "
               . "JOIN artist ON artist_song.artist_id = artist.artist_id "
               . "JOIN album_song ON song.song_id = album_song.song_id "
               . "JOIN album ON album_song.album_id = album.album_id "
               . "WHERE song_genre = '${genreName}'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $songs = array();
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($songs, array(
                                    'songName' => $row['song_name'],
                                    'songID' => $row['song_id'],
                                    'albumName' => $row['album_name'],
                                    'albumID' => $row['album_id'],
                                    'artistName' => $row['artist_name'],
                                    'artistID' => $row['artist_id']
                                   )); 
            }
            displaySongSearchResult ($songs);
        }

    }
    echo "</div>";
    
    include_once("includes/footer.php");
    
    function displaySongSearchResult($songs) {
       echo "<div class='card displayResultsTypeDiv my-4 pb-3 text-center'>"; 
        echo "<div class='card'>";
        echo "<h2>Songs</h2>";
       echo "</div>";
        foreach($songs as $song) {
            $songName = $song['songName'];
            $songID = $song['songID'];
            $albumName = $song['albumName'];
            $albumID = $song['albumID'];
            $artistName = $song['artistName'];
            $artistID = $song['artistID'];
            echo "<div id='song-results'>"
                .    "<span> <a href='display_song.php?song_id=${songID}'><b>${songName}</b></a></span><br>";
            echo "<b>By:</b> ${artistName}<br>";
            echo "<b>On:</b> ${albumName}<br>";
            echo "</div>";
            }
            echo "</div>"; 
        }
?>
</div>