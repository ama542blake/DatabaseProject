<?php
    include_once('includes/connection.php');
    include_once('includes/common_query.php');
    if (isset($_POST['artist_name'])) {
        $name = $_POST['artist_name'];
        $isband = $_POST['isband'];
        $newArtistID = insert_artist($name, $isband);
        
        // if solo artist is in a band
        if (isset($_POST['band_membership'])) {
            // name of band the solo member is in
            $band = $_POST['band_membership'];
            $bandID = getArtistID($band);
            if ($bandID > 0) {
                // artist already exists, make sure is is a band, not solo artist
                // TODO: this check should occur before the user submits the form, but I will deal with that later
                if (getArtistIsBand($bandID) == 1) {
                    insert_membership($bandID, $newArtistID);
                } else {
                    header("Location: add_artist.php");
                }
            } else {
                // band doesn't exist, so create an artist_entry for the band they are in, then create membership record
                $bandID = insert_artist($band, 1);
                insert_membership($bandID, $newArtistID);
            }
        }
    }

    // inserts an artist in to the database
    function insert_artist($name, $isband) {
        global $conn;
        $query = "INSERT INTO artist (artist_name, artist_is_band) VALUES ('${name}', '${isband}')";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }

    // inserts a band membership record in the band_membership table
    function insert_membership($bandID, $soloID) {
        global $conn;
        $query = "INSERT INTO band_membership (band_id, solo_id) VALUES ($bandID, $soloID)";
        mysqli_query($conn, $query);
        return mysqli_insert_id($conn);
    }
?>

