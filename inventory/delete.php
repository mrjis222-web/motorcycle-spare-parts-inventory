<?php

require_once "../includes/auth_check.php";
require_once "../config/db.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/* Delete spare part */

$sql = "DELETE FROM spare_parts WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php?deleted=1");
    exit;

} else {

    echo "Unable to delete the spare part.";

}

$stmt->close();

?>