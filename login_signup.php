<?php 
    include_once('includes/header.php');
?>

<div class="container">
    <div class="card bg-warning mt-5" id="login">
        <div class="card-header">Log In</div>
        <div class="card-body">
            <div class="form-group container">
                <form action="login.php">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class='form-label'>Username
                                <input class="ml-1 form-control" type="text" name="username" required>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <label class='form-label align-self-end'>Password
                                <input class="ml-1 form-control" type="text" name="password" required>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input class="btn btn-outline-dark" type="submit" value="Log In">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="card bg-warning mt-5" id="signup">
        <div class="card-header">Create an account</div>
        <div class="card-body">
            <div class="form-group container">
                <form action="signup.php">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class='form-label'>Select a username:
                                <input class="ml-1 form-control" type="text" name="username" required>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <label class='form-label'>Select a password:
                                <input class="ml-1 form-control" type="text" name="password" required>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class='form-label'>Enter your email address:
                                <input class="ml-1 form-control" type="email" name="email" required>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input class="btn btn-outline-dark" type="submit" value="Create account">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<hr id="vr">

<?php
    include_once('includes/footer.php');
?>
