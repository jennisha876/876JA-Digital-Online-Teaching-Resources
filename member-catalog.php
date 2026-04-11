<?php
/*
Member Resource Catalog - 876JA Digital Online Teaching Resources
This page is the private resource catalog for logged-in users.
*/

// Require login so this catalog remains separate from the public library page.
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = '876JA Digital Online Teaching Resources | Member Resource Catalog';
$activePage = 'member-catalog';

// Helper to set active navbar class.
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
                <li class="nav-item"><a class="nav-link<?php echo navActive('member-catalog', $activePage); ?>" href="member-catalog.php">Resource Catalog</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('payment', $activePage); ?>" href="payment.php">Payments</a></li>
                <li class="nav-item"><a class="nav-login-btn" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <h1 class="section-title text-center">Your Resource Catalog</h1>
        <p class="text-center mb-4">This private catalog shows your member-focused materials and progress items.</p>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card dashboard-panel p-4 h-100">
                    <h4 class="mb-3">Continue Where You Left Off</h4>
                    <div class="dashboard-activity-item d-flex justify-content-between align-items-center mb-3">
                        <span>Mathematics - Fractions Mastery Pack</span>
                        <span class="badge badge-soft">72% Complete</span>
                    </div>
                    <div class="dashboard-activity-item d-flex justify-content-between align-items-center mb-3">
                        <span>Science - Energy and Forces Worksheet Set</span>
                        <span class="badge badge-soft">48% Complete</span>
                    </div>
                    <div class="dashboard-activity-item d-flex justify-content-between align-items-center">
                        <span>Language Arts - Persuasive Writing Toolkit</span>
                        <span class="badge badge-soft">Started</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card dashboard-panel p-4 h-100">
                    <h4 class="mb-3">Recommended For You</h4>
                    <p class="mb-2">- Social Studies: Caribbean History Activity Pack</p>
                    <p class="mb-2">- IT: Spreadsheet Skills Challenge</p>
                    <p class="mb-3">- Business: Intro to Budget Planning</p>
                    <a href="payment.php" class="btn btn-outline-primary w-100">Manage Access</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Member Links</h5><p><a href="dashboard.php">Dashboard</a></p><p><a href="member-catalog.php">Resource Catalog</a></p><p><a href="payment.php">Payments</a></p></div>
            <div class="col-md-4"><h5>Support</h5><p><a href="contact.php">Contact Support</a></p><p><a href="faq.php">FAQ</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
