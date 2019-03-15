<?php
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    
    // make sure the essential variables are set
    if ((isset($GET_['song_id'])) && (isset($GET_['album_id'])) &&(isset($GET_['artist_id']))) {
        $songID = $_GET['song_id'];
        $albumID = $_GET['album_id'];
        $artistID = $_GET['artist_id'];
        
        if (isset($_GET['producerID'])) {
            $producerID = $_GET['producer_id'];
        } else {
            $producerID = NULL;
        }
        if (isset($_GET['genreID'])) {
            $genreID = $_GET['genre_id'];
        } else {
            $genreID = NULL;
        }
        
        //TODO get the names for each of the variables that have IDs, use common_query.php for this
        
    }
    
    include_once("includes/footer.php");
?>