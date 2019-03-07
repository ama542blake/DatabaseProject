<?php 
    include_once('includes/header.php');
?>

<form id="song_form" action="add_song_to_db.php" method="post">
    <div class="form-group d-flex flex-column justify-content-center">
        <label>Song name:
            <input class="form-control input-info" type="text" name="song_name" required>
        </label>
        <label>Album:
            <input class="form-control input-info" type="text" name="album_name" required>
        </label>
        <label>Artist:
            <input class="form-control input-info" type="text" name="artist_name" required>
        </label>
        <label>Producer:
            <input class="form-control input-info" type="text" name="producer_name">
        </label>
        <input type="submit" id="submit-song" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>
