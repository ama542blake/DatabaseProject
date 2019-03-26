<?php
    session_start();
    // clears all session variables
    $_SESSION = array();
    header("Location: index.php");
?>