<?php 
    include_once('includes/header.php');
?>

<div class="container p-0 text-center">
 <form class="displayBlock jumbotron logInForm pagination-centered p-0" action="login.php">
  <div class="card logInHeader p-3">
   <h1>Log-In</h1>
  </div>
  <div class="p-3">
   <div>
    <label class='form-label'><h5>Username</h5>
     <input class="ml-1 form-control m-2" type="text" name="username" required>
    </label>
   </div>
   <div>
    <label class='form-label align-self-end'><h5>Password</h5>
     <input class="ml-1 form-control m-2" type="text" name="password" required>
    </label>
   </div>
   <div>
    <input class="btn btn-outline-dark m-3" type="submit" value="Log In">
   </div>
  </div>
 </form>
 
 <form class="displayBlock jumbotron logInForm pagination-centered p-0" action="signup.php">
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



<hr id="vr">

<?php
    include_once('includes/footer.php');
?>
