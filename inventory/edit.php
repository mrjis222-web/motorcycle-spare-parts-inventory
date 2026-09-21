<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$message = "";
$message_type = "";

/* Fetch existing part */
$sql = "SELECT id, part_name, part_code, category, quantity, price, reorder_level
        FROM spare_parts
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}

$part = $result->fetch_assoc();
$stmt->close();


/* Update part */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $part_name = trim($_POST["part_name"] ?? "");
    $part_code = trim($_POST["part_code"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $reorder_level = trim($_POST["reorder_level"] ?? "");

    if (
        $part_name === "" ||
        $part_code === "" ||
        $category === "" ||
        $quantity === "" ||
        $price === "" ||
        $reorder_level === ""
    ) {
        $message = "Please fill in all required fields.";
        $message_type = "error";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $message = "Quantity must be a valid positive number.";
        $message_type = "error";
    } elseif (!is_numeric($price) || $price < 0) {
        $message = "Price must be a valid positive number.";
        $message_type = "error";
    } elseif (!is_numeric($reorder_level) || $reorder_level < 0) {
        $message = "Reorder level must be a valid positive number.";
        $message_type = "error";
    } else {

        /* Check duplicate part code */
        $check_sql = "SELECT id FROM spare_parts
                      WHERE part_code = ? AND id != ?";

        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $part_code, $id);
        $check_stmt->execute();

        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {

            $message = "This part code already exists.";
            $message_type = "error";

        } else {

            $update_sql = "UPDATE spare_parts
                           SET part_name = ?,
                               part_code = ?,
                               category = ?,
                               quantity = ?,
                               price = ?,
                               reorder_level = ?
                           WHERE id = ?";

            $update_stmt = $conn->prepare($update_sql);

            $quantity = (int)$quantity;
            $price = (float)$price;
            $reorder_level = (int)$reorder_level;

           $update_stmt->bind_param(
    "sssidii",
    $part_name,
    $part_code,
    $category,
    $quantity,
    $price,
    $reorder_level,
    $id
);


            if ($update_stmt->execute()) {
                header("Location: index.php?updated=1");
                exit;
            } else {
                $message = "Unable to update the spare part.";
                $message_type = "error";
            }

            $update_stmt->close();
        }

        $check_stmt->close();
    }

    /* Keep submitted values in form */
    $part["part_name"] = $part_name;
    $part["part_code"] = $part_code;
    $part["category"] = $category;
    $part["quantity"] = $quantity;
    $part["price"] = $price;
    $part["reorder_level"] = $reorder_level;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Spare Part | MotoParts</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="page-shell">

    <!-- Navbar -->

    <nav class="navbar">

        <div class="nav-brand">

            <a href="../dashboard.php">
                🏍️ MotoParts
            </a>

        </div>

        <div class="nav-links">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="index.php" class="active">
                Inventory
            </a>

            <a href="add.php">
                Add Part
            </a>

            <a href="../profile.php">
                Profile
            </a>

            <a href="../auth/logout.php" class="logout-btn">
                Logout
            </a>

        </div>

    </nav>


    <!-- Main -->

    <main class="form-page">

        <div class="form-header">

            <div>

                <span class="page-label">
                    INVENTORY MANAGEMENT
                </span>

                <h1>
                    Edit Spare Part
                </h1>

                <p>
                    Update the information of this inventory item.
                </p>

            </div>

            <a href="index.php" class="back-btn">
                ← Back to Inventory
            </a>

        </div>


        <?php if ($message !== ""): ?>

            <div class="alert-message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>


        <div class="form-card">

            <form method="POST" action="">

                <div class="form-grid">

                    <!-- Part Name -->

                    <div class="form-group full-width">

                        <label for="part_name">
                            Part Name <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="part_name"
                            name="part_name"
                            value="<?php echo htmlspecialchars($part["part_name"]); ?>"
                            required
                        >

                    </div>


                    <!-- Part Code -->

                    <div class="form-group">

                        <label for="part_code">
                            Part Code <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="part_code"
                            name="part_code"
                            value="<?php echo htmlspecialchars($part["part_code"]); ?>"
                            required
                        >

                    </div>


                    <!-- Category -->

                    <div class="form-group">

                        <label for="category">
                            Category <span>*</span>
                        </label>

                        <select
                            id="category"
                            name="category"
                            required
                        >

                            <option value="">
                                Select Category
                            </option>

                            <?php
                            $category_list = [
                                "Brake System",
                                "Engine",
                                "Electrical",
                                "Transmission",
                                "Suspension",
                                "Tires & Wheels",
                                "Body & Accessories",
                                "Other"
                            ];

                            foreach ($category_list as $cat):
                            ?>

                                <option
                                    value="<?php echo htmlspecialchars($cat); ?>"
                                    <?php echo ($part["category"] === $cat) ? "selected" : ""; ?>
                                >
                                    <?php echo htmlspecialchars($cat); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Quantity -->

                    <div class="form-group">

                        <label for="quantity">
                            Quantity <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            min="0"
                            value="<?php echo htmlspecialchars($part["quantity"]); ?>"
                            required
                        >

                    </div>


                    <!-- Price -->

                    <div class="form-group">

                        <label for="price">
                            Unit Price (৳) <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            min="0"
                            step="0.01"
                            value="<?php echo htmlspecialchars($part["price"]); ?>"
                            required
                        >

                    </div>


                    <!-- Reorder Level -->

                    <div class="form-group">

                        <label for="reorder_level">
                            Reorder Level <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="reorder_level"
                            name="reorder_level"
                            min="0"
                            value="<?php echo htmlspecialchars($part["reorder_level"]); ?>"
                            required
                        >

                        <small>
                            Low-stock alert threshold.
                        </small>

                    </div>

                </div>


                <div class="form-actions">

                    <a href="index.php" class="cancel-btn">
                        Cancel
                    </a>

                    <button type="submit" class="submit-btn">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </main>


    <footer class="footer">

        <p>
            © 2026 MotoParts Inventory Management System
        </p>

    </footer>

</div>

</body>
</html>