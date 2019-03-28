<?php
    session_start();
    include_once('includes/connection.php');
    include_once('includes/header.php');
    include_once('includes/common_query.php');
    
    if ((isset($_POST['username'])) && (isset($_POST['password']))) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($userID = getUserID($conn, $username)) {
            if (userPasswordIsCorrect($conn, $userID, $password)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $userID;
                header( "refresh:2; url=index.php" );
                echo "<div class='alert alert-success' role='alert'>Welcome {$username}. Redirecting...</div>";
                exit;
            } else {
                header( "refresh:2; url=login_signup.php" );
                echo "<div class='alert alert-danger' role='alert'>Incorrect credentials. Redirecting...</div>";
                exit;
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>User doesn't exist</div>";
            header("Location: login_signup.php");
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Please enter credentials</div>";
        header( "refresh:2; url=login_signup.php" );
    }
?>
