<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $part_name = trim($_POST["part_name"] ?? "");
    $part_code = trim($_POST["part_code"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $quantity = trim($_POST["quantity"] ?? "");
    $price = trim($_POST["price"] ?? "");
    $reorder_level = trim($_POST["reorder_level"] ?? "");

    // Validation
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

        // Check duplicate part code
        $check_sql = "SELECT id FROM spare_parts WHERE part_code = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $part_code);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {

            $message = "This part code already exists.";
            $message_type = "error";

        } else {

            // Insert spare part
            $sql = "INSERT INTO spare_parts
                    (part_name, part_code, category, quantity, price, reorder_level)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $quantity = (int)$quantity;
            $price = (float)$price;
            $reorder_level = (int)$reorder_level;

            $stmt->bind_param(
                "sssidi",
                $part_name,
                $part_code,
                $category,
                $quantity,
                $price,
                $reorder_level
            );

            if ($stmt->execute()) {
                header("Location: index.php?success=1");
                exit;
            } else {
                $message = "Something went wrong. Please try again.";
                $message_type = "error";
            }

            $stmt->close();
        }

        $check_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Spare Part | Motorcycle Inventory</title>

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
                <a href="../dashboard.php">Dashboard</a>
                <a href="index.php">Inventory</a>
                <a href="add.php" class="active">Add Part</a>
                <a href="../profile.php">Profile</a>
                <a href="../auth/logout.php" class="logout-btn">Logout</a>
            </div>

        </nav>


        <!-- Main Content -->
        <main class="form-page">

            <div class="form-header">

                <div>
                    <span class="page-label">INVENTORY MANAGEMENT</span>

                    <h1>Add Spare Part</h1>

                    <p>
                        Add a new motorcycle spare part to your inventory.
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


            <!-- Form Card -->
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
                                placeholder="Example: Front Brake Pad"
                                value="<?php echo htmlspecialchars($_POST["part_name"] ?? ""); ?>"
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
                                placeholder="Example: BP-001"
                                value="<?php echo htmlspecialchars($_POST["part_code"] ?? ""); ?>"
                                required
                            >

                        </div>


                        <!-- Category -->
                        <div class="form-group">

                            <label for="category">
                                Category <span>*</span>
                            </label>

                            <select id="category" name="category" required>

                                <option value="">Select Category</option>

                                <option value="Brake System"
                                    <?php echo (($_POST["category"] ?? "") === "Brake System") ? "selected" : ""; ?>>
                                    Brake System
                                </option>

                                <option value="Engine"
                                    <?php echo (($_POST["category"] ?? "") === "Engine") ? "selected" : ""; ?>>
                                    Engine
                                </option>

                                <option value="Electrical"
                                    <?php echo (($_POST["category"] ?? "") === "Electrical") ? "selected" : ""; ?>>
                                    Electrical
                                </option>

                                <option value="Transmission"
                                    <?php echo (($_POST["category"] ?? "") === "Transmission") ? "selected" : ""; ?>>
                                    Transmission
                                </option>

                                <option value="Suspension"
                                    <?php echo (($_POST["category"] ?? "") === "Suspension") ? "selected" : ""; ?>>
                                    Suspension
                                </option>

                                <option value="Tires & Wheels"
                                    <?php echo (($_POST["category"] ?? "") === "Tires & Wheels") ? "selected" : ""; ?>>
                                    Tires & Wheels
                                </option>

                                <option value="Body & Accessories"
                                    <?php echo (($_POST["category"] ?? "") === "Body & Accessories") ? "selected" : ""; ?>>
                                    Body & Accessories
                                </option>

                                <option value="Other"
                                    <?php echo (($_POST["category"] ?? "") === "Other") ? "selected" : ""; ?>>
                                    Other
                                </option>

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
                                placeholder="Example: 25"
                                value="<?php echo htmlspecialchars($_POST["quantity"] ?? ""); ?>"
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
                                placeholder="Example: 850.00"
                                value="<?php echo htmlspecialchars($_POST["price"] ?? ""); ?>"
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
                                placeholder="Example: 5"
                                value="<?php echo htmlspecialchars($_POST["reorder_level"] ?? ""); ?>"
                                required
                            >

                            <small>
                                Alert will appear when stock reaches this level.
                            </small>

                        </div>

                    </div>


                    <!-- Buttons -->
                    <div class="form-actions">

                        <a href="index.php" class="cancel-btn">
                            Cancel
                        </a>

                        <button type="submit" class="submit-btn">
                            + Add Spare Part
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