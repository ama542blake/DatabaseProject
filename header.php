<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Info</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><i class="fas fa-headphones"></i></a>
        <div id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only"></span></a>
                </li>
                <!-- buttons to show is user is logged in -->
                <!-- if (isset($_SESSION['user_username'])){ -->
                <!-- echo ' -->
                <li class="nav-item dropdown">
                    <!--  if this stops working, add id="navbarDropdown" -->
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Add Information
                    </a>
                    <div class="dropdown-menu" id="addDropdown" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" id="addArtistLink" href="add_artist.php">Add album</a>
                        <a class="dropdown-item" id="addAlbumLink" href="add_album.php">Add album</a>
                        <a class="dropdown-item" id="addSongLink" href="add_song.php">Add song</a>
                    </div>
                </li>
                <!--'; -->
                <!--} else { // buttons to show when no user is logged in -->
                <!--echo '-->
                <li class="nav-item">
                    <a class="nav-link" href="login_signup.php">Login/Signup</a>
                </li>
                <!--';-->
                <!--}-->
                <!-- ?> -->
            </ul>

        </div>
    </nav>
