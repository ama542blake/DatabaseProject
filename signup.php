<?php
    session_start();
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    if ((isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['email']))) {        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if (!(userExists($conn, $username))) {  
            $query = "INSERT INTO user (user_username, user_pword, user_email, user_is_admin) VALUES ('${username}', '${password}', '${email}', 0)";
            mysqli_query($conn, $query);
            echo "Welcome, ${username}.";
            $_SESSION['username'] = $username;
        } else {
            header("Location: login_signup.php");
            exit;
        }
        
    } else {
        
    }
?>