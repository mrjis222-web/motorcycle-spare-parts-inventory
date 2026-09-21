<?php

require_once "includes/auth_check.php";
require_once "config/db.php";

$user_id = $_SESSION["user_id"];

$sql = "SELECT id, name, email FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "User not found.";
    exit;
}

$user = $result->fetch_assoc();

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | MotoParts</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="page-shell">

    <!-- Navbar -->

    <nav class="navbar">

        <div class="nav-brand">

            <a href="dashboard.php">
                🏍️ MotoParts
            </a>

        </div>

        <div class="nav-links">

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="inventory/index.php">
                Inventory
            </a>

            <a href="inventory/add.php">
                Add Part
            </a>

            <a href="profile.php" class="active">
                Profile
            </a>

            <a href="auth/logout.php" class="logout-btn">
                Logout
            </a>

        </div>

    </nav>


    <!-- Profile -->

    <main class="profile-page">

        <div class="profile-header">

            <span class="page-label">
                ACCOUNT
            </span>

            <h1>
                My Profile
            </h1>

            <p>
                View your account information and session details.
            </p>

        </div>


        <div class="profile-layout">

            <!-- Profile Card -->

            <div class="profile-card">

                <div class="profile-avatar">
                    <?php echo strtoupper(substr($user["name"], 0, 1)); ?>
                </div>

                <h2>
                    <?php echo htmlspecialchars($user["name"]); ?>
                </h2>

                <p class="profile-role">
                    Inventory Management User
                </p>

                <a
                    href="auth/logout.php"
                    class="profile-logout"
                >
                    Logout
                </a>

            </div>


            <!-- Information Card -->

            <div class="information-card">

                <div class="information-header">

                    <h2>
                        Account Information
                    </h2>

                    <span class="account-status">
                        Active
                    </span>

                </div>


                <div class="information-list">

                    <div class="information-item">

                        <span>
                            Full Name
                        </span>

                        <strong>
                            <?php echo htmlspecialchars($user["name"]); ?>
                        </strong>

                    </div>


                    <div class="information-item">

                        <span>
                            Email Address
                        </span>

                        <strong>
                            <?php echo htmlspecialchars($user["email"]); ?>
                        </strong>

                    </div>


                    <div class="information-item">

                        <span>
                            User ID
                        </span>

                        <strong>
                            #<?php echo (int)$user["id"]; ?>
                        </strong>

                    </div>


                    <div class="information-item">

                        <span>
                            Account Status
                        </span>

                        <strong class="active-text">
                            Active
                        </strong>

                    </div>

                </div>

            </div>

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