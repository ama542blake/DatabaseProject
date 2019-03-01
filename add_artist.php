<?php 
    include_once('includes/header.php');
    include_once('includes/connection.php');
?>

<form id="band_form" action="add_artist_to_db.php" method="post">
    <div class="form-group">
        <label>Artist name: 
            <input class="form-control" type="text" name="artist_name" required>
        </label>
        <label>Is this a solo artist or band? (has more than 1 member)?
            <input id="solo_radio"class="form-check" type="radio" name="isband" value="0" required>Solo
            <input id="band_radio" class="form-check" type="radio" name="isband" value="1" required checked>Band
        </label>
        <input type="submit" class="btn btn-outline-dark"> 
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>