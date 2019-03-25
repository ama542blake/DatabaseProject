<?php
    session_start();
    include_once('includes/connection.php');
    include_once('includes/header.php');
    include_once('includes/common_query.php');
    
    if ((isset($_POST['username'])) && (isset($_POST['password']))) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($userID = userExists($conn, $username)) {
            if (userPasswordIsCorrect($conn, $userID, $password)) {
                $_SESSION['username'] = $username;
                echo $_SESSION['username'];
            } else {
            header("Location: login_signup.php");
            }
        } else {
            echo "User doesn't exist";
            header("Location: login_signup.php");
        }
    } else {
        
    }
?>