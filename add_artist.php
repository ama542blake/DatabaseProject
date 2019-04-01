<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add artist information</title>
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

<div id="artistImageDiv" class="addImageHeader bold image-fluid text-white text-right p-5 rounded">
    <h1>Add an Artist.</h1>
</div>
<form id="band_form" action="add_artist_to_db.php" method="post">
    <div class="form-group d-flex flex-column jumbotron justify-content-center">
        <label>
            <h3>Artist name:</h3>
            <input class="form-control input-info" type="text" name="artist_name" required>
        </label>
        <label class="mb-3">
            <h4>Is this a solo artist or band?</h4>
            <input id="solo_radio" class="form-check-inline ml-2 mr-1" type="radio" name="isband" value="0" required>Solo
            <input id="band_radio" class="form-check-inline ml-2 mr-1" type="radio" name="isband" value="1" required checked>Band
        </label>
        <label id="band-members-input" class="mb-3">Band Members (optional):
            <input type="text" class="form-control input-info" name="band_members"><br>
            <p>Seperate band names with a comma.</p>
        </label>
        <input type="submit" id="submit-artist" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>
