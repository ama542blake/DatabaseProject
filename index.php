<?php 
    include_once('header.php'); 
    include_once('connection.php');
?>

<div class="jumbotron bg-warning mt-5">
    <h1 class="display-4 text-center">Find out everything you've ever wanted to know about your favorite artists, albums, and songs.</h1>
    <hr>
    <form class="d-flex flex-column" action="search_results.php" method="post">
        <input class="align-self-center form-control" style="width:85%;text-align:center" type="search" name="searchquery" required>
        <button class="align-self-center btn btn-outline-dark mt-3 mb-2" type="submit" style="width:50%">Search</button>
        <div class="align-self-center">
            <div class="form-check-inline mt-1">
                <label class="form-check-label"><input class="form-check-input" type="radio" name="searchtype" value="artist" checked>Artist</label>
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

<?php include_once('footer.php'); ?>
