<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in or sign up</title>
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
?>

<div class="container p-0 text-center">
    <form class="displayBlock jumbotron logInForm pagination-centered p-0" id="loginForm" method="post" action="login.php">
        <div class="card logInHeader p-3">
            <h1>Log-In</h1>
        </div>
        <div class="p-3">
            <div>
                <label class='form-label'>
                    <h5>Username</h5>
                    <input class="ml-1 form-control m-2" id="loginUsername" placeholder="Username" type="text" name="username" required>
                </label>
            </div>
            <div>
                <label class='form-label align-self-end'>
                    <h5>Password</h5>
                    <input class="ml-1 form-control m-2" id="loginPassword" placeholder="Password" type="password" name="password" required disabled>
                </label>
            </div>
            <div>
                <input class="btn btn-outline-dark m-3" id="loginBtn" type="submit" value="Log In" disabled>
            </div>
        </div>
    </form>

    <form class="displayBlock jumbotron logInForm pagination-centered p-0" method="post" action="signup.php">
        <div class="card logInHeader p-3">
            <h1>Sign-up</h1>
        </div>
        <div class="p-3">
            <div>
                <label class='form-label'>
                    <h5>Select a username:</h5>
                    <input class="ml-1 form-control" id="createUsername" type="text" name="username" required>
                </label>
            </div>
            <div>
                <label class='form-label'>
                    <h5>Select a password:</h5>
                    <input class="ml-1 form-control" id="createPassword" type="text" name="password" required disabled>
                </label>
            </div>
            <div>
                <label class='form-label'>
                    <h5>Enter your email address:</h5>
                    <input class="ml-1 form-control" id="createEmail" type="email" name="email" required disabled>
                </label>
            </div>
            <div>
                <input class="btn btn-outline-dark" id="createBtn" type="submit" value="Create account" disabled>
            </div>
        </div>
    </form>
</div>

<hr id="vr">

<?php
    include_once('includes/footer.php');
?>
