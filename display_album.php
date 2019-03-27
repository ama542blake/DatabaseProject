<?php
    session_start();
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    
    // make sure the essential variables are set
    if ((isset($_GET['album_id']))) {
        $albumID = $_GET['album_id'];
        $albumName = getAlbumName($conn, $albumID);
        $albumYear = getAlbumYear($conn, $albumID);
        $albumArtworkArtistID = getAlbumArtworkArtistID($conn, $albumID);
        if ($albumArtworkArtistID) {
            $albumArtworkArtistName = getArtworkArtistName($conn, $albumArtworkArtistID);
        } else {
            $albumArtworkArtistName = NULL;
        }
        
        // get the list of artists associated with the album
        $albumArtistIDs = getArtistIDsFromArtistAlbum($conn, $albumID);
        for ($i = 0; $i < count($albumArtistIDs); $i++) {
            $albumArtistNames[$i] = getArtistName($conn, $albumArtistIDs[$i]);
        }
        
        // find the songs on the album
        $albumSongIDs = array();
        $albumSongIDs = getAlbumSongIDs($conn, $albumID);
        $albumSongNames = array();
        for ($i = 0; $i < count($albumSongIDs); $i++) {
            $albumSongNames[$i] = getSongName($conn, $albumSongIDs[$i]);
        }
        
        // set up the printing of the information
        echo "<div class='container' id='results'>";
        echo "<h2>${albumName}</h2>";
        echo "<p>Year Released: <span id='albumYear'>${albumYear}</span></p><br>";
        // TODO eventually make a link that takes to a page that display all albums
        // the artwork artist has done art for (will require creation of diplay_artwork_artist.php, or something like it)
        echo "<p id='albumArtwork'>Artwork Artist: <span id='albumArtworkArtistName'.<a href=''>${albumArtworkArtistName}</a></span></p><br>";
        
        // display the artists        
        echo "<p>By: </p><span id='album-artists'>";
        $artists = array();
        for ($i = 0; $i < count($albumArtistNames); $i++) {
            $artists[$i] = "<a href='display_artist.php?artist_id=${albumArtistIDs[$i]}'>${albumArtistNames[$i]}</a>";
        }
        // this displays the links to the artists in a comma seperated list
        echo implode(", ", $artists);
        echo "</span><br><br>";
        
        // display the songs
        echo "<p>Songs:</p><ul>";
        for ($i = 0; $i < count($albumArtistNames); $i++) {
            $j = $i + 1;
            echo "<li>Track ${j}: <a href='display_song.php?song_id=${albumSongIDs[$i]}'>${albumSongNames[$i]}</a></li>";
        } 
        echo "</ul>";
        echo "<br><br>";
        echo "</div>";
        echo "<button class='btn btn-primary' type='button' id='editAlbumInfo'>Edit this page</button>";
    } else {
    }
    
    include_once("includes/footer.php");
?>