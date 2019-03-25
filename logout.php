<?php
    if (isset($_GET['logout'])) {
        if ($_GET['logout'] == 1) {
            unset($_SESSION['username']);
            echo "REDIR";
            sleep(5);
            header("Location: index.php");
        } else {
            echo "invalid";
        }
    }
?>