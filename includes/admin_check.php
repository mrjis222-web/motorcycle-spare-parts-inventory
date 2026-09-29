
<?php

require_once __DIR__ . "/auth_check.php";

// Only Admin users can access this page
if (($_SESSION["user_role"] ?? "") !== "admin") {

    header("Location: ../dashboard.php");
    exit;
}

?>