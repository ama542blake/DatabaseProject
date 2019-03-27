<?php
    session_start();
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
?>
<div class="jumbotron">
<?php
    if (isset($_GET['artist_id'])) {
        $artistID = $_GET['artist_id'];
        $artistName = getArtistName($conn, $artistID);
        $artistIsBand = getArtistIsBand($conn, $artistID);
    
        echo "<div class ='container' id='results'>";
        echo "<h2>${artistName}</h2>";
        
        // display different info depending on if artist is a band or solo artist
        if ($artistIsBand) {
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
                $members[$i] = "<a href='display_artist.php?artist_id=${bandMemberIDs[$i]}'>{$bandMemberNames[$i]}</a>";
            }
            // now print the links
            echo "<div id='band-members'>";
            echo "Band members: " . implode(", ", $members);
            echo "</div>";
            
            /* display albums the band contributed to, and the songs on that album that they were part of */
            printAlbumsAndSongs($conn, $artistID);
        
            echo "</div>";
            
        } else {
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
                $bands[$i] = "<a href='display_artist.php?artist_id=${bandIDs[$i]}'>{$bandNames[$i]}</a>";
            }
            // now print the bands
            echo "<div id='bands'>";
            echo "Bands: <span id='bands>'" . implode(", ", $bands);
            echo "</span></div>";
            
            /* Display albums the solo artist has contributed to */
            // TODO: also display albums that the artist has been on through other bands
            printAlbumsAndSongs($conn, $artistID);

        echo "</div>";
        }  
    } else {
        
    }

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
                    if ($albumID == $previousAlbumID) { // just store song link
                        $songLinkArray[$albumID][$songCount] = "<a href='display_song.php?song_id=${songID}'>${songName}</a>";
                        $songCount++;
                    } else { // store album link and first song
                        $songCount = 0;
                        $albumName = $row['album_name'];
                        $albumLinkArray[$albumID] = "<a href='display_album.php?album_id=${albumID}'>$albumName</a>";
                        $songLinkArray[$albumID][$songCount] = "<a href='display_song.php?song_id=${songID}'>${songName}</a>";
                        $songCount++;
                    }
                }
            }
            // finally print the links for the albums
            foreach ($albumLinkArray as $albumID => $albumName) {
                echo "<h4>${albumName}</h4><ol>";
                // print the songs
                foreach ($songLinkArray[$albumID] as $songName) {
                    echo "<li>${songName}</li>";
                }
                echo "</ol>";
            }
            echo "</div>";
    }
    
    include_once("includes/footer.php");
?>
</div>
