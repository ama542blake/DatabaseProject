<body>
    <nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><img class="logo mb-1" src="images/DB_logo_full.png"></a>
        <div id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only"></span></a>
                </li>
                <!-- buttons to show if user is logged in -->
                <?php
                if (isset($_SESSION['username'])){ 
                    echo "<li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Add Information
                    </a>
                    <div class='dropdown-menu' id='addDropdown' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' id='addArtistLink' href='add_artist.php'>Add artist</a>
                        <a class='dropdown-item' id='addAlbumLink' href='add_album.php'>Add album</a>
                        <a class='dropdown-item' id='addSongLink' href='add_song.php'>Add song</a>
                    </div>
                </li>";
                echo "<li class=' ml-auto nav-item'><a class='nav-link' href='logout.php'>Log Out</a></li>";
                } else { // user isn't logged in
                    echo "<li class=' ml-auto nav-item'><a class='nav-link' href='login_signup.php'>Login/Signup</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="container">
