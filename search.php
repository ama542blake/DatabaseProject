<?php 
    include_once('includes/header.php'); 
    include_once('includes/connection.php');

    if ((isset($_GET['searchquery'])) && (isset($_GET['searchtype']))) {
        // what the user has typed in for what they want to search for
        $searchQuery = $_GET['searchquery'];
        // possible values 'all', 'artist', 'album', 'song'
        $searchType = $_GET['searchtype'];
        
        // decide how to search the database
        switch ($searchType) {
            case "all":
                searchArtist($conn, $searchQuery);
                searchAlbum($conn, $searchQuery);
                searchSong($conn, $searchQuery);
                break;
            case "artist":
                searchArtist($conn, $searchQuery);
                break;
            case "album":
                searchAlbum($conn, $searchQuery);
                break;
            case "song":
                searchSong($conn, $searchQuery);
                break;
            default:
                echo "This page has been reached in error";
        }
        
    } else {
        echo "You have reached this page due to an error.";
    }


    function searchArtist($conn, $searchQuery) {
        $query = "SELECT * FROM artist WHERE artist_name LIKE '%${searchQuery}%' LIMIT 10";
        $result = mysqli_query($conn, $query);
        
        if($result) {
            //used to count the artist number so that the array (0 indexed) can be properly populated
            $artistNum = 0;
            $artists = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['artist_id'];
                $name = $row['artist_name'];
                //for now, we don't care about whether artist is solo or band in search, but may in future
                
                // add artist to array
                $artists[$artistNum] = 
                    array(
                            'name' => $name,
                            'id' => $id
                        );
                $artistNum++;
            }
            // finally, print the results to the screen
            displayArtistSearchResult($artists);   
        } else {
            echo "Your artist search yielded no results.";
        }
    }

    function searchAlbum($conn, $searchQuery) {
        $query = "SELECT * FROM album WHERE album_name LIKE '%${searchQuery}%' LIMIT 10";
        $result = mysqli_query($conn, $query);
        
        if($result) {
            //used to count the artist number so that the array (0 indexed) can be properly populated
            $albumNum = 0;
            $albums = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo $albumNum . "<br>";
                $id = $row['album_id'];
                $name = $row['album_name'];
                if ($row['album_released_year']) {
                    $yearReleased = $row['album_released_year'];
                } else {
                    $yearReleased = NULL;
                }
                //for now we don't care about who the artwork artist is, but we may in the future
                
                // add album to array
                $album[$albumNum] = 
                    array(
                            'name' => $name,
                            'id' => $id,
                            'year' => $yearReleased
                        );
                $albumNum++;
                echo "++" . $name . " -- " . $id . " -- " . $yearReleased . "<br>";
            }
            // finally, print the results to the screen
            displayAlbumSearchResult($albums);   
        } else {
            echo "Your album search yielded no results.";
        }
    }

    function searchSong($conn, $searchQuery) {
        $query = "SELECT * FROM artist WHERE song_name LIKE '%${searchQuery}%' LIMIT 10";
        $result = mysqli_query($conn, $query);
    }

    function displayArtistSearchResult($artists) {
        foreach($artists as $artist) {
            $name = $artist['name'];
            $id = $artist['id'];
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='#'>${name}</a>"
                . " </div>";
        }
    }

    // TODO: make these display the artist name(s), clean up the placement of  year, for now I just wanted to make this kind of work
    function displayAlbumSearchResult($albums) {
        echo count($albums);
        foreach($albums as $album) {
            $name = $album['name'];
            $id = $album['id'];
            $year = $album['year'];
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='#'>${name}</a><p> Released: ${year}"
                . " </div>";
        }
    }
?>