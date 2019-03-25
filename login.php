<?php
    session_start();
    include_once('includes/connection.php');
    include_once('includes/header.php');
    
    if ((isset($_POST['username'])) && (isset($_POST['password']))) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($userID = userExists($conn, $username)) {
            if (userPasswordIsCorrect($conn, $userID, $password)) {
                $_SESSION['username'] = $username;
            }
        } else {
            header("Location: login_signup.php");
        }
    }
     else {
        echo "please enter credentials";
    }
?>