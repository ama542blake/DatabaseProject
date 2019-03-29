<?php
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    if (isset($_POST['artist_name']) && isset($_SESSION['user_id'])) {
        $name = mysqli_real_escape_string($conn, $_POST['artist_name']);
        // don't need to escape - radio button
        $isband = $_POST['isband'];
        if (getArtistID($conn, $name)) {
            header( "refresh:2; url=add_artist.php" );
			echo ("<div class='alert alert-danger' role='alert'><p id='band-exists-alert'>That artist is already in the database</p></div>");
        } else {
            $newArtistID = insertArtist($conn, $name, $isband);
			header( "refresh:2; url=add_artist.php" );
			echo "<div class='alert alert-success' role='alert'>${name} successfully added. Redirecting...</div>";
			exit;
        }
        
        // if solo artist is in a band
        if ((isset($_POST['band_membership']) && ($_POST['band_membership']))) {
            // name of band the solo member is in
            $band = mysqli_real_escape_string($conn, $_POST['band_membership']);
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
<?php
    include_once('includes/footer.php');
?>