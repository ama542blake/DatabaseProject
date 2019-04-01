<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account</title>
    <!-- Bootstrap 4.3.1-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- our own CSS -->
    <link rel="stylesheet" href="includes/main.css">
	<link rel="icon" href="images/DB_logo_half.png">
</head>   

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
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $userID;
			header("refresh:2; url=index.php");
            echo "<div class='alert alert-success' role='alert'>Welcome, ${username}. You are now logged in to your new account.</div>";
        } else {
            header("Location: login_signup.php");
            exit;
        }
        
    } else {
        
    }
?>