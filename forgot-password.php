<?php
/*
Forgot Password - 876JA Digital Online Teaching Resources
This page accepts an email address and creates a secure one-time reset link.
*/

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// Load Composer autoloader for PHPMailer.
require_once __DIR__ . '/vendor/autoload.php';

// Load SMTP settings from project configuration file.
$mailConfig = require __DIR__ . '/mail-config.php';

// Load shared database configuration.
$dbConfig = require __DIR__ . '/db-config.php';

// Session is available for future flow extensions and flash messaging.
session_start();

// Form state and messaging.
$email = '';
$emailErr = '';
$formErr = '';
$infoMsg = '';
$debugResetLink = '';

// Escape helper for safe HTML output.
function esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Build base URL dynamically so reset links work in local and hosted environments.
function appBaseUrl()
{
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $isHttps ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // This project is currently served from the web root, so base path is '/'.
    return $scheme . '://' . $host;
}

// Send password reset email through authenticated SMTP.
function sendResetEmail($toEmail, $toName, $resetLink, $mailConfig, &$mailError)
{
    $mailError = '';

    // Guard clause if SMTP config is intentionally disabled.
    if (empty($mailConfig['enabled'])) {
        $mailError = 'SMTP is currently disabled in mail-config.php.';
        return false;
    }

    try {
        $mailer = new PHPMailer(true);

        // Configure SMTP transport settings.
        $mailer->isSMTP();
        $mailer->Host = (string) ($mailConfig['host'] ?? '');
        $mailer->SMTPAuth = true;
        $mailer->Username = (string) ($mailConfig['username'] ?? '');
        $mailer->Password = (string) ($mailConfig['password'] ?? '');
        $mailer->Port = (int) ($mailConfig['port'] ?? 587);
        $mailer->CharSet = 'UTF-8';

        // Map encryption text to PHPMailer constants.
        $encryption = strtolower((string) ($mailConfig['encryption'] ?? 'tls'));
        if ($encryption === 'ssl') {
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }

        // Define sender and recipient.
        $fromEmail = (string) ($mailConfig['from_email'] ?? '');
        $fromName = (string) ($mailConfig['from_name'] ?? '876JA Digital Resources');
        $mailer->setFrom($fromEmail, $fromName);
        $mailer->addAddress($toEmail, $toName);

        // Build plain-text and HTML email bodies.
        $mailer->isHTML(true);
        $mailer->Subject = '876JA Password Reset Request';
        $mailer->Body =
            '<p>Hello ' . esc($toName) . ',</p>' .
            '<p>We received a request to reset your password.</p>' .
            '<p><a href="' . esc($resetLink) . '">Click here to reset your password</a></p>' .
            '<p>This link will expire in 30 minutes.</p>' .
            '<p>If you did not request this, you can ignore this email.</p>';
        $mailer->AltBody =
            'Hello ' . $toName . "\n\n" .
            'We received a request to reset your password.' . "\n" .
            'Use this link (valid for 30 minutes): ' . $resetLink . "\n\n" .
            'If you did not request this, please ignore this email.';

        $mailer->send();
        return true;
    } catch (Exception $ex) {
        $mailError = $ex->getMessage();
        return false;
    }
}

// Handle request form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and normalize user email.
    $email = trim($_POST['email'] ?? '');

    // Validate email before database work.
    if ($email === '') {
        $emailErr = '*Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = '*Please enter a valid email address';
    }

    // Continue only when validation passed.
    if ($emailErr === '') {
        // Open database connection using shared config values.
        $conn = mysqli_connect(
            (string) ($dbConfig['host'] ?? 'localhost'),
            (string) ($dbConfig['username'] ?? ''),
            (string) ($dbConfig['password'] ?? ''),
            (string) ($dbConfig['database'] ?? '')
        );

        if (!$conn) {
            $formErr = 'Database connection failed: ' . mysqli_connect_error();
        } else {
            // Find user by email. This is the only identifier used in reset requests.
            $findUserSql = 'SELECT id, username, email FROM users WHERE email = ? LIMIT 1';
            $findUserStmt = mysqli_prepare($conn, $findUserSql);

            if (!$findUserStmt) {
                $formErr = 'Unable to prepare reset lookup: ' . mysqli_error($conn);
            } else {
                mysqli_stmt_bind_param($findUserStmt, 's', $email);
                mysqli_stmt_execute($findUserStmt);
                $findResult = mysqli_stmt_get_result($findUserStmt);
                $user = $findResult ? mysqli_fetch_assoc($findResult) : null;
                mysqli_stmt_close($findUserStmt);

                // Create and save a token only when an account exists for the email.
                if ($user) {
                    $userId = (int) $user['id'];

                    // Invalidate existing unused tokens for this user.
                    $expireOldSql = 'UPDATE password_resets SET used_at = NOW() WHERE user_id = ? AND used_at IS NULL';
                    $expireOldStmt = mysqli_prepare($conn, $expireOldSql);
                    if ($expireOldStmt) {
                        mysqli_stmt_bind_param($expireOldStmt, 'i', $userId);
                        mysqli_stmt_execute($expireOldStmt);
                        mysqli_stmt_close($expireOldStmt);
                    }

                    // Generate cryptographically secure token and store only its hash.
                    $rawToken = bin2hex(random_bytes(32));
                    $tokenHash = password_hash($rawToken, PASSWORD_DEFAULT);

                    $insertTokenSql = 'INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 MINUTE))';
                    $insertTokenStmt = mysqli_prepare($conn, $insertTokenSql);

                    if (!$insertTokenStmt) {
                        $formErr = 'Unable to prepare reset token insert: ' . mysqli_error($conn);
                    } else {
                        mysqli_stmt_bind_param($insertTokenStmt, 'is', $userId, $tokenHash);

                        if (!mysqli_stmt_execute($insertTokenStmt)) {
                            $formErr = 'Unable to create reset token: ' . mysqli_stmt_error($insertTokenStmt);
                        }

                        mysqli_stmt_close($insertTokenStmt);
                    }

                    // Send reset email when token insert succeeded.
                    if ($formErr === '') {
                        $resetLink = appBaseUrl() . '/reset-password.php?token=' . urlencode($rawToken);

                        // Use SMTP email delivery via PHPMailer.
                        $mailError = '';
                        $mailSent = sendResetEmail($email, $user['username'], $resetLink, $mailConfig, $mailError);

                        // Local fallback: show reset link when SMTP is disabled in config.
                        $isLocalHost = in_array(($_SERVER['HTTP_HOST'] ?? ''), ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000'], true);
                        if (!$mailSent && $isLocalHost && empty($mailConfig['enabled'])) {
                            $debugResetLink = $resetLink;
                        }

                        // If SMTP is enabled but sending failed, show a real error for admin fix.
                        if (!$mailSent && !empty($mailConfig['enabled'])) {
                            $formErr = 'Unable to send reset email: ' . $mailError;
                        }
                    }
                }

                // Always return the same message to prevent email enumeration.
                if ($formErr === '') {
                    $infoMsg = 'If an account with that email exists, a reset link has been sent.';
                    $email = '';
                }
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
    <title>876JA Digital Online Teaching Resources | Forgot Password</title>
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
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="library.php">Library</a></li>
                <li class="nav-item"><a class="nav-login-btn active" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <section class="form-section">
                <h1 class="h3 mb-3">Forgot Password</h1>
                <p class="text-muted mb-4">Enter your account email and we will send a reset link.</p>

                <?php if ($formErr !== ''): ?>
                    <!-- Form-level database error block. -->
                    <div class="alert alert-danger" role="alert"><?php echo esc($formErr); ?></div>
                <?php endif; ?>

                <?php if ($infoMsg !== ''): ?>
                    <!-- Generic success response for security. -->
                    <div class="alert alert-success" role="alert"><?php echo esc($infoMsg); ?></div>
                <?php endif; ?>

                <?php if ($debugResetLink !== ''): ?>
                    <!-- Local testing helper shown when SMTP is disabled on localhost. -->
                    <div class="alert alert-warning" role="alert">
                        Local test reset link: <a href="<?php echo esc($debugResetLink); ?>"><?php echo esc($debugResetLink); ?></a>
                    </div>
                <?php endif; ?>

                <form method="post" action="forgot-password.php" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo esc($email); ?>" autocomplete="email">
                        <?php if ($emailErr !== ''): ?>
                            <!-- Field-level email validation feedback. -->
                            <p class="text-danger small mt-2 mb-0"><?php echo esc($emailErr); ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>

                <p class="small mt-4 mb-0"><a href="login.php">Back to login</a></p>
            </section>
        </div>
    </div>
</main>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
