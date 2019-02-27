<div class="search_result">

<?php
    include_once('header.php');
    include_once('connection.php');
    
    if (!isset($_POST['searchquery'])) {
        echo 'Something went wrong. Please return to the search page and try again.';
        die();
    } else {
        $searchtype = $_POST['searchtype'];
        $search_query = $_POST['searchquery'];
        
        if ($searchtype === 'artist') {
            echo "<form id='artist_selection' action='show_artist.php' method='post'>";
            search_artist($search_query);
            echo "</form>";
        } else if ($searchtype === 'album') {
            echo "<form id='album_selection' action='show_album.php' method='post'>";
            search_album($search_query);
            echo "</form>";
        } else if ($searchtype === 'song') {
            echo "<form id='album_selection' action='show_song.php' method='post'>";
            search_song($search_query);
            echo "</form>";
        }
    }

    function search_artist($query) {
        global $conn;
        $query = "SELECT artist_id, artist_name FROM artist WHERE artist_name LIKE '${%query%}'";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['artist_id'];
            $name = $row['artist_name'];
            echo "<p class='form-submit-link' id='${id}'>${name}</p><br><hr><br>";
        }
    }

    function search_album($query) {
        
    }

    function search_song($query) {
        
    }
?>


<div class='search_result'>
    <a href="#" onclick="document.getElementById('myForm').submit();">Submit</a>
</div>