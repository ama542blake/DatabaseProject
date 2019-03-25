<?php
    session_start();
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    
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
        for ($i = 0; $i < count($albumIDs); $i++) {
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
        
        echo "<div class='container' id='results'>";
        echo "<p>By: " . implode(", ", $artists) . "</p><br>";
        echo "<p>Appears on: " . implode(", ", $albums) . "</p><br>"
                . "<p id='producer-name'>Producer: <a href=''>${producerName}</a></p><br>"
                . "<p id='artist-name'>Genre: <a href=''>${genreName}</a></p><br>"
            . "</div>";
    } else {
    }
    
    include_once("includes/footer.php");
?>