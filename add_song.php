<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add song information</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add song information</title>
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
?>
<div id="songImageDiv" class="addImageHeader bold image-fluid text-white text-right p-5 rounded">
     <h1>Add a Song.</h1>
</div>
<form id="song_form" action="add_song_to_db.php" method="post">
    <div class="form-group d-flex flex-column jumbotron justify-content-center">
        <label><h3>Song name:</h3>
            <input class="form-control input-info" type="text" name="song_name" required>
        </label>
        <label><h3>Album track number:</h3>
            <input class="form-control input-info" type="text" name="song_track_number">
        </label>
        <label><h4>Album:</h4>
            <input class="form-control input-info" type="text" name="album_name" required>
        </label>
        <label><h4>Artist:</h4>
            <input class="form-control input-info" type="text" name="artist_names" required>
        </label>
        <label><h4>Genre:</h4>
            <input class="form-control input-info" type="text" name="genre">
        </label>
        <input type="submit" id="submit-song" class="btn btn-outline-dark input-info">
    </div>
</form>


<?php
    include_once('includes/footer.php');
?>
