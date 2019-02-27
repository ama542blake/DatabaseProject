<?php 
    include_once('includes/header.php');
    include_once('includes/connection.php');

    function print_artist_info($id, $name, $is_band) {
     echo "<div id='${id}'>
            <ul>
                <li>
                    <label class='infolabel'>Artist Name:</label><p>${name}</p>
                </li>
             </ul>
            </div>";
    }
    
    // assuming that the form will be submitted with a name like artist_id, but double check once that page is written
    if (!isset($_POST['artist_id'])) {
        header("Location: search_results.php");
    } else {
        $artist_id = $_POST('artist_id');
        $query = "SELECT artist_name, artist_is_band FROM artist WHERE artist_id = ${artist_id}";
        $result = $msqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $artist_name = $row('artist_name');
            $artist_is_band = $row('artist_is_band');
            
            print_artist_info($artist_id, $artist_name, $artist_is_band);
            
        }
    }

    include_once('includes/footer.php');
?>



