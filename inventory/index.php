<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";

$search = trim($_GET["search"] ?? "");
$category = trim($_GET["category"] ?? "");

$sql = "SELECT id, part_name, part_code, category, quantity, price, reorder_level
        FROM spare_parts
        WHERE 1=1";

$params = [];
$types = "";

if ($search !== "") {
    $sql .= " AND (part_name LIKE ? OR part_code LIKE ?)";
    $search_value = "%" . $search . "%";

    $params[] = $search_value;
    $params[] = $search_value;
    $types .= "ss";
}

if ($category !== "") {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$categories = $conn->query(
    "SELECT DISTINCT category FROM spare_parts ORDER BY category ASC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory | MotoParts</title>

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
    <main class="inventory-page">

    <?php if (isset($_GET["deleted"])): ?>

    <div class="success-message">
        Spare part deleted successfully.
    </div>

<?php endif; ?>


<?php if (isset($_GET["updated"])): ?>

    <div class="success-message">
        Spare part updated successfully.
    </div>

<?php endif; ?>


<?php if (isset($_GET["success"])): ?>

    <div class="success-message">
        Spare part added successfully.
    </div>

<?php endif; ?>

        <div class="inventory-header">

            <div>

                <span class="page-label">
                    INVENTORY MANAGEMENT
                </span>

                <h1>
                    Spare Parts Inventory
                </h1>

                <p>
                    View, search, filter and manage all motorcycle spare parts.
                </p>

            </div>

            <a href="add.php" class="add-part-btn">
                + Add Spare Part
            </a>

        </div>


        <!-- Search & Filter -->
        <div class="filter-card">

            <form method="GET" action="">

                <div class="search-box">

                    <label for="search">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        placeholder="Search by part name or part code..."
                        value="<?php echo htmlspecialchars($search); ?>"
                    >

                </div>


                <div class="category-box">

                    <label for="category">
                        Category
                    </label>

                    <select id="category" name="category">

                        <option value="">
                            All Categories
                        </option>

                        <?php while ($cat = $categories->fetch_assoc()): ?>

                            <option
                                value="<?php echo htmlspecialchars($cat["category"]); ?>"
                                <?php echo ($category === $cat["category"]) ? "selected" : ""; ?>
                            >
                                <?php echo htmlspecialchars($cat["category"]); ?>
                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>


                <div class="filter-buttons">

                    <button type="submit" class="search-btn">
                        Search
                    </button>

                    <a href="index.php" class="reset-btn">
                        Reset
                    </a>

                </div>

            </form>

        </div>


        <!-- Inventory Table -->
        <div class="inventory-card">

            <div class="inventory-card-header">

                <div>

                    <h2>
                        All Spare Parts
                    </h2>

                    <p>
                        <?php echo $result->num_rows; ?> item(s) found
                    </p>

                </div>

            </div>


            <?php if ($result->num_rows > 0): ?>

                <div class="table-wrapper">

                    <table class="inventory-table">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Part Name</th>

                                <th>Part Code</th>

                                <th>Category</th>

                                <th>Quantity</th>

                                <th>Unit Price</th>

                                <th>Status</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php while ($part = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    #<?php echo (int)$part["id"]; ?>
                                </td>

                                <td>
                                    <strong>
                                        <?php echo htmlspecialchars($part["part_name"]); ?>
                                    </strong>
                                </td>

                                <td>
                                    <span class="part-code">
                                        <?php echo htmlspecialchars($part["part_code"]); ?>
                                    </span>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($part["category"]); ?>
                                </td>

                                <td>
                                    <?php echo (int)$part["quantity"]; ?>
                                </td>

                                <td>
                                    ৳<?php echo number_format((float)$part["price"], 2); ?>
                                </td>

                                <td>

                                    <?php if ((int)$part["quantity"] <= (int)$part["reorder_level"]): ?>

                                        <span class="status-badge low">
                                            Low Stock
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge available">
                                            Available
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="edit.php?id=<?php echo (int)$part["id"]; ?>"
                                            class="edit-btn"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="delete.php?id=<?php echo (int)$part["id"]; ?>"
                                            class="delete-btn"
                                            onclick="return confirm('Are you sure you want to delete this spare part?');"
                                        >
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="empty-inventory">

                    <div class="empty-icon">
                        📦
                    </div>

                    <h3>
                        No spare parts found
                    </h3>

                    <p>
                        Try a different search or add your first spare part.
                    </p>

                    <a href="add.php" class="add-part-btn">
                        + Add Spare Part
                    </a>

                </div>

            <?php endif; ?>

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