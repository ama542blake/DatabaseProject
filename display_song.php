<?php
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    
    // make sure the essential variables are set
    if ((isset($GET_['song_id'])) && (isset($GET_['album_id'])) &&(isset($GET_['artist_id']))) {
        $songID = $_GET['song_id'];
        $songName = getSongName($conn, $songID);
        $albumID = $_GET['album_id'];
        $albumName = getAlbumName($conn, $albumID);
        $artistID = $_GET['artist_id'];
        $artistName = getArtistName($conn, $artistID);
        
        if (isset($_GET['producerID'])) {
            $producerID = $_GET['producer_id'];
            $producerName = getProducerName($conn, $producerID);
        } else {
            $producerID = NULL;
        }
        if (isset($_GET['genreID'])) {
            $genreID = $_GET['genre_id'];
            $genreName = getGenreName($conn, $genreID);
        } else {
            $genreID = NULL;
        }
        
        echo "<div class='container' id='results'>"
                . "<p id='artist-name'>Artist: <a href="">${artistName}</a></p><br>"
                . "<p id='song-name'>Album: <a href="">${albumName}</a></p><br>"
                . "<p id='artist-name'>Song: <a href="">${songName}</a></p><br>"
                . "<p id='producer-name'>Producer: <a href="">${producerName}</a></p><br>"
                . "<p id='artist-name'>Genre: <a href="">${genreName}</a></p><br>"
            . "</div>";
    }
    
    include_once("includes/footer.php");
?>