<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artist information</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<?php
    session_start();
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    include_once("includes/update_query.php");
?>
<div class="container-fluid displayContainer jumbotron p-0 pb-2 text-center">
<?php
    if (isset($_GET['artist_id'])) {
        $artistID = $_GET['artist_id'];
        $artistName = getArtistName($conn, $artistID);
        $artistIsBand = getArtistIsBand($conn, $artistID);
        
        // display different info depending on if artist is a band or solo artist
        if ($artistIsBand) {
            echo "<div class ='container container-fluid p-0' id='band-results'>";
            echo "<div class='card container-fluid displayTitle'>";
            echo "<h2>${artistName}</h2>";
            echo "</div>";
            
            $bandMemberIDs = getBandMembers($conn, $artistID);
            /* display band members */
            // get the names of the band members
            $bandMemberNames = array();
            for ($i = 0; $i < count($bandMemberIDs); $i++) {
                $bandMemberNames[$i] = getArtistName($conn, $bandMemberIDs[$i]);
            }
            // create links for each band member's artist page
            $members = array();
            for ($i = 0; $i < count($bandMemberIDs); $i++) {
                $members[$i] = "<a href='display_artist.php?artist_id=${bandMemberIDs[$i]}' class='member-links' id='${bandMemberIDs[$i]}'>{$bandMemberNames[$i]}</a>";
            }
            // now print the links
            echo "<div class='displayDetails'";
            echo "<div id='band-members'>";
            echo "<b>Band members:</b> <span id='member-span'>" . implode(", ", $members);
            echo "</span></div>";
        } else {
            echo "<div class ='container' id='solo-results'>";
            echo "<h2>${artistName}</h2>";
        
            $bandIDs = getArtistBands($conn, $artistID);
            /* display the bands */
            // get the names of the bands
            $bandNames = array();
            for ($i = 0; $i < count($bandIDs); $i++) {
                $bandNames[$i] = getArtistName($conn, $bandIDs[$i]);
            }
            // create links for each band's page
            $bands = array();
            for ($i = 0; $i < count($bandIDs); $i++) {
                $bands[$i] = "<a href='display_artist.php?artist_id=${bandIDs[$i]}' class='band-links' id='${bandIDs[$i]}'>{$bandNames[$i]}</a>";
            }

            // now print the bands
            echo "<div id='bands'>";
            echo "Bands: <span id='band-span'>" . implode(", ", $bands);
            echo "</span></div>";
        }
        
        /* Display albums the solo artist has contributed to */
        // TODO: also display albums that the artist has been on through other bands
        printAlbumsAndSongs($conn, $artistID);
        if (isset($_SESSION['username'])) {
            echo "<button class='btn btn-primary' type='button' id='edit-artist-info'>Edit this page</button>";
        } else {
            echo "<p>If you would like to edit or add to the information you see here, you must <a href='login_signup.php'>log in or sign up</a> before editing the page.";
        }
        echo "<br>";
		echo "<br>";
        // get information about the most recent update of information
        $updateInfo = getUpdateInformation($conn, $artistID, "artist");
        $updateUserID = $updateInfo['artist_update_user'];
        if (!($updateUserName = getUserName($conn, $updateUserID))) {
            $updateUserName = "";
        }
        $updateTime = $updateInfo['artist_update_time'];
        echo "</div>";
        echo "<p id='update-info'>Last edited by ${updateUserName} at ${updateTime}</p>";
        echo "</div>";
    } else {
        
    }
    echo "</div>";

    function printAlbumsAndSongs($conn, $artistID) {
        echo "<div id='artist-albums'>";
            // get mysqli_result object for view_artist_album_song
            $albumArtistSong = getArtistAlbumSongByArtist($conn, $artistID);
            $albumLinkArray = array();
            $songLinkArray = array();
            // used to index 2nd dim of songArray
            $songCount;
            // used to check if new indexes in the array need to be created for songs
            $previousAlbumID = 0;
            // create links to albums and songs
            if ($albumArtistSong) {
                while ($row = mysqli_fetch_assoc($albumArtistSong)) {
                    $albumID = $row['album_id'];
                    $songID = $row['song_id'];
                    $songName = $row['song_name'];
                    $trackNumber = $row['song_track_number'];                    
                    if ($albumID == $previousAlbumID) { // just store song link
                        $songLinkArray[$albumID][$songCount] = array(
                                                                     'link' => "<a href='display_song.php?song_id=${songID}' class='album-links' id='${albumID}'>${songName}</a>",
                                                                     'trackNumber' => $trackNumber
                                                                    );
                        $songCount++;
                    } else { // store album link and first song
                        $previousAlbumID = $albumID;
                        $songCount = 0;
                        $albumName = $row['album_name'];
                        $albumLinkArray[$albumID] = "<a href='display_album.php?album_id=${albumID}'>$albumName</a>";
                        $songLinkArray[$albumID][$songCount] = array(
                                                                     'link' => "<a href='display_song.php?song_id=${songID}' class='album-links' id='${albumID}'>${songName}</a>",
                                                                     'trackNumber' => $trackNumber
                                                                    );
                        $songCount++;
                    }
                }
            }
            // finally print the links for the albums
            foreach ($albumLinkArray as $albumID => $albumName) {
                echo "<h4>${albumName}</h4><ul>";
                // print the songs
                foreach ($songLinkArray[$albumID] as $song) {
                    echo "<li>Track ${song['trackNumber']}: ${song['link']}</li>";
                }
                echo "</ol>";
            }
            echo "</div>";
    }
    
    include_once("includes/footer.php");
?>
</div>