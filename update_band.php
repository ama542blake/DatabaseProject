<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");

    session_start();

    if ((isset($_POST['members'])) && (isset($_POST['artist_id']))) {
        
        $rawMemberString = mysqli_real_escape_string($conn, $_POST['members']);
        $rawMemberList = explode(", ", $rawMemberString);
//        $memberNames = array();
//        $memberIDs = array();
        
        for ($i = 0; $i < count($rawMemberList); $i++) {
//            $memberNames[$i] = trim($rawMemberList[$i]);
            $memberName = trim($rawMemberList[$i]);
            if ($bandID = getArtistID($conn, $memberName)) {
                // remove the 
            } else {
                $bandID = insertArtist($conn, $memberName, 0);
            }
        }
    }
?>


if (isset($_POST['old_solo_ids']))