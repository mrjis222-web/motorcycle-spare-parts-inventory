<?php

session_start();

require_once "../config/db.php";

$error = "";

if (isset($_SESSION["user_id"])) {
    header("Location: ../dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: ../dashboard.php");
                exit;

            } else {

                $error = "Invalid email or password.";
            }

        } else {

            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | MotoParts</title>

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
                    Your inventory,
                    under control.
                </h1>

                <p>
                    Login to manage motorcycle spare parts,
                    monitor stock levels and keep your inventory
                    organized.
                </p>

                <div class="auth-benefits">

                    <div>
                        <span>✓</span>
                        Secure authentication
                    </div>

                    <div>
                        <span>✓</span>
                        Real-time inventory access
                    </div>

                    <div>
                        <span>✓</span>
                        Organized stock management
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
                        WELCOME BACK
                    </span>

                    <h2>Login to your account</h2>

                    <p>
                        Enter your credentials to continue.
                    </p>

                </div>


                <?php if ($error !== ""): ?>

                    <div class="alert alert-error">

                        <span>!</span>

                        <?= htmlspecialchars($error) ?>

                    </div>

                <?php endif; ?>


                <form method="POST"
                      action=""
                      class="auth-form">

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
                            placeholder="Enter your password"
                            required
                        >

                    </div>


                    <button type="submit"
                            class="auth-submit">

                        Login
                        <span>→</span>

                    </button>

                </form>


                <div class="auth-switch">

                    Don't have an account?

                    <a href="register.php">
                        Create an account
                    </a>

                </div>


                <a href="../index.php"
                   class="back-home">

                    ← Back to Home

                </a>

            </div>

        </div>

    </div>

</body>

</html>