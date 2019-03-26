<?php
    include_once("includes/update_query.php");
    
//TODO make this accommodate multiple values for each field
        
    if ((isset($_POST['redir_id'])) && (isset($_POST['artists']) && (isset($_POST['albums'])))) {
        $songID = $_POST['song_id'];
        // gather artist info
        $artists = $_POST['artists'];
        if (isset($_POST['isband'])) {
            $isband = 1;
            $bandMembership = NULL;
        } else {
            $isband = 0;
            if (isset($_GET['band_membership'])) {
                $bandMembership = $_GET['band_membership'];
            } else {
                $bandMembership = NULL;
            }
        }
        
        $albums = $_POST['albums'];
        
        if (isset($_GET['producer'])) {
            $producer = $_GET['producer'];
        } else {
            $producer = NULL;
        }
        
        if (isset($_GET['genre'])) {
            $genre = $_GET['genre'];
        } else {
            $genre = NULL;
        }
        
        updateSong($conn, $songID, $artists, $isBand, $bandMembership, $albums, $producer, $genre);
        $redirID= $_POST['redir_id'];
        header("Location: display_song.php" . $redirID);
        
    } else {
        echo "You must set values for artists and albums. Producer and genre fields are optional. Try again.";
    }
?>