<?php
/*
Login Form - Jennisha Smith
This form will be used to log in registered users based on credentials stored in the database.
*/

// Start session early so authenticated user state can be stored and read safely.
session_start();

// Load shared database configuration.
$dbConfig = require __DIR__ . '/db-config.php';

// Initialize form values and error messages.
// These defaults prevent undefined variable notices on first page load.
$username = '';
$usernameErr = '';
$passwordErr = '';
$formErr = '';
$resetSuccessMsg = '';

// Show a one-time style message after successful password reset.
if (($_GET['reset'] ?? '') === 'success') {
    $resetSuccessMsg = 'Password updated successfully. Please log in with your new password.';
}

// Handle login submission only for POST requests.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and normalize incoming form values.
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Server-side validation for username.
    if ($username === '') {
        $usernameErr = '*Please enter username';
    }

    // Server-side validation for password.
    if ($password === '') {
        $passwordErr = '*Please enter password';
    }

    // If validation succeeds, validate credentials against database and then redirect.
    if ($usernameErr === '' && $passwordErr === '') {
        // Open database connection and validate login securely.
        $conn = mysqli_connect(
            (string) ($dbConfig['host'] ?? 'localhost'),
            (string) ($dbConfig['username'] ?? ''),
            (string) ($dbConfig['password'] ?? ''),
            (string) ($dbConfig['database'] ?? '')
        );

        if (!$conn) {
            $formErr = 'Database connection failed: ' . mysqli_connect_error();
        } else {
            // Allow login by username or email to improve usability.
            $sql = 'SELECT id, username, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1';
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                $formErr = 'Unable to prepare login query: ' . mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($stmt, 'ss', $username, $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = $result ? mysqli_fetch_assoc($result) : null;

                // Verify entered password against stored hash.
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Store only safe, minimal session information.
                    $_SESSION['user_id'] = (int) $user['id'];
                    $_SESSION['username'] = $user['username'];

                    // Send authenticated users to their member dashboard homepage.
                    header('Location: dashboard.php');
                    exit;
                }

                // Keep response generic to avoid exposing account existence.
                $formErr = 'Invalid username/email or password.';
                mysqli_stmt_close($stmt);
            }

            mysqli_close($conn);
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>876JA Digital Online Teaching Resources | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
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
                <li class="nav-item"><a class="nav-link" href="mailto:876JAdigitalresources@gmail.com">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn active" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login content card -->
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <section class="registration-layout card border-0 shadow-sm">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-6">
                        <div class="registration-media" role="img" aria-label="Students collaborating in a warm classroom setting"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body registration-form-panel p-4 p-md-5">
                            <h1 class="h3 mb-3">Login</h1>
                            <p class="text-muted mb-4">Access your teaching resources account.</p>
                            <?php if ($resetSuccessMsg !== ''): ?>
                                <!-- Post-reset confirmation message. -->
                                <div class="alert alert-success mb-3" role="alert"><?php echo htmlspecialchars($resetSuccessMsg, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                            <?php if ($formErr !== ''): ?>
                                <!-- Form-level login error shown when credentials or database checks fail. -->
                                <div class="alert alert-danger mb-3" role="alert"><?php echo htmlspecialchars($formErr, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>

                            <!-- Login form posts back to this same page for PHP validation -->
                            <form method="post" action="login.php" novalidate>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        class="form-control"
                                        value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"
                                        autocomplete="username"
                                    >
                                    <?php if ($usernameErr !== ''): ?>
                                        <p class="text-danger small mt-2 mb-0"><?php echo htmlspecialchars($usernameErr, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control"
                                        autocomplete="current-password"
                                    >
                                    <span toggle="#password" class="zmdi-eye field-icon toggle-password"></span>
                                    <?php if ($passwordErr !== ''): ?>
                                        <p class="text-danger small mt-2 mb-0"><?php echo htmlspecialchars($passwordErr, ENT_QUOTES, 'UTF-8'); ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Forgot password entry point for password reset flow. -->
                                <p class="small mb-4"><a href="forgot-password.php">Forgot password?</a></p>

                                <button type="submit" name="submit" class="btn btn-primary w-100">Login</button>
                            </form>

                            <p class="mt-4 mb-0 small">Don't have an account? <a href="registration.php">Sign up now</a>.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- Shared footer links and brand text -->
<footer class="footer-area">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5>876JA Digital Resources</h5>
                <p>Online notes, tutorials, and teaching resources for modern classrooms.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <p><a href="about.php">About Us</a></p>
                <p><a href="library.php">Resource Library</a></p>
                <p><a href="pricing.php">Subscription Plans</a></p>
            </div>
            <div class="col-md-4">
                <h5>External Links</h5>
                <p><a href="https://www.facebook.com" target="_blank" rel="noopener">Facebook</a></p>
                <p><a href="https://www.youtube.com" target="_blank" rel="noopener">YouTube</a></p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS bundle for responsive UI behavior -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
