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
    <label class='form-label'><h5>Username</h5>
     <input class="ml-1 form-control m-2" id="loginUsername" placeholder="Username" type="text" name="username" required>
    </label>
   </div>
   <div>
    <label class='form-label align-self-end'><h5>Password</h5>
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
    <label class='form-label'><h5>Select a username:</h5>
     <input class="ml-1 form-control" type="text" name="username" required>
    </label>
   </div>
   <div>
    <label class='form-label'><h5>Select a password:</h5>
     <input class="ml-1 form-control" type="text" name="password" required>
    </label>
   </div>
   <div>
    <label class='form-label'><h5>Enter your email address:</h5>
     <input class="ml-1 form-control" type="email" name="email" required>
    </label>
   </div>
   <div>
    <input class="btn btn-outline-dark" type="submit" value="Create account">
   </div>
  </div>
 </form>
</div>

<form action="logout.php" method="GET"><input type="submit" name="logout" value="2"></form>



<hr id="vr">

<?php
    include_once('includes/footer.php');
?>
