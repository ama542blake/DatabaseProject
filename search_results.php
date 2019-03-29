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
            echo "<form id='artist_selection' action='show_artist.php' method='post'>"
               . "<input type='hidden' name='selected_id">;
            searchAlbum($conn, $search_query);
            echo "</form>";
        } else if ($searchtype === 'album') {
            echo "<form id='album_selection' action='show_album.php' method='post'>";
            searchAlbum($conn, $search_query);
            echo "</form>";
        } else if ($searchtype === 'song') {
            echo "<form id='song_selection' action='show_song.php' method='post'>";
            searchSong($conn, $search_query);
            echo "</form>";
        } else {
            echo "<div>" . "<h2>Artists</h2>" 
               . "<form id='artist_selection' action='show_artist.php' method='post'>";
               . "<input type='hidden' name='selected_id'>";
             searchArtist($conn, $search_query);
             echo "</form>" . "</div>" . "<div>"
                . "<h2>Albums</h2>"
                . "<form id='album_selection' action='show_album.php' method='post'>";
             searchAlbum($conn, $search_query);
             echo "</form>" . "</div>" . "<div>"
                . "<form id='song_selection' action='show_song.php' method='post'>";
             searchSong($conn, $search_query);
             echo "</form></div>"; 
        }
    }
    
    include_once('includes/footer.php');
?>
