<?php 
    include_once('includes/header.php');
    include_once('includes/connection.php'); 
?>

<div class="container">
    <div class="card bg-warning mt-5" id="login">
        <div class="card-header">Log In</div>
        <div class="card-body">
            <div class="form-group container">
                <form action="login.php">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class='form-label' for="login_uname">Username
                                <input class="ml-1" type="text" name="login_uname">
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <label class='form-label align-self-end' for="login_pword">Username
                                <input class="ml-1" type="text" name="login_uname">
                            </label>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <div class="card bg-warning mt-3" id="signup">
        <div class="card-header">Sign Up</div>
        <div class="card-body">

        </div>
    </div>

</div>


<hr id="vr">

<?php
    include_once('includes/footer.php');
?>
