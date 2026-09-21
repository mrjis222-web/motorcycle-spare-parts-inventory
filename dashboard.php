
<?php

require_once "includes/auth_check.php";
require_once "config/db.php";

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Total different spare parts
$total_parts = 0;

$result = $conn->query("SELECT COUNT(*) AS total FROM spare_parts");

if ($result) {
    $row = $result->fetch_assoc();
    $total_parts = (int) $row["total"];
}


// Total stock quantity
$total_stock = 0;

$result = $conn->query("SELECT COALESCE(SUM(quantity), 0) AS total FROM spare_parts");

if ($result) {
    $row = $result->fetch_assoc();
    $total_stock = (int) $row["total"];
}


// Low stock items
$low_stock = 0;

$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM spare_parts
    WHERE quantity <= reorder_level
");

if ($result) {
    $row = $result->fetch_assoc();
    $low_stock = (int) $row["total"];
}


// Total inventory value
$total_value = 0;

$result = $conn->query("
    SELECT COALESCE(SUM(quantity * price), 0) AS total
    FROM spare_parts
");

if ($result) {
    $row = $result->fetch_assoc();
    $total_value = (float) $row["total"];
}


// Recent spare parts
$recent_parts = [];

$result = $conn->query("
    SELECT id, part_name, part_code, category, quantity, price, reorder_level
FROM spare_parts
ORDER BY id DESC
LIMIT 6
");

if ($result) {

    while ($row = $result->fetch_assoc()) {
        $recent_parts[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard | MotoParts</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>


<body class="dashboard-page">


<!-- =========================================
     Dashboard Navbar
     ========================================= -->

<header class="dashboard-navbar">

    <div class="dashboard-nav-container">

        <a href="dashboard.php" class="logo">

            <span class="logo-icon">M</span>

            <span>MotoParts</span>

        </a>


        <nav class="dashboard-nav-links">

            <a href="dashboard.php" class="dashboard-active">
                Dashboard
            </a>

            <a href="inventory/index.php">
                Inventory
            </a>

            <a href="profile.php">
                Profile
            </a>

            <a href="auth/logout.php"
               class="dashboard-logout">
                Logout
            </a>

        </nav>

    </div>

</header>


<!-- =========================================
     Dashboard Content
     ========================================= -->

<main class="dashboard-main">

    <div class="dashboard-container">


        <!-- Welcome -->

        <section class="dashboard-welcome">

            <div>

                <span class="dashboard-label">
                    INVENTORY OVERVIEW
                </span>

                <h1>
                    Welcome back,
                    <?= htmlspecialchars($_SESSION["user_name"]) ?>!
                </h1>

                <p>
                    Here's what's happening with your inventory today.
                </p>

            </div>


            <a href="inventory/add.php"
               class="btn btn-primary">

                + Add Spare Part

            </a>

        </section>


        <!-- =================================
             Statistics
             ================================= -->

        <section class="stats-grid">


            <div class="stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon stat-icon-red">
                        📦
                    </div>

                    <span class="stat-label">
                        PARTS
                    </span>

                </div>

                <strong>
                    <?= number_format($total_parts) ?>
                </strong>

                <span class="stat-description">
                    Different spare parts
                </span>

            </div>


            <div class="stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon stat-icon-blue">
                        📊
                    </div>

                    <span class="stat-label">
                        STOCK
                    </span>

                </div>

                <strong>
                    <?= number_format($total_stock) ?>
                </strong>

                <span class="stat-description">
                    Total units available
                </span>

            </div>


            <div class="stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon stat-icon-orange">
                        ⚠
                    </div>

                    <span class="stat-label">
                        ALERT
                    </span>

                </div>

                <strong>
                    <?= number_format($low_stock) ?>
                </strong>

                <span class="stat-description">
                    Low stock items
                </span>

            </div>


            <div class="stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon stat-icon-green">
                        ৳
                    </div>

                    <span class="stat-label">
                        VALUE
                    </span>

                </div>

                <strong>
                    ৳<?= number_format($total_value, 2) ?>
                </strong>

                <span class="stat-description">
                    Current inventory value
                </span>

            </div>


        </section>


        <!-- =================================
             Main Dashboard Grid
             ================================= -->

        <section class="dashboard-grid">


            <!-- Recent Parts -->

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>

                        <span class="panel-label">
                            INVENTORY
                        </span>

                        <h2>
                            Recent Spare Parts
                        </h2>

                    </div>

                    <a href="inventory/index.php"
                       class="view-all">
                        View All →
                    </a>

                </div>


                <div class="parts-table-wrapper">

                    <?php if (count($recent_parts) > 0): ?>

                        <table class="parts-table">

                            <thead>

                                <tr>

                                    <th>Part</th>

                                    <th>Category</th>

                                    <th>Stock</th>

                                    <th>Price</th>

                                    <th>Status</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($recent_parts as $part): ?>

                                    <?php

                                    $is_low =
                                        $part["quantity"] <=
                                        $part["reorder_level"];

                                    ?>

                                    <tr>

                                        <td>

                                            <div class="table-part">

                                                <div class="table-part-icon">
                                                    <?= strtoupper(
                                                        substr($part["part_name"], 0, 2)
                                                    ) ?>
                                                </div>

                                                <div>

                                                    <strong>
                                                        <?= htmlspecialchars($part["part_name"]) ?>
                                                    </strong>

                                                    <small>
                                                        <?= htmlspecialchars($part["part_code"]) ?>
                                                    </small>

                                                </div>

                                            </div>

                                        </td>


                                        <td>
                                            <?= htmlspecialchars($part["category"]) ?>
                                        </td>


                                        <td>
                                            <?= number_format($part["quantity"]) ?>
                                        </td>


                                        <td>
                                            ৳<?= number_format(
                                                $part["price"],
                                                2
                                            ) ?>
                                        </td>


                                        <td>

                                            <?php if ($is_low): ?>

                                                <span class="status status-low">
                                                    Low Stock
                                                </span>

                                            <?php else: ?>

                                                <span class="status status-good">
                                                    In Stock
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    <?php else: ?>

                        <div class="empty-state">

                            <div class="empty-icon">
                                📦
                            </div>

                            <h3>
                                No spare parts yet
                            </h3>

                            <p>
                                Add your first spare part to get started.
                            </p>

                            <a href="inventory/add.php"
                               class="btn btn-primary">
                                Add Spare Part
                            </a>

                        </div>

                    <?php endif; ?>

                </div>

            </div>


            <!-- Quick Actions -->

            <div class="dashboard-panel quick-panel">

                <div class="panel-header">

                    <div>

                        <span class="panel-label">
                            QUICK ACTIONS
                        </span>

                        <h2>
                            Manage Inventory
                        </h2>

                    </div>

                </div>


                <div class="quick-actions">

                    <a href="inventory/add.php"
                       class="quick-action">

                        <div class="quick-action-icon">
                            +
                        </div>

                        <div>

                            <strong>
                                Add Spare Part
                            </strong>

                            <span>
                                Create a new inventory item
                            </span>

                        </div>

                        <span class="quick-arrow">
                            →
                        </span>

                    </a>


                    <a href="inventory/index.php"
                       class="quick-action">

                        <div class="quick-action-icon">
                            ≡
                        </div>

                        <div>

                            <strong>
                                View Inventory
                            </strong>

                            <span>
                                Browse all spare parts
                            </span>

                        </div>

                        <span class="quick-arrow">
                            →
                        </span>

                    </a>


                    <a href="profile.php"
                       class="quick-action">

                        <div class="quick-action-icon">
                            ◉
                        </div>

                        <div>

                            <strong>
                                My Profile
                            </strong>

                            <span>
                                View account information
                            </span>

                        </div>

                        <span class="quick-arrow">
                            →
                        </span>

                    </a>

                </div>


                <!-- Low Stock Alert -->

                <div class="low-stock-box">

                    <div class="low-stock-icon">
                        !
                    </div>

                    <div>

                        <strong>
                            <?= $low_stock ?> Low Stock
                            <?= $low_stock === 1 ? "Item" : "Items" ?>
                        </strong>

                        <span>
                            Check your inventory for items
                            that need restocking.
                        </span>

                    </div>

                </div>

            </div>

        </section>


    </div>

</main>


<footer class="dashboard-footer">

    <span>
        © 2026 MotoParts
    </span>

    <span>
        CSE 472 · Web and Internet Programming
    </span>

</footer>


</body>

</html>