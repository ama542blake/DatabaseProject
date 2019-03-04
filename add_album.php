<?php 
    include_once('includes/header.php');
    include_once('includes/connection.php');
?>
<form id="album_form" action="add_album_to_db.php" method="post">
    <div class="form-group d-flex flex-column justify-content-center">
        <label class="mb-3">Name:
            <input class="form-control input-info" type="text" name="album_name" required>
        </label>
        <label class="mb-3">Artist:
            <input class="form-control input-info" type="text" name="album_artist" required>
        </label>
        <label class="mb-3">Album artwork artist:
            <input class="form-control input-info" type="text" name="album_artwork_artist">
        </label>
        <input type="submit" id="submit-album" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>