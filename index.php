
<?php
require_once "config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MotoParts | Motorcycle Spare Parts Inventory</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Navigation -->
    <header class="navbar">
        <div class="container nav-container">

            <a href="index.php" class="logo">
                <span class="logo-icon">M</span>
                <span>MotoParts</span>
            </a>

            <nav class="nav-links">
                <a href="index.php" class="active">Home</a>
                <a href="#features">Features</a>
                <a href="#about">About</a>
                <a href="auth/login.php" class="nav-login">Login</a>
                <a href="auth/register.php" class="nav-register">Register</a>
            </nav>

        </div>
    </header>


    <!-- Hero Section -->
    <main>

        <section class="hero">
            <div class="container hero-container">

                <div class="hero-content">

                    <div class="hero-badge">
                        <span class="badge-dot"></span>
                        Smart Inventory Management
                    </div>

                    <h1>
                        Manage Your
                        <span>Motorcycle Parts</span>
                        With Ease
                    </h1>

                    <p>
                        A simple and efficient inventory management system
                        designed to help motorcycle spare parts businesses
                        manage products, stock, suppliers and inventory
                        activities in one place.
                    </p>

                    <div class="hero-buttons">
                        <a href="auth/register.php" class="btn btn-primary">
                            Get Started
                            <span>→</span>
                        </a>

                        <a href="auth/login.php" class="btn btn-secondary">
                            Login to System
                        </a>
                    </div>

                    <div class="hero-info">
                        <div class="info-item">
                            <strong>Easy</strong>
                            <span>to Manage</span>
                        </div>

                        <div class="info-item">
                            <strong>Secure</strong>
                            <span>Authentication</span>
                        </div>

                        <div class="info-item">
                            <strong>Real-time</strong>
                            <span>Stock Tracking</span>
                        </div>
                    </div>

                </div>


                <div class="hero-visual">

                    <div class="dashboard-card">

                        <div class="card-top">
                            <div>
                                <span class="small-label">Inventory Overview</span>
                                <h3>Stock Dashboard</h3>
                            </div>

                            <div class="card-menu">•••</div>
                        </div>

                        <div class="mini-stats">

                            <div class="mini-stat">
                                <span class="mini-icon">📦</span>
                                <div>
                                    <strong>128</strong>
                                    <small>Total Parts</small>
                                </div>
                            </div>

                            <div class="mini-stat">
                                <span class="mini-icon">✓</span>
                                <div>
                                    <strong>104</strong>
                                    <small>In Stock</small>
                                </div>
                            </div>

                        </div>

                        <div class="stock-section">

                            <div class="stock-heading">
                                <span>Stock Status</span>
                                <span>82%</span>
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>

                        </div>

                        <div class="parts-preview">

                            <div class="part-row">
                                <div class="part-symbol">BP</div>

                                <div class="part-details">
                                    <strong>Brake Pad</strong>
                                    <span>Brake System</span>
                                </div>

                                <span class="stock-good">25 pcs</span>
                            </div>


                            <div class="part-row">
                                <div class="part-symbol">CK</div>

                                <div class="part-details">
                                    <strong>Chain Kit</strong>
                                    <span>Transmission</span>
                                </div>

                                <span class="stock-warning">12 pcs</span>
                            </div>


                            <div class="part-row">
                                <div class="part-symbol">OF</div>

                                <div class="part-details">
                                    <strong>Oil Filter</strong>
                                    <span>Engine</span>
                                </div>

                                <span class="stock-good">50 pcs</span>
                            </div>

                        </div>

                    </div>

                    <div class="floating-card floating-card-one">
                        <span>↗</span>
                        <div>
                            <strong>+12.5%</strong>
                            <small>Stock Growth</small>
                        </div>
                    </div>

                    <div class="floating-card floating-card-two">
                        <span>✓</span>
                        <div>
                            <strong>System Ready</strong>
                            <small>All services active</small>
                        </div>
                    </div>

                </div>

            </div>
        </section>


        <!-- Features -->
        <section class="features-section" id="features">

            <div class="container">

                <div class="section-heading">
                    <span class="section-label">FEATURES</span>

                    <h2>
                        Everything you need to manage
                        your inventory
                    </h2>

                    <p>
                        Powerful but simple tools to keep your motorcycle
                        spare parts inventory organized and under control.
                    </p>
                </div>


                <div class="features-grid">

                    <div class="feature-card">
                        <div class="feature-icon">📦</div>

                        <h3>Spare Parts Management</h3>

                        <p>
                            Add, view, update and remove motorcycle spare
                            parts from the inventory.
                        </p>
                    </div>


                    <div class="feature-card">
                        <div class="feature-icon">🔍</div>

                        <h3>Search & Filter</h3>

                        <p>
                            Quickly find spare parts by name, code,
                            category or supplier.
                        </p>
                    </div>


                    <div class="feature-card">
                        <div class="feature-icon">📊</div>

                        <h3>Stock Monitoring</h3>

                        <p>
                            Monitor stock quantities and identify low-stock
                            items before they run out.
                        </p>
                    </div>


                    <div class="feature-card">
                        <div class="feature-icon">🔐</div>

                        <h3>Secure Access</h3>

                        <p>
                            User registration, secure login and session-based
                            access control keep the system protected.
                        </p>
                    </div>

                </div>

            </div>

        </section>


        <!-- About -->
        <section class="about-section" id="about">

            <div class="container about-container">

                <div class="about-content">

                    <span class="section-label">ABOUT THE SYSTEM</span>

                    <h2>
                        A smarter way to manage
                        motorcycle spare parts
                    </h2>

                    <p>
                        MotoParts is a web-based inventory management
                        application developed to simplify the process of
                        managing motorcycle spare parts.
                    </p>

                    <p>
                        The system provides authenticated users with tools
                        to maintain product information, monitor stock
                        levels, search inventory and manage stock activities.
                    </p>

                    <a href="auth/register.php" class="btn btn-primary">
                        Create an Account
                        <span>→</span>
                    </a>

                </div>


                <div class="about-stats">

                    <div class="about-stat">
                        <strong>CRUD</strong>
                        <span>Inventory Operations</span>
                    </div>

                    <div class="about-stat">
                        <strong>PHP</strong>
                        <span>Backend Technology</span>
                    </div>

                    <div class="about-stat">
                        <strong>MySQL</strong>
                        <span>Database System</span>
                    </div>

                    <div class="about-stat">
                        <strong>100%</strong>
                        <span>Web Based</span>
                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- Footer -->
    <footer class="footer">

        <div class="container footer-container">

            <div>
                <a href="index.php" class="logo footer-logo">
                    <span class="logo-icon">M</span>
                    <span>MotoParts</span>
                </a>

                <p>
                    Motorcycle Spare Parts Inventory Management System
                </p>
            </div>

            <div class="footer-right">
                <span>© 2026 MotoParts</span>
                <span>Developed for CSE 472</span>
            </div>

        </div>

    </footer>

</body>
</html>