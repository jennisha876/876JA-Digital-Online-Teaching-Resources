<?php
$pageTitle = '876JA Digital Online Teaching Resources | About Us';
$activePage = 'about';
function navActive($page, $activePage) { return $page === $activePage ? ' active' : ''; }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">876JA Digital Resources</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo navActive('home', $activePage); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about', $activePage); ?>" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Resource Library</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('payment', $activePage); ?>" href="payment.php">Payment</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq', $activePage); ?>" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('registration', $activePage); ?>" href="registration.php">Register</a></li>
                <li class="nav-item"><a class="nav-login-btn<?php echo navActive('login', $activePage); ?>" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<section class="page-banner">
    <div class="container">
        <h1>About Us</h1>
    </div>
</section>

<div class="container">
    <p>
        876JA Digital Online Teaching Resources provides educational notes, tutorials,
        and digital classroom resources for teachers and subscribers.
    </p>
</div>

<footer class="footer-area"><div class="container"><div class="row g-4"><div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div><div class="col-md-4"><h5>Quick Links</h5><p><a href="about.php">About Us</a></p><p><a href="library.php">Resource Library</a></p><p><a href="pricing.php">Subscription Plans</a></p></div><div class="col-md-4"><h5>External Links</h5><p><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></p><p><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></p><p><a href="https://www.paypal.com" target="_blank" rel="noopener">PayPal</a></p></div></div></div></footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>