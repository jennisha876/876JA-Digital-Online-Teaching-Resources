<?php
/*
Contact Page - 876JA Digital Online Teaching Resources
This page gives users a visible Contact Us page and a basic message form.
*/

// Start session so the page can adapt the right navbar action (Login or Dashboard).
session_start();

$pageTitle = '876JA Digital Online Teaching Resources | Contact Us';
$activePage = 'contact';
$isLoggedIn = isset($_SESSION['user_id']);

// Form values and messages.
$name = '';
$email = '';
$message = '';
$nameErr = '';
$emailErr = '';
$messageErr = '';
$successMsg = '';

// Small helper for safe output in HTML context.
function esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Helper for active navbar classes.
function navActive($page, $activePage)
{
    return $page === $activePage ? ' active' : '';
}

// Handle form submit and show a confirmation message.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate required fields.
    if ($name === '') {
        $nameErr = '*Please enter your name';
    }

    if ($email === '') {
        $emailErr = '*Please enter your email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = '*Please enter a valid email address';
    }

    if ($message === '') {
        $messageErr = '*Please enter your message';
    }

    // Show success state when validation passes.
    if ($nameErr === '' && $emailErr === '' && $messageErr === '') {
        $successMsg = 'Thanks for reaching out. We received your message and will contact you soon.';
        $name = '';
        $email = '';
        $message = '';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc($pageTitle); ?></title>
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
                <li class="nav-item"><a class="nav-link<?php echo navActive('home', $activePage); ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('about', $activePage); ?>" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('contact', $activePage); ?>" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('faq', $activePage); ?>" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('pricing', $activePage); ?>" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link<?php echo navActive('library', $activePage); ?>" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn" href="<?php echo $isLoggedIn ? 'dashboard.php' : 'login.php'; ?>"><?php echo $isLoggedIn ? 'Dashboard' : 'Login'; ?></a></li>
            </ul>
        </div>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-7">
                <div class="form-section">
                    <h1 class="section-title mb-2">Contact Us</h1>
                    <p class="text-muted mb-4">Send us a message and we will get back to you shortly.</p>

                    <?php if ($successMsg !== ''): ?>
                        <div class="alert alert-success" role="alert"><?php echo esc($successMsg); ?></div>
                    <?php endif; ?>

                    <form method="post" action="contact.php" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo esc($name); ?>">
                            <?php if ($nameErr !== ''): ?><p class="text-danger small mt-2 mb-0"><?php echo esc($nameErr); ?></p><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo esc($email); ?>">
                            <?php if ($emailErr !== ''): ?><p class="text-danger small mt-2 mb-0"><?php echo esc($emailErr); ?></p><?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" rows="5" class="form-control"><?php echo esc($message); ?></textarea>
                            <?php if ($messageErr !== ''): ?><p class="text-danger small mt-2 mb-0"><?php echo esc($messageErr); ?></p><?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>

                    <p class="small mt-4 mb-0">You can also email us directly at <a href="mailto:876JAdigitalresources@gmail.com">876JAdigitalresources@gmail.com</a>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4"><h5>876JA Digital Resources</h5><p>Online notes, tutorials, and teaching resources for modern classrooms.</p></div>
            <div class="col-md-4"><h5>Quick Links</h5><p><a href="about.php">About Us</a></p><p><a href="library.php">Library</a></p><p><a href="pricing.php">Subscription Plans</a></p></div>
            <div class="col-md-4"><h5>Support</h5><p><a href="faq.php">FAQ</a></p><p><a href="contact.php">Contact Us</a></p></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
