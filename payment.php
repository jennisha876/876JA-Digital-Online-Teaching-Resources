<?php
/*
Payments - 876JA Digital Online Teaching Resources
Authenticated member page for completing subscription payments.
*/

// Protect this page for authenticated users.
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = '876JA Digital Online Teaching Resources | Payments';
$activePage = 'payment';
$selectedPlan = strtolower(trim((string) ($_GET['plan'] ?? '')));

// Sanitize incoming plan values so only supported plans are shown.
$allowedPlans = [
    'basic' => 'Basic',
    'pro' => 'Pro',
    'school' => 'School License',
];
if (!isset($allowedPlans[$selectedPlan])) {
    $selectedPlan = 'basic';
}

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

<section class="py-5">
    <div class="container">
        <h1 class="section-title text-center">Payments</h1>
        <p class="text-center mb-4">Complete your payment to activate or renew your subscription.</p>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card checkout-card p-4">
                    <h5 class="mb-3">Selected Plan: <?php echo htmlspecialchars($allowedPlans[$selectedPlan], ENT_QUOTES, 'UTF-8'); ?></h5>
                    <form action="#" method="post" novalidate>
                        <!-- This form is a UI placeholder for payment gateway integration. -->
                        <div class="mb-3">
                            <label for="card_name" class="form-label">Name on Card</label>
                            <input type="text" id="card_name" class="form-control" placeholder="Enter cardholder name">
                        </div>
                        <div class="mb-3">
                            <label for="card_number" class="form-label">Card Number</label>
                            <input type="text" id="card_number" class="form-control" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="expiry" class="form-label">Expiry Date</label>
                                <input type="text" id="expiry" class="form-control" placeholder="MM/YY">
                            </div>
                            <div class="col-md-6">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" class="form-control" placeholder="123">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary w-100">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Member Links</h5><p><a href="dashboard.php">Dashboard</a></p><p><a href="library.php">Resource Catalog</a></p><p><a href="pricing.php">Subscription Plans</a></p></div>
            <div class="col-md-4"><h5>Support</h5><p><a href="mailto:876JAdigitalresources@gmail.com">Contact Support</a></p><p><a href="faq.php">FAQ</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
