<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataBass</title>
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

<div class="jumbotron bg-warning mt-5">
    <h1 class="display-4 text-center">Find out everything you've ever wanted to know about your favorite artists, albums, and songs.</h1>
    <hr>
    <form class="d-flex flex-column" action="search.php" method="get">
        <input class="align-self-center form-control" style="width:85%;text-align:center" type="search" name="searchquery" required>
        <button class="align-self-center btn btn-outline-dark mt-3 mb-2" type="submit" style="width:50%">Search</button>
        <div class="align-self-center">
           <div class="form-check-inline mt-1">
                <label class="form-check=label"><input class="form-check-input" type="radio" name="searchtype" value="all" checked>All</label>
            </div>
            <div class="form-check-inline mt-1">
                <label class="form-check-label"><input class="form-check-input" type="radio" name="searchtype" value="artist">Artist</label>
            </div>
            <div class="form-check-inline mt-1">
                <label class="form-check-label"><input class="form-check-input" type="radio" name="searchtype" value="album">Album</label>
            </div>
            <div class="form-check-inline mt-1">
                <label class="form-check=label"><input class="form-check-input" type="radio" name="searchtype" value="song">Song</label>
            </div>
        </div>
    </form>
</div>


<!-- The following three divs will be used to display a list of most recently added/updated info -->
<div id="recentAritsts">

</div>

<div id="recentAlbums">

</div>

<div id="recentSongs">

</div>
<div id ="aboutWrapper" class="jumbotron">
 <div class="aboutBox jumbotron">
  <div>
   <h2 class="text-left">About DataBass</h2>
   <p>DataBass is a service which lets its users add
    edit information regarding bands' songs,
    albums, and membership.
   </p>
  </div>
 </div>
</div>

<?php include_once('includes/footer.php'); ?>
