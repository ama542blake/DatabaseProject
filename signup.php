<?php
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    if ((isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['email']))) {
        echo userExists($conn, $_POST['username']);
    }
?>