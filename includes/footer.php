        </div>    <!-- end of the div with the container class from header -->
    </div>
</body>

<script src="add_artist.js"></script>
<!-- scripts needed for bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- our scripts -->
<?php
    $pageName = $_SERVER['SCRIPT_NAME'];

    if (strpos($pageName, "login_signup.php") !== FALSE) {
        echo "<script src='validation_functions.js'></script>";
    } else if (strpos($pageName, "display_song.php") !== FALSE) {
        echo "<script src='edit_song.js'></script>";
    }
    else if (strpos($pageName, "display_album.php") !== FALSE) {
        echo "<script src='edit_album.js'></script>";
    }
    
?>
</html>