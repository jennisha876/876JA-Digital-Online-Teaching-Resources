<?php
/*
Subscription Plans - 876JA Digital Online Teaching Resources
Public page for selecting subscription packages.
*/

// Public page: no authentication guard required.

$pageTitle = '876JA Digital Online Teaching Resources | Subscription Plans';
$activePage = 'pricing';

// Helper to set active nav class.
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
    <link rel="icon" type="image/png" href="assets/css/images/876Logo.png">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <h1 class="section-title text-center">Subscription Plans</h1>
        <p class="text-center mb-4">Choose a plan and continue to payment to activate your subscription.</p>
        <div class="row g-4">
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>Basic</h4><p class="plan-price">$5</p><p>Access to standard digital teaching materials.</p><a href="payment.php?plan=basic" class="btn btn-primary mt-auto">Select Basic</a></div></div>
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>Pro</h4><p class="plan-price">$10</p><p>More resources, wider access, and extra downloads.</p><a href="payment.php?plan=pro" class="btn btn-primary mt-auto">Select Pro</a></div></div>
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>School License</h4><p class="plan-price">$25</p><p>Designed for wider institutional access and support.</p><a href="payment.php?plan=school" class="btn btn-primary mt-auto">Select School</a></div></div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Member Links</h5><p><a href="dashboard.php">Dashboard</a></p><p><a href="library.php">Resource Catalog</a></p><p><a href="payment.php">Payments</a></p></div>
            <div class="col-md-4"><h5>Support</h5><p><a href="contact.php">Contact Support</a></p><p><a href="faq.php">FAQ</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
