
<?php

// Start session if it has not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check whether the user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: ../auth/login.php");
    exit;
}

?>