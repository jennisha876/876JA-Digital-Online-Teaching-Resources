<?php
/*
Reset Password - 876JA Digital Online Teaching Resources
This page validates a reset token and updates the user's password hash in the database.
*/

// Session is available for future flow extensions and flash messaging.
session_start();

// Load shared database configuration.
$dbConfig = require __DIR__ . '/database/db-config.php';

// Form and UI state variables.
$token = trim($_GET['token'] ?? ($_POST['token'] ?? ''));
$password = '';
$confirmPassword = '';
$passwordErr = '';
$confirmPasswordErr = '';
$formErr = '';
$successMsg = '';

// Escape helper for safe HTML output.
function esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Basic token format validation to reject malformed tokens early.
if ($token !== '' && (!ctype_xdigit($token) || strlen($token) !== 64)) {
    $token = '';
    $formErr = 'Invalid reset token.';
}

// Process new password submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $formErr === '') {
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Enforce password requirements.
    if ($password === '') {
        $passwordErr = '*Please enter new password';
    } elseif (strlen($password) < 8) {
        $passwordErr = '*Password must be at least 8 characters';
    }

    // Ensure both password fields match.
    if ($confirmPassword === '') {
        $confirmPasswordErr = '*Please confirm new password';
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = '*Passwords do not match';
    }

    // Continue only if validation checks passed and token exists.
    if ($token === '') {
        $formErr = 'Invalid or missing reset token.';
    } elseif ($passwordErr === '' && $confirmPasswordErr === '') {
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
            // Read all active, non-expired reset records and verify token server-side.
            $findSql = 'SELECT id, user_id, token_hash FROM password_resets WHERE used_at IS NULL AND expires_at > NOW() ORDER BY id DESC';
            $findResult = mysqli_query($conn, $findSql);

            $matchedResetId = 0;
            $matchedUserId = 0;

            if ($findResult) {
                while ($row = mysqli_fetch_assoc($findResult)) {
                    // Compare provided raw token to stored hash.
                    if (password_verify($token, $row['token_hash'])) {
                        $matchedResetId = (int) $row['id'];
                        $matchedUserId = (int) $row['user_id'];
                        break;
                    }
                }

                mysqli_free_result($findResult);
            } else {
                $formErr = 'Unable to verify reset token: ' . mysqli_error($conn);
            }

            // Update password and consume token in one transaction.
            if ($formErr === '') {
                if ($matchedResetId === 0 || $matchedUserId === 0) {
                    $formErr = 'This reset link is invalid or has expired.';
                } else {
                    $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_begin_transaction($conn);

                    $updateUserSql = 'UPDATE users SET password_hash = ? WHERE id = ?';
                    $updateUserStmt = mysqli_prepare($conn, $updateUserSql);

                    if (!$updateUserStmt) {
                        $formErr = 'Unable to prepare password update: ' . mysqli_error($conn);
                    } else {
                        mysqli_stmt_bind_param($updateUserStmt, 'si', $newPasswordHash, $matchedUserId);

                        if (!mysqli_stmt_execute($updateUserStmt)) {
                            $formErr = 'Unable to update password: ' . mysqli_stmt_error($updateUserStmt);
                        }

                        mysqli_stmt_close($updateUserStmt);
                    }

                    // Mark token as used after password update succeeds.
                    if ($formErr === '') {
                        $consumeTokenSql = 'UPDATE password_resets SET used_at = NOW() WHERE id = ?';
                        $consumeTokenStmt = mysqli_prepare($conn, $consumeTokenSql);

                        if (!$consumeTokenStmt) {
                            $formErr = 'Unable to finalize reset token: ' . mysqli_error($conn);
                        } else {
                            mysqli_stmt_bind_param($consumeTokenStmt, 'i', $matchedResetId);

                            if (!mysqli_stmt_execute($consumeTokenStmt)) {
                                $formErr = 'Unable to consume reset token: ' . mysqli_stmt_error($consumeTokenStmt);
                            }

                            mysqli_stmt_close($consumeTokenStmt);
                        }
                    }

                    // Complete or rollback transaction based on final state.
                    if ($formErr === '') {
                        mysqli_commit($conn);
                        $successMsg = 'Your password has been reset successfully. You can now log in.';
                        $password = '';
                        $confirmPassword = '';
                    } else {
                        mysqli_rollback($conn);
                    }
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
    <title>876JA Digital Online Teaching Resources | Reset Password</title>
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
                <h1 class="h3 mb-3">Reset Password</h1>
                <p class="text-muted mb-4">Set a new password for your account.</p>

                <?php if ($formErr !== ''): ?>
                    <!-- Error alert for invalid tokens or database failures. -->
                    <div class="alert alert-danger" role="alert"><?php echo esc($formErr); ?></div>
                <?php endif; ?>

                <?php if ($successMsg !== ''): ?>
                    <!-- Success message shown after password and token updates complete. -->
                    <div class="alert alert-success" role="alert"><?php echo esc($successMsg); ?></div>
                    <p class="small mb-0"><a href="login.php?reset=success">Go to login</a></p>
                <?php elseif ($token === ''): ?>
                    <!-- Missing token fallback guidance. -->
                    <p class="small mb-0">Request a new reset link from <a href="forgot-password.php">Forgot Password</a>.</p>
                <?php else: ?>
                    <form method="post" action="reset-password.php" novalidate>
                        <!-- Keep token in hidden field for POST submission. -->
                        <input type="hidden" name="token" value="<?php echo esc($token); ?>">

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                            <?php if ($passwordErr !== ''): ?>
                                <!-- Field-level password validation message. -->
                                <p class="text-danger small mt-2 mb-0"><?php echo esc($passwordErr); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" autocomplete="new-password">
                            <?php if ($confirmPasswordErr !== ''): ?>
                                <!-- Field-level password confirmation validation message. -->
                                <p class="text-danger small mt-2 mb-0"><?php echo esc($confirmPasswordErr); ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>
                <?php endif; ?>

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
