
<?php

require_once "../config/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Basic validation
    if ($name === "" || $email === "" || $password === "" || $confirm_password === "") {

        $error = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters long.";

    } elseif ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check whether email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);

        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();

        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {

            $error = "An account with this email already exists.";

        } else {

            // Secure password hashing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $insert_sql = "
                INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)
            ";

            $insert_stmt = $conn->prepare($insert_sql);

            $insert_stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if ($insert_stmt->execute()) {

                $success = "Registration successful! You can now login.";

                // Clear form values
                $name = "";
                $email = "";

            } else {

                $error = "Something went wrong. Please try again.";
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register | MotoParts</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body class="auth-page">

    <div class="auth-wrapper">

        <div class="auth-brand">

            <a href="../index.php" class="logo">
                <span class="logo-icon">M</span>
                <span>MotoParts</span>
            </a>

            <div class="auth-brand-content">

                <span class="section-label">
                    MOTORCYCLE INVENTORY
                </span>

                <h1>
                    Manage your spare parts
                    with confidence.
                </h1>

                <p>
                    Create your account and start managing
                    motorcycle spare parts, stock levels and
                    inventory activities from one place.
                </p>

                <div class="auth-benefits">

                    <div>
                        <span>✓</span>
                        Secure user authentication
                    </div>

                    <div>
                        <span>✓</span>
                        Easy inventory management
                    </div>

                    <div>
                        <span>✓</span>
                        Search and monitor stock
                    </div>

                </div>

            </div>

        </div>


        <div class="auth-form-section">

            <div class="auth-form-container">

                <a href="../index.php"
                   class="mobile-auth-logo logo">

                    <span class="logo-icon">M</span>
                    <span>MotoParts</span>

                </a>


                <div class="auth-heading">

                    <span class="section-label">
                        GET STARTED
                    </span>

                    <h2>Create your account</h2>

                    <p>
                        Register to access the inventory management system.
                    </p>

                </div>


                <?php if ($error !== ""): ?>

                    <div class="alert alert-error">
                        <span>!</span>
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>


                <?php if ($success !== ""): ?>

                    <div class="alert alert-success">
                        <span>✓</span>
                        <?= htmlspecialchars($success) ?>
                    </div>

                <?php endif; ?>


                <form method="POST"
                      action=""
                      class="auth-form">

                    <div class="form-group">

                        <label for="name">
                            Full Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your full name"
                            value="<?= htmlspecialchars($name ?? "") ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="<?= htmlspecialchars($email ?? "") ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimum 6 characters"

                                                        required
                        >

                    </div>


                    <div class="form-group">

                        <label for="confirm_password">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Re-enter your password"
                            required
                        >

                    </div>


                    <button type="submit" class="auth-submit">
                        Create Account
                        <span>→</span>
                    </button>

                </form>


                <div class="auth-switch">

                    Already have an account?

                    <a href="login.php">
                        Login here
                    </a>

                </div>


                <a href="../index.php" class="back-home">
                    ← Back to Home
                </a>

            </div>

        </div>

    </div>

</body>

</html>