<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adding to the database</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>

<?php
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');
    session_start();

    if ((isset($_POST['album_name'])) && (isset($_POST['album_artist'])) && (isset($_SESSION['user_id']))) {
        $userID = $_SESSION['user_id'];
        
        $albumName = mysqli_real_escape_string($conn, $_POST['album_name']);
        $artistName = mysqli_real_escape_string($conn, $_POST['album_artist']);
        $artworkArtistName = mysqli_real_escape_string($conn, $_POST['album_artwork_artist']);
        $releasedYear = mysqli_real_escape_string($conn, $_POST['album_year_released']);
        
        if ($artworkArtistName) {
            $artworkArtistID = getArtworkArtistID($conn, $artworkArtistName);
            if(!$artworkArtistID) {
                $artworkArtistID = insertArtworkArtist($conn, $artworkArtistName);
            }
        } else {
            $artworkArtistID = NULL;
        }
        // check if an album with the name exists
        // TODO need to make add artwork artist search and insert
        $artistID = getArtistID($conn, $artistName);
        if ($artistID) {
            if (getAlbumID($conn, $artistID, $albumName, $artworkArtistID)) {
				header( "refresh:2; url=add_album.php" );
                echo "<div class='alert alert-danger' role='alert'>${albumName} by ${artistName} is already in the database.</div>";
				exit;
            } else {
				insertAlbum($conn, $artistID, $albumName, $artworkArtistID, $releasedYear, $userID);
				header( "refresh:2; url=add_album.php" );
				echo "<div class='alert alert-success' role='alert'>${albumName} by ${artistName} successfully added. Redirecting...</div>";
                exit;
            }
        } else {        
            // album is not in database if the artist is not in the database
            // (can't have an album if there was no artist to create it)
            // TODO find a way to allow user to choose whether the artist is a band or solo, for now assume yes
            $newArtistID = insertArtist($conn, $artistName, 1, $userID);
            insertAlbum($conn, $newArtistID, $albumName, $artworkArtistID, $releasedYear, $userID);
			header( "refresh:2; url=add_album.php" );
			echo "<div class='alert alert-success' role='alert'>New Artist: ${artistName} and album: ${albumName} successfully added. Redirecting...</div>";
			exit;
        }
    }   

?>
<?php
    include_once('includes/footer.php');
?>
