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
                header( "refresh:2; url=index.php" );
                echo "Welcome {$username}. Redirecting...";
                exit;
            } else {
                header( "refresh:2; url=login_signup.php" );
                echo "Incorrect credentials. Redirecting...";
                exit;
            }
        } else {
            echo "User doesn't exist";
            header("Location: login_signup.php");
        if ($userID = userExists($conn, $username)) {
            if (userPasswordIsCorrect($conn, $userID, $password)) {
                $_SESSION['username'] = $username;
                header( "refresh:2; url=index.php" );
                echo "Welcome {$username}. Redirecting...";
                exit;
            }
        } else {
            header( "refresh:2; url=login_signup.php" );
            echo "Incorrect credentials. Redirecting...";
            exit;
        }
    }
     else {
        echo "Please enter credentials";
        header( "refresh:2; url=login_signup.php" );
    }
?>
