<?php
/*
Member Dashboard - 876JA Digital Online Teaching Resources
This is the authenticated user homepage shown after login.
*/

// Start session and protect this page for logged-in users only.
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = '876JA Digital Online Teaching Resources | Dashboard';
$activePage = 'dashboard';

// Helper to set active nav class on the current page.
function navActive($page, $activePage)
{
    return $page === $activePage ? ' active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item"><a class="nav-link<?php echo navActive('dashboard', $activePage); ?>" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Resource Catalog</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Subscription Plans</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('payment', $activePage); ?>" href="payment.php">Payments</a></li>
                <li class="nav-item"><a class="nav-login-btn" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section">
    <div class="container text-center">
        <h1>Welcome back, <?php echo htmlspecialchars((string) ($_SESSION['username'] ?? 'Member'), ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="mx-auto mt-3">
            This is your dashboard homepage. Jump directly into your resource catalog,
            manage subscription plans, and complete payments from one place.
        </p>
        <a href="library.php" class="btn btn-light btn-lg mt-3">Open Resource Catalog</a>
        <a href="pricing.php" class="btn btn-light btn-lg mt-3 ms-2">View Plans</a>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Quick Access</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card feature-card p-4 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-collection"></i></div>
                    <h4>Resource Catalog</h4>
                    <p>Browse categorized worksheets, lessons, and digital classroom files.</p>
                    <a href="library.php" class="btn btn-primary mt-auto">Go to Catalog</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-stars"></i></div>
                    <h4>Subscription Plans</h4>
                    <p>Compare plans and choose the best package for your teaching needs.</p>
                    <a href="pricing.php" class="btn btn-primary mt-auto">View Plans</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card p-4 h-100">
                    <div class="feature-icon mb-3"><i class="bi bi-credit-card-2-front"></i></div>
                    <h4>Payments</h4>
                    <p>Complete secure payments and manage your active subscription status.</p>
                    <a href="payment.php" class="btn btn-primary mt-auto">Go to Payments</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>876JA Digital Resources</h5>
                <p>Online notes, tutorials, and teaching resources for modern classrooms.</p>
            </div>
            <div class="col-md-4">
                <h5>Member Links</h5>
                <p><a href="dashboard.php">Dashboard</a></p>
                <p><a href="library.php">Resource Catalog</a></p>
                <p><a href="pricing.php">Subscription Plans</a></p>
            </div>
            <div class="col-md-4">
                <h5>Support</h5>
                <p><a href="mailto:876JAdigitalresources@gmail.com">Contact Support</a></p>
                <p><a href="faq.php">FAQ</a></p>
                <p><a href="logout.php">Log out</a></p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
