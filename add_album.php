<?php
    session_start();
    include_once('includes/header.php');
    include_once('includes/connection.php');
?>
<div id="albumImageDiv" class="addImageHeader bold image-fluid text-white text-right p-5 rounded">
     <h1>Add an Album.</h1>
</div>
<form id="album_form" action="add_album_to_db.php" method="post">
    <div class="form-group d-flex flex-column jumbotron justify-content-center">
        <label class="mb-3"><h3>Album Name:</h3>
            <input class="form-control input-info" type="text" name="album_name" required>
        </label>
        <label class="mb-3"><h4>Artist:</h4>
            <input class="form-control input-info" type="text" name="album_artist" required>
        </label>
        <label class="mb-3"><h4>Year released:</h4>
            <input class="form-control input-info" type="number" name="album_year_released" maxlength="4">
        </label>
        <label class="mb-3"><h4>Album artwork artist:</h4>
            <input class="form-control input-info" type="text" name="album_artwork_artist">
        </label>
        <input type="submit" id="submit-album" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>