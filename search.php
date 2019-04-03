<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search results</title>
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
    include_once('includes/header.php'); 
    include_once('includes/connection.php');
?>
<div class="container-fluid jumbotron text-center" id="searchResults">
 <div class="card" id="searchResultsTitle">
  <h1>Results</h1>
 </div>
 <div id="searchResultsList"> 
<?php
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
                $artistID = $row['artist_id'];
                $artistName = $row['artist_name'];
                //for now, we don't care about whether artist is solo or band in search, but may in future
                
                // add artist to array
                $artists[$artistNum] = 
                    array(
                            'artistName' => $artistName,
                            'artistID' => $artistID
                        );
                $artistNum++;
            }
            // finally, print the results to the screen
             echo "<form id='artist_selection' action='show_artist.php' method='post'>";
             echo "<input type='hidden' name='selected_id'>";
            echo displayArtistSearchResult($artists);
            echo "</form>";        
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
                $albumID = $row['album_id'];
                $albumName = $row['album_name'];
                if ($row['album_released_year']) {
                    $yearReleased = $row['album_released_year'];
                } else {
                    $yearReleased = NULL;
                }
                //for now we don't care about who the artwork artist is, but we may in the future
                
                // add album to array
                $albums[$albumNum] = 
                    array(
                            'albumName' => $albumName,
                            'albumID' => $albumID,
                            'albumYear' => $yearReleased
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
                $songID = $row['song_id'];
                $songName = $row['song_name'];
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
                    $genreName = $row['song_genre'];
                } else {
                    $genreName = NULL;
                }
                
                // get $albumID and $albumName
                $albumIDQuery = "SELECT album_id FROM album_song WHERE song_id = ${songID}";
                $albumIDResult = mysqli_query($conn, $albumIDQuery);
                if ($albumIDResult) {
                    $albumID = mysqli_fetch_assoc($albumIDResult)['album_id'];
                    $albumNameQuery = "SELECT album_name FROM album WHERE album_id = ${albumID}";
                    $albumNameResult = mysqli_query($conn, $albumNameQuery);
                    if ($albumNameResult) {
                        $albumName = mysqli_fetch_assoc($albumNameResult)['album_name'];
                    } else {
                        //TODO handle in a more comprehensive way
                        $albumName = NULL;
                    }
                } else {
                    //TODO handle this in a more comprehensive way 
                    $albumID = NULL;
                }
                
                // get $aristID and $artistName
                $artistIDQuery = "SELECT artist_id FROM artist_song WHERE song_id=${songID}";
                $artistIDResult = mysqli_query($conn, $artistIDQuery);
                if ($artistIDResult) {
                    $artistID = mysqli_fetch_assoc($artistIDResult)['artist_id'];
                    $artistNameQuery = "SELECT artist_name FROM artist WHERE artist_id = ${artistID}";
                    $artistNameResult = mysqli_query($conn, $artistNameQuery);
                    if ($artistNameResult) {
                        $artistName = mysqli_fetch_assoc($artistNameResult)['artist_name'];
                    } else {
                        //TODO handle in a more comprehensive way
                        $artistName = NULL;
                    }
                } else {
                    //TODO handle this in a more comprehensive way 
                    $artistID = NULL;
                }
                
                // add song to array
                $songs[$songNum] = 
                    array(
                            'songName' => $songName,
                            'songID' => $songID,
                            'producerID' => $producerID,
                            'producerName' => $producerName,
                            'genreName' => $genreName,
                            'albumName' => $albumName,
                            'albumID' => $albumID,
                            'artistName' => $artistName,
                            'artistID' => $artistID
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
        echo "<div class='card displayResultsTypeDiv pb-3 text-center'>"; 
         echo "<div class='card'>";
          echo "<h2>Artists</h2>";
        echo "</div>";
        foreach($artists as $artist) {
            $artistName = $artist['artistName'];
            $artistID = $artist['artistID']; // need this to add to link to go that artist page
            
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='display_artist.php?artist_id=${artistID}'><b>${artistName}</b></a>"
                . " </div>";
        }
            echo "</div>";
    }

    // TODO: make these display the artist name(s), clean up the placement of  year, for now I just wanted to make this kind of work
    function displayAlbumSearchResult($albums) {
        echo "<div class='card displayResultsTypeDiv my-4 pb-3 text-center'>"; 
        echo "<div class='card'>";
        echo "<h2>Albums</h2>";
       echo "</div>";
         echo "<form id='album_selection' action='show_album.php' method='post'>";
        foreach($albums as $album) {
            $albumName = $album['albumName'];
            $albumID = $album['albumID']; // need to to add to link to go to that album's page
            $albumYear = $album['albumYear'];
            
            echo "<div class='search-result' id='artist-results'>"
                .    "<a href='display_album.php?album_id=${albumID}'><b>${albumName}</b></a>";
            if ($albumYear) {echo " - (${albumYear})";}
            echo "</div>";
            }
           echo "</form>";
          echo "</div>";
        }

    function displaySongSearchResult($songs) {
       echo "<div class='card displayResultsTypeDiv my-4 pb-3 text-center'>"; 
        echo "<div class='card'>";
        echo "<h2>Songs</h2>";
       echo "</div>";        
       echo "<form id='song_selection' action='show_song.php' method='post'>"; 
        foreach($songs as $song) {
            $songName = $song['songName'];
            $songID = $song['songID'];
            $producerID = $song['producerID'];
            $producerName = $song['producerName'];
            $genreName = $song['genreName'];
            $albumName = $song['albumName'];
            $albumID = $song['albumID'];
            $artistName = $song['artistName'];
            $artistID = $song['artistID'];
            echo "<div id='song-results'>"
                .    "<span> <a href='display_song.php?song_id=${songID}'><b>${songName}</b></a></span><br>";
            echo "<b>By:</b> ${artistName}<br>";
            echo "<b>On:</b> ${albumName}<br>";
            if ($genreName) {echo "<b>Genre:</b> ${genreName}<br>";}
            if ($producerName) {echo "<b>Producer:</b> ${producerName}<br>";}
            echo "</div>";
            }
           echo "</form>";
            echo "</div>"; 
        }
     include_once('includes/footer.php');
     
?>
 </div>
</div>
