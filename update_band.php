<?php
    include_once("includes/connection.php");
    include_once("includes/update_query.php");
    session_start();

    if ((isset($_POST['old_member_ids'])) && (isset($_POST['members'])) && (isset($_POST['artist_id'])) && (isset($_POST['redir_id']))) {
        // destroy the old memberships to prepare for the new ones
        $artistID = $_POST['artist_id'];
        $oldMemberIDs= $_POST['old_member_ids'];
        foreach($oldMemberIDs as $oldMemberID) {
            echo deleteBandMembership($conn, $artistID, $oldMemberID);
        }
        
        // get the string values for the updated list of band members
        $rawMemberString = mysqli_real_escape_string($conn, $_POST['members']);
        $rawMemberList = explode(", ", $rawMemberString);
        
        // for each member inserted, create the membership relationship
        for ($i = 0; $i < count($rawMemberList); $i++) {
            $memberName = trim($rawMemberList[$i]);
            if (!($memberID = getArtistID($conn, $memberName))) {
                $memberID = insertArtist($conn, $memberName, 0);
            }
            insertMembership($conn, $artistID, $memberID);
        }
    } else {
        
    }
?>