<?php
$pageTitle = '876JA Digital Online Teaching Resources | Home';
$activePage = 'home';
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?php echo navActive('home', $activePage); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about', $activePage); ?>" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Resource Library</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('payment', $activePage); ?>" href="payment.php">Payment</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq', $activePage); ?>" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('registration', $activePage); ?>" href="registration.php">Register</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('login', $activePage); ?>" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section">
    <div class="container text-center">
        <h1>Teaching Resources Made Simple</h1>
        <p class="mx-auto mt-3">
            876JA Digital Online Teaching Resources gives teachers and subscribers fast access to notes,
            tutorials, worksheets, and classroom support materials across multiple subject areas.
        </p>
        <a href="library.php" class="btn btn-light btn-lg mt-3">Browse Resources</a>
        <a href="registration.php" class="btn btn-outline-light btn-lg mt-3 ms-2">Create Account</a>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Why Choose Us</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon mb-3"><i class="bi bi-phone"></i></div><h4>Easy Access</h4><p>Subscribers can access digital teaching materials anytime from one platform.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon mb-3"><i class="bi bi-grid-3x3-gap"></i></div><h4>Multiple Categories</h4><p>Resources are arranged by subject so users can find materials quickly.</p></div></div>
            <div class="col-md-4"><div class="card feature-card p-4"><div class="feature-icon mb-3"><i class="bi bi-credit-card"></i></div><h4>Flexible Plans</h4><p>Users can choose a subscription package that matches their needs.</p></div></div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Resource Categories</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Mathematics</h5><p>Lessons, worksheets, examples, and tutorial materials.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Science</h5><p>Digital notes and learning support for general science topics.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Language Arts</h5><p>Reading, writing, and grammar resources for classroom use.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Social Studies</h5><p>Notes, activities, and teaching support materials.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Information Technology</h5><p>Technical resources, tutorials, and classroom content.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Business</h5><p>Teaching resources for business subjects and support lessons.</p></div></div></div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="cta-box text-center">
            <h2 class="section-title">Search the Resource Library</h2>
            <form class="search-box d-flex" action="library.php" method="get">
                <input type="text" name="search" class="form-control me-2" placeholder="Search resources">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center">Subscription Plans</h2>
        <div class="row g-4">
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>Basic</h4><p class="plan-price">$5</p><p>Access to standard digital teaching materials.</p><a href="payment.php?plan=basic" class="btn btn-primary mt-auto">Subscribe</a></div></div>
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>Pro</h4><p class="plan-price">$10</p><p>More resources, wider access, and extra downloads.</p><a href="payment.php?plan=pro" class="btn btn-primary mt-auto">Subscribe</a></div></div>
            <div class="col-md-4"><div class="card plan-card p-4 text-center"><h4>School License</h4><p class="plan-price">$25</p><p>Designed for wider institutional access and support.</p><a href="payment.php?plan=school" class="btn btn-primary mt-auto">Subscribe</a></div></div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Quick Links</h5><p><a href="about.php">About Us</a></p><p><a href="library.php">Resource Library</a></p><p><a href="pricing.php">Subscription Plans</a></p><p><a href="faq.php">FAQ</a></p></div>
            <div class="col-md-4"><h5>External Links</h5><p><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></p><p><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></p><p><a href="https://www.paypal.com" target="_blank" rel="noopener">PayPal</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
        </div>
