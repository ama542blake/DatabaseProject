<?php
    include_once("includes/update_query.php")

    if ((isset($_POST['redir_id'])) && (isset($_POST['artists']) && (isset($_POST['albums'])))) {
        $artistsRaw = $_POST['artists'];
        //TODO: will need to create an array of values for when multiple artists can be added
        //$artists = array();
        
        $albumsRaw = $_POST['albums'];
        //TODO: will need to create an array of values for when multiple albums can be added
        //$albums = array();
        
        // TODO allow multiple producers
        if (isset($_GET['producer'])) {
            $producer = $_GET['producer'];
        } else {
            $producer = NULL;
        }
        
        // TODO allow multiple genres
        if (isset($_GET['genre'])) {
            $genre = $_GET['genre'];
        } else {
            $genre = NULL;
        }
        
        $redirID= $_POST['redir_id'];
        header("Location: display_song.php" . $redirID);
    } else {
        echo "You must set values for artists and albums. Producer and genre fields are optional. Try again.";
    }
?>