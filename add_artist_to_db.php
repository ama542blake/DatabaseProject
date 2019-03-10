<?php
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    if (isset($_POST['artist_name'])) {
        $name = $_POST['artist_name'];
        $isband = $_POST['isband'];
        if (getArtistID($conn, $name)) {
            echo ("<p id='band-exists-alert'>That artist is already in the database</p>");
        } else {
            $newArtistID = insertArtist($conn, $name, $isband);
			header( "refresh:2; url=add_artist.php" );
			echo "${name} successfully added. Redirecting...";
			exit;
        }
        
        // if solo artist is in a band
        if ((isset($_POST['band_membership']) && ($_POST['band_membership']))) {
            // name of band the solo member is in
            $band = $_POST['band_membership'];
            $bandID = getArtistID($conn, $band);
            if ($bandID > 0) {
                // artist already exists, make sure it is a band, not solo artist
                // TODO: this check should occur before the user submits the form, but I will deal with that later
                if (getArtistIsBand($conn, $bandID) == 1) {
                    echo 'yes';
                    insertMembership($conn, $bandID, $newArtistID);
                } else {
                    echo 'no';
                }
            } else {
                // band doesn't exist, so create an artist_entry for the band they are in, then create membership record
                $bandID = insertArtist($conn, $band, 1);
                insertMembership($conn, $bandID, $newArtistID);
            }
        }
    }
?>