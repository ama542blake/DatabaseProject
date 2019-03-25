<?php 
    session_start();
    include_once('includes/header.php');
?>
<div id="songImageDiv" class="addImageHeader bold image-fluid text-white text-right p-5 rounded">
     <h1>Add a Song.</h1>
</div>
<form id="song_form" action="add_song_to_db.php" method="post">
    <div class="form-group d-flex flex-column jumbotron justify-content-center">
        <label><h3>Song name:</h3>
            <input class="form-control input-info" type="text" name="song_name" required>
        </label>
        <label><h4>Album:</h4>
            <input class="form-control input-info" type="text" name="album_name" required>
        </label>
        <label><h4>Artist:</h4>
            <input class="form-control input-info" type="text" name="artist_name" required>
        </label>
        <label><h4>Genre:</h4>
            <input class="form-control input-info" type="text" name="genre">
        </label>
        <label><h4>Producer:</h4>
            <input class="form-control input-info" type="text" name="producer_name">
        </label>
        <input type="submit" id="submit-song" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>
