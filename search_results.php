<div class="search_result">

<?php
    session_start();
    include_once('includes/header.php');
    
    if (!isset($_POST['searchquery'])) {
        echo 'Something went wrong. Please return to the search page and try again.';
        die();
    } else {
        $searchtype = $_POST['searchtype'];
        $search_query = $_POST['searchquery'];
        
        if ($searchtype === 'artist') {
            echo "<form id='artist_selection' action='show_artist.php' method='post'>";
            echo "<input type='hidden' name='selected_id">
<<<<<<< HEAD
            search_artist($search_query);
            
=======
            searchAlbum($search_query);
>>>>>>> 4d259d002cd9241dde51e1f85df03550a1c10575
            echo "</form>";
            echo "artist fired";
        } else if ($searchtype === 'album') {
            echo "<form id='album_selection' action='show_album.php' method='post'>";
<<<<<<< HEAD
            search_album($search_query);
            
=======
            searchAlbum($search_query);
>>>>>>> 4d259d002cd9241dde51e1f85df03550a1c10575
            echo "</form>";
            echo "album fired";
        } else if ($searchtype === 'song') {
            echo "<form id='song_selection' action='show_song.php' method='post'>";
<<<<<<< HEAD
            search_song($search_query);
            
=======
            searchSong($conn, $search_query);
>>>>>>> 4d259d002cd9241dde51e1f85df03550a1c10575
            echo "</form>";
            echo "song fired";
        } else {
            echo "<div>";
             echo "<h2>Artists</h2>";
             echo "<form id='artist_selection' action='show_artist.php' method='post'>";
             echo "<input type='hidden' name='selected_id'>";
<<<<<<< HEAD

             search_artist($search_query);
=======
             echo "dgdgdsfg";
             searchArtist($conn, $search_query);
>>>>>>> 4d259d002cd9241dde51e1f85df03550a1c10575
             echo "</form>";
            echo "</div>";
            echo "<div>";
             echo "<h2>Albums</h2>";
             echo "<form id='album_selection' action='show_album.php' method='post'>";
             searchAlbum($conn, $search_query);
             echo "</form>";
            echo "</div>";
            echo "<div>";            
             echo "<form id='song_selection' action='show_song.php' method='post'>";
             searchSong($conn, $search_query);
             echo "</form>";
            echo "</div>"; 
        }
    }
    
    include_once('includes/footer_search_results.php');
?>
