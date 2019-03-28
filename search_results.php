<div class="search_result">

<?php
    session_start();
    include_once('includes/header.php');
    include_once('includes/connection.php');
    
    if (!isset($_POST['searchquery'])) {
        echo 'Something went wrong. Please return to the search page and try again.';
        die();
    } else {
        $searchtype = $_POST['searchtype'];
        $search_query = $_POST['searchquery'];
        
        if ($searchtype === 'artist') {
            echo "<form id='artist_selection' action='show_artist.php' method='post'>";
            echo "<input type='hidden' name='selected_id">
            search_artist($search_query);
            echo "</form>";
        } else if ($searchtype === 'album') {
            echo "<form id='album_selection' action='show_album.php' method='post'>";
            search_album($search_query);
            echo "</form>";
        } else if ($searchtype === 'song') {
            echo "<form id='song_selection' action='show_song.php' method='post'>";
            search_song($search_query);
            echo "</form>";
        } else {
            echo "<div>";
             echo "<h2>Artists</h2>";
             echo "<form id='artist_selection' action='show_artist.php' method='post'>";
             echo "<input type='hidden' name='selected_id'>";
             echo "dgdgdsfg";
             search_artist($search_query);
             echo "</form>";
            echo "</div>";
            echo "<div>";
             echo "<h2>Albums</h2>";
             echo "<form id='album_selection' action='show_album.php' method='post'>";
             search_album($search_query);
             echo "</form>";
            echo "</div>";
            echo "<div>";            
             echo "<form id='song_selection' action='show_song.php' method='post'>";
             search_song($search_query);
             echo "</form>";
            echo "</div>"; 
            
        }
    }

    function search_artist($conn, $query) {
        //TODO: get error when using % in LIKE clause, so... fix that
        $query = "SELECT artist_id, artist_name FROM artist WHERE artist_name LIKE '${query}'";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['artist_id'];
            $name = $row['artist_name'];
            echo "<p class='form-submit-link' id='${id}'>${name}</p><br><hr><br>";
        }
    }

    function search_album($conn, $query) {
        //TODO: get error when using % in LIKE clause, so... fix that
        $query = "SELECT album_id, album_name FROM album WHERE album_name LIKE '${query}'";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['album_id'];
            $name = $row['album_name'];
            echo "<p class='form-submit-link' id='${id}'>${name}</p><br><hr><br>";
        }
    }

    function search_song($conn, $query) {
        global $conn;
        //TODO: get error when using % in LIKE clause, so... fix that
        $query = "SELECT song_id, song_name FROM song WHERE song_name LIKE '${query}'";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['song_id'];
            $name = $row['song_name'];
            echo "<p class='form-submit-link' id='${id}'>${name}</p><br><hr><br>";
        }
    }
    
    include_once('includes/footer_search_results.php');
?>
