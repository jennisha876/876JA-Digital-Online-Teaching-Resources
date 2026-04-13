<?php
$pageTitle = '876JA Digital Resources | Home';
$activePage = 'home';

function navActive($page, $activePage) {
    return $page === $activePage ? ' active' : '';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>876JA Digital Resources | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/css/images/876Logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;800&display=swap" rel="stylesheet">
</head>
<body>

<!-- ==================== NAVBAR ==================== -->
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/876LogoTrans.png" alt="876JA Logo" height="48" class="me-2">
            <span class="fw-bold">876JA</span> Digital Resources
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link<?= navActive('home', $activePage) ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                
                <li class="nav-item ms-3">
                    <a class="nav-login-btn" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ==================== HERO SECTION ==================== -->
<header class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold">Teaching Resources<br>Made Simple for Jamaica</h1>
        <p class="lead mx-auto mt-4" style="max-width: 800px;">
            High-quality digital notes, worksheets, tutorials &amp; classroom materials.<br>
            Built for Jamaican teachers, by Jamaican educators.
        </p>
        <div class="mt-5">
            <a href="library.php" class="btn btn-warning btn-lg px-5 py-3 me-3">Browse Resources</a>
            <a href="registration.php" class="btn btn-outline-light btn-lg px-5 py-3">Create Free Account</a>
        </div>
        <div class="mt-5">
            <small class="eyebrow">ðŸ‡¯ðŸ‡² Trusted by 2,400+ Jamaican Teachers</small>
        </div>
    </div>
</header>

<!-- ==================== WHY CHOOSE US ==================== -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Why Choose 876JA</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <i class="bi bi-lightning-charge-fill fs-1"></i>
                    </div>
                    <h4>Instant Access</h4>
                    <p class="text-light">Download ready-to-use materials anytime, anywhere.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <i class="bi bi-book-half fs-1"></i>
                    </div>
                    <h4>Curriculum Aligned</h4>
                    <p class="text-light">Resources match the Jamaican National Standards.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <i class="bi bi-people-fill fs-1"></i>
                    </div>
                    <h4>Teacher Made</h4>
                    <p class="text-light">Created by experienced Jamaican educators.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== POPULAR CATEGORIES ==================== -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Popular Categories</h2>
        <div class="row g-4">
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Mathematics</h5></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Science</h5></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Language Arts</h5></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Social Studies</h5></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Information Technology</h5></div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="category-card"><h5>Business Studies</h5></div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== SEARCH CTA ==================== -->
<section class="py-5">
    <div class="container">
        <div class="cta-box glass-card p-5 text-center">
            <h2 class="section-title mb-4">Find What You Need</h2>
            <form class="search-box d-flex justify-content-center" action="library.php" method="get">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Search notes, worksheets, tutorials..." style="max-width: 600px;">
                <button type="submit" class="btn btn-warning ms-3 px-5">Search</button>
            </form>
        </div>
    </div>
</section>

<!-- ==================== SUBSCRIPTION PLANS ==================== -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Simple Pricing</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="plan-card glass-card p-4 h-100 text-center">
                    <h4>Basic</h4>
                    <p class="plan-price text-warning">$5<span style="font-size:1rem;">/month</span></p>
                    <p class="mb-4">Access to core resources</p>
                    <a href="payment.php?plan=basic" class="btn btn-outline-light w-100">Choose Basic</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan-card glass-card p-4 h-100 text-center border border-warning">
                    <h4 class="text-warning">Pro <span class="badge bg-warning text-dark">Most Popular</span></h4>
                    <p class="plan-price text-warning">$10<span style="font-size:1rem;">/month</span></p>
                    <p class="mb-4">Full access + downloads + updates</p>
                    <a href="payment.php?plan=pro" class="btn btn-warning w-100">Subscribe to Pro</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan-card glass-card p-4 h-100 text-center">
                    <h4>School</h4>
                    <p class="plan-price text-warning">$25<span style="font-size:1rem;">/month</span></p>
                    <p class="mb-4">For entire departments &amp; schools</p>
                    <a href="payment.php?plan=school" class="btn btn-outline-light w-100">School License</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== FOOTER ==================== -->
<footer class="footer py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-5">
                <h5 class="text-warning">876JA Digital Resources</h5>
                <p class="text-light">Premium digital teaching resources for Jamaican educators.</p>
            </div>
            <div class="col-md-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="library.php">Resource Library</a></li>
                    <li><a href="pricing.php">Pricing</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Connect With Us</h6>
                <p class="mb-1">ðŸ“ George's Valley, Manchester, Jamaica</p>
                <p>Email: info@876jadigital.com</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center text-light small">
            &copy; <?= date("Y") ?> 876JA Digital Resources. All Rights Reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
