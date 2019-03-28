<?php
    session_start();
    include_once('includes/header.php');
    include_once('includes/connection.php');
    include_once('includes/common_query.php');

    if ((isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['email']))) {        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if (!(getUserID($conn, $username))) {  
            $query = "INSERT INTO user (user_username, user_pword, user_email, user_is_admin) VALUES ('${username}', '${password}', '${email}', 0)";
            mysqli_query($conn, $query);
            $userID = mysqli_insert_id($conn);
			header( "refresh:2; url=login_signup.php" );
            echo "<div class='alert alert-success' role='alert'>Welcome, ${username}. Please log in using your new account.</div>";
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $userID;
        } else {
            header("Location: login_signup.php");
            exit;
        }
        
    } else {
        
    }
?>