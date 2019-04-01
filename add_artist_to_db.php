<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adding to the database</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<?php
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');
    session_start();
    
    if (isset($_POST['artist_name']) && (isset($_SESSION['user_id']))) {
        // don't commit changes if failure occurs
        mysqli_autocommit($conn, FALSE);
        
        $userID = $_SESSION['user_id'];
        $name = mysqli_real_escape_string($conn, $_POST['artist_name']);
        // don't need to escape - radio button
        $isband = $_POST['isband'];
        
        if (getArtistID($conn, $name)) {
            header( "refresh:2; url=add_artist.php" );
			echo ("<div class='alert alert-danger' role='alert'><p id='band-exists-alert'>That artist is already in the database</p></div>");
            exit;
        } else {
            $newArtistID = insertArtist($conn, $name, $isband, $userID);
            // can't redirect until we check if artist is in a band
        }
        
        // if solo artist is in 1 or more  bands
        if (isset($_POST['band_membership'])) {
            // names of band the solo artist is is in
            $rawBandString = mysqli_real_escape_string($conn, $_POST['band_membership']);
            // decompose from list to individual artists
            $rawBandList = explode(",", $rawBandString);
            // TODO: convert to foreach for better readability
            // insert artists and/or create relationships between the member and their bands
            for ($i = 0; $i < count($rawBandList); $i++) {
                $bandName = trim($rawBandList[$i]);
                if ($bandID = getArtistID($conn, $bandName)) {
                    // artist already exists, make sure it is a band, not solo artist
                    // TODO: this check should occur before the user submits the form, but I will deal with that later
                    if (getArtistIsBand($conn, $bandID)) {
                        insertMembership($conn, $bandID, $newArtistID);
                    } else {
                        mysqli_rollback($conn);
                        header( "refresh:2; url=add_artist.php" );
                        echo "<div class='alert alert-success' role='alert'>Error, ${bandName} is not a band.</div>";
			            exit;
                    }
                } else {
                    // band doesn't exist, so create an artist entry for the band the solo artist is in, then create membership record
                    $bandID = insertArtist($conn, $bandName, 1, $userID);
                    insertMembership($conn, $bandID, $newArtistID);
                }
            }
        }
        
        // if solo artist is in 1 or more  bands
        if (isset($_POST['band_members'])) {
            // names of band the solo artist is is in
            $rawMemberString = mysqli_real_escape_string($conn, $_POST['band_members']);
            // decompose from list to individual bands
            $rawMemberList = explode(",", $rawMemberString);
            // TODO: convert to foreach for better readability
            // insert artists and/or create relationships between the band and their members
            for ($i = 0; $i < count($rawMemberList); $i++) {
                $memberName = trim($rawMemberList[$i]);
                if ($memberID = getArtistID($conn, $memberName)) {
                    // band member already exists, make sure it is a solo artist, not a band 
                    // TODO: this check should occur before the user submits the form, but I will deal with that later
                    if (!(getArtistIsBand($conn, $memberID))) {
                        insertMembership($conn, $newArtistID, $memberID);
                    } else {
                        mysqli_rollback($conn);
                        header( "refresh:2; url=add_artist.php" );
                        echo "<div class='alert alert-success' role='alert'>Error, ${memberName} not a solo artist.</div>";
			            exit;
                    }
                } else {
                    // member doesn't exist, so create an artist entry for the member of the band, then create a membership record
                    $memberID = insertArtist($conn, $memberName, 0, $userID);
                    insertMembership($conn, $newArtistID, $memberID);
                }
            }
        }
    
        mysqli_commit($conn);
        header("location: display_artist.php?artist_id=${newArtistID}");
        echo "<div class='alert alert-success' role='alert'>${name} successfully added. Redirecting...</div>";
        exit;
    } else {
        echo "You have reached this page in error";
    }

    include_once('includes/footer.php');
?>