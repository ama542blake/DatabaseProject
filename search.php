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
                $id = $row['album_id'];
                $name = $row['album_name'];
                if ($row['album_released_year']) {
                    $yearReleased = $row['album_released_year'];
                } else {
                    $yearReleased = NULL;
                }
                //for now we don't care about who the artwork artist is, but we may in the future
                
                // add album to array
                $albums[$albumNum] = 
                    array(
                            'name' => $name,
                            'id' => $id,
                            'year' => $yearReleased
                        );
                $albumNum++;
            }
            // finally, print the results to the screen
            displayAlbumSearchResult($albums);   
        } else {
            echo "Your album search yielded no results.";
        }
    }

    function searchSong($conn, $searchQuery) {
        $query = "SELECT * FROM song WHERE song_name LIKE '%${searchQuery}%' LIMIT 10";
        $result = mysqli_query($conn, $query);
        
        if($result) {
            //used to count the song number so that the array (0 indexed) can be properly populated
            $songNum = 0;
            $songs = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['song_id'];
                $name = $row['song_name'];
                //set $producerName
                if ($row['song_producer']) {
                    $producerID = $row['song_producer'];
                    $producerQuery = "SELECT producer_name FROM producer WHERE producer_id = ${producerID}";
                    $producerResult = mysqli_query($conn, $producerQuery);
                    if ($producerResult) {
                        $producerName = mysqli_fetch_assoc($producerResult)['producer_name'];
                    } else {
                        $producerName = NULL;
                    }
                } else {
                    $producerID = NULL;
                    $producerName = NULL;
                }
                // set $genreName
                if ($row['song_genre']) {
                    $genreID = $row['song_genre'];
                    $genreQuery = "SELECT genre_name FROM genre WHERE genre_id = ${genreID}";
                    $genreResult = mysqli_query($conn, $genreQuery);
                    if ($genreResult) {
                        $genreName = mysqli_fetch_assoc($genreResult)['genre_name'];
                    } else {
                        $genreName = NULL;
                    }
                } else {
                    $genreID = NULL;
                    $genreName = NULL;
                }
                
                // add song to array
                $songs[$songNum] = 
                    array(
                            'name' => $name,
                            'id' => $id,
                            'producerID' => $producerID,
                            'producerName' => $producerName,
                            'genreID' => $genreID,
                            'genreName' => $genreName
                        );
                $songNum++;
            }
            // finally, print the results to the screen
            displaySongSearchResult($songs);   
        } else {
            echo "Your song search yielded no results.";
        }
    }

    function displayArtistSearchResult($artists) {
        foreach($artists as $artist) {
            $name = $artist['name'];
            $id = $artist['id']; // need this to add to link to go that artist page
            
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='#'>${name}</a>"
                . " </div>";
        }
    }

    // TODO: make these display the artist name(s), clean up the placement of  year, for now I just wanted to make this kind of work
    function displayAlbumSearchResult($albums) {
        foreach($albums as $album) {
            $name = $album['name'];
            $id = $album['id']; // need to to add to link to go to that album's page
            $year = $album['year'];
            
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='#'>${name}</a>";
            if ($year) {echo " - (${year})";}
            echo "</div>";
            }
        }

    function displaySongSearchResult($songs) {
        foreach($songs as $song) {
            $name = $song['name'];
            $id = $song['id'];
            $producerID = $song['producerID'];
            $producerName = $song['producerName'];
            $genreID = $song['genreID'];
            $genreName = $song['genreName'];
            echo "name: ${name}<br>prodID: ${producerID}<br>producerName: ${producerName}";
            
            
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='#'>${name}</a>";
            //if ($genreName) {echo "Genre: (${genreName})";}
            {echo "Genre: (${genreName})";}
            {echo "Producer: (${producerName})";}
            //if ($producerName) {echo "Producer: (${producerName})";}
            echo "</div>";
            }
        }
?>