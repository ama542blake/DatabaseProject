<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");

    /* action for form in display_song.php */ 

//TODO make this accommodate multiple values for each field
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists']) && (isset($_POST['albums'])))) {
        $songID = $_POST['song_id'];
        
        // gather info about the artist
        $artistName = $_POST['artists'];
        if (!(trim($artistName))) { // all whitespace name has been entered
            echo "ALL WHITESPACE";
        }
        
        $artistID = getArtistID($conn, $artistName);
        if (!($artistID)) {
            
        }
    
        // producer info
        if (isset($_POST['producer'])) {
            $producerName = $_POST['producer'];
            if ($producerName) { // not empty string
                $producerID = intval(getProducerID($conn, $producerName));
                if (!($producerID)) {
                    $producerID = insertProducer($conn, $producerName);
                }
            } else $producerID = NULL;
        } else {
            $producerID = NULL;
        }
        
        // genre info
        if (isset($_POST['genre'])) {
            $genreName = $_POST['genre'];
            if ($genreName) { // not empty string
                $genreID = getGenreID($conn, $genreName);
                if ($genreID < 1) {
                    $genreID = insertGenre($conn, $genreName);
                }
            } else $genreID = NULL;
        } else {
            $genreID = NULL;
        }
        
        echo updateSong($conn, $songID, $producerID, $genreID);
        
        $redirID = $_POST['redir_id'];
        //header("Location: display_song.php" . $redirID);
        
    } else {
        echo "You must set values for artists and albums. Producer and genre fields are optional. Try again.";
    }
?>