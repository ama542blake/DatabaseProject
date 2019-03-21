<?
    include_once("includes/header.php");
    include_once("includes/connection.php");
    include_once("includes/common_query.php");
    
    if (isset($_GET['artist_id'])) {
        $artistID = $_GET['artist_id'];
        $artistName = getArtistName($conn, $artistID);
        $artistIsBand = getArtistIsBand($conn, $artistID);
    
        echo "<div class ='container' id='results'>";
        
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
            
            echo "<div id='band-members'>";
            echo implode(", ", $members);
            echo "</div>";
            
            /* display albums the band contributed to, and the songs on that album that they were part of */
            
        } else {
            $bandIDs = getArtistBands($conn, $artistID);
            
            // get the names of the bands
            $bandNames = array();
            for ($i = 0; $i < count($bandIDs); $i++) {
                $bandNames[$i] = getArtistName($conn, $bandIDs[$i]);
            }
            // create links for each band's artist page
            $bands = array();
            for ($i = 0; $i < count($bandIDs); $i++) {
                $bands[$i] = "<a href='display_artist.php?artist_id=${bandIDs[$i]}'>{$bandNames[$i]}</a>";
            }
            
            // get albums that the solo artist has put out (solo)
            // TODO: also display albums that the artist has been on through other bands
            $artistAlbumSong = getArtistAlbumSongByArtist($conn, $artistID);
            // use this to index an array to hold the links to the albums/songs
            $numAlbums = 0;
            // array to hold the HTML formatted links and lists of the album song combinations 
            $albumSongLinkArray = array();
            foreach($artistAlbumSong as $albumID => $album) {
                $albumName = getAlbumName($conn, $albumID);
                for ($i = 0; $i < count($album); $i++) {
                    
                }
                $numAlbums++;
            }
            
            
            // now display all collected info
            echo "<div id='bands'>";
            echo implode(", ", $bands);
            echo "</div>";
        }
        
        echo "</div>";
        
    } else {
        
    }

    include_once("includes/footer.php");
?>