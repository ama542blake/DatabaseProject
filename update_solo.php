<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");
    session_start();

    if ((isset($_POST['old_band_ids'])) && (isset($_POST['bands'])) && (isset($_POST['artist_id'])) && (isset($_POST['redir_id'])) && (isset($_SESSION['user_id']))) {
        // destroy the old memberships to prepare for the new ones
        $artistID = $_POST['artist_id'];
        $oldBandIDs= $_POST['old_band_ids'];
        foreach($oldBandIDs as $oldBandID) {
            echo deleteBandMembership($conn, $artistID, $oldBandID);
        }
        
        // get the string values for the updated list of bands
        $rawBandString = mysqli_real_escape_string($conn, $_POST['bands']);
        $rawBandList = explode(", ", $rawBandString);
        
        // for each band added, create the membership relationship
        for ($i = 0; $i < count($rawBandList); $i++) {
            $bandName = trim($rawBandList[$i]);
            if (!($bandID = getArtistID($conn, $bandName))) {
                $bandID = insertArtist($conn, $bandName, 1);
            }
            insertMembership($conn, $bandID, $artistID);
        }
        
        $updateUserID = $_SESSION['user_id'];
        updateArtist($conn, $artistID, $updateUserID);
        
        $redirID = $_POST['redir_id'];
        header("Location: display_artist.php" . $redirID);
    } else {
        
    }
?>
