<?php
/*
Resource Catalog - 876JA Digital Online Teaching Resources
Authenticated member page for browsing learning resources.
*/

// Protect this page for authenticated users.
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$pageTitle = '876JA Digital Online Teaching Resources | Resource Catalog';
$activePage = 'library';

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
        <h1 class="section-title text-center">Resource Catalog</h1>
        <p class="text-center mb-4">Explore resources by subject area and quickly access what you need.</p>
        <div class="row g-4">
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Mathematics</h5><p>Lesson notes, worksheet packs, and exam prep examples.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Science</h5><p>Classroom notes, lab support files, and quick revision sheets.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Language Arts</h5><p>Reading passages, grammar support, and writing exercises.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Social Studies</h5><p>Topic summaries, project prompts, and in-class activities.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Information Technology</h5><p>Digital literacy and coding support materials.</p></div></div></div>
            <div class="col-md-4"><div class="card category-card"><div class="card-body"><h5>Business</h5><p>Business principles, case tasks, and sample assessments.</p></div></div></div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Member Links</h5><p><a href="dashboard.php">Dashboard</a></p><p><a href="pricing.php">Subscription Plans</a></p><p><a href="payment.php">Payments</a></p></div>
            <div class="col-md-4"><h5>Support</h5><p><a href="mailto:876JAdigitalresources@gmail.com">Contact Support</a></p><p><a href="faq.php">FAQ</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
