<?php
/*
Registration Form - Jennisha Smith
This allows new users to register for an online account.
Form information is validated in PHP and stored in a database.
*/

// Session is started for future account flows (for example, post-register login state).
session_start();

// Load shared database configuration.
$dbConfig = require __DIR__ . '/db-config.php';

// Input value holders.
// These keep submitted data available when validation fails.
$firstName = '';
$lastName = '';
$username = '';
$email = '';
$password = '';
$confirmPassword = '';

// Error and status messages.
// Each field has its own message to support targeted feedback.
$firstNameErr = '';
$lastNameErr = '';
$usernameErr = '';
$emailErr = '';
$passwordErr = '';
$confirmPasswordErr = '';
$formErr = '';
$successMsg = '';

// Process only when the registration form is submitted.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and normalize submitted values.
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate first name.
    if ($firstName === '') {
        $firstNameErr = '*Please enter first name';
    }
    
    // Validate last name.
    if ($lastName === '') {
        $lastNameErr = '*Please enter last name';
    }

    // Validate username.
    if ($username === '') {
        $usernameErr = '*Please enter username';
    }

    // Validate email presence and format.
    if ($email === '') {
        $emailErr = '*Please enter email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = '*Please enter a valid email address';
    }

    // Validate password minimum rule.
    if ($password === '') {
        $passwordErr = '*Please enter password';
    } elseif (strlen($password) < 8) {
        $passwordErr = '*Password must be at least 8 characters';
    }

    // Validate confirmation and ensure both password fields match.
    if ($confirmPassword === '') {
        $confirmPasswordErr = '*Please confirm password';
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordErr = '*Passwords do not match';
    }

    // Continue to database work only when all validation checks pass.
    if (
        $firstNameErr === '' &&
        $lastNameErr === '' &&
        $usernameErr === '' &&
        $emailErr === '' &&
        $passwordErr === '' &&
        $confirmPasswordErr === ''
    ) {
        // Open database connection.
        $conn = mysqli_connect(
            (string) ($dbConfig['host'] ?? 'localhost'),
            (string) ($dbConfig['username'] ?? ''),
            (string) ($dbConfig['password'] ?? ''),
            (string) ($dbConfig['database'] ?? '')
        );

        if (!$conn) {
            $formErr = 'Database connection failed: ' . mysqli_connect_error();
        } else {
            // Check for existing account by username or email before insert.
            $checkStmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');

            if (!$checkStmt) {
                $formErr = 'Unable to validate existing user: ' . mysqli_error($conn);
            } else {
                // Bind parameters and execute duplicate lookup query.
                mysqli_stmt_bind_param($checkStmt, 'ss', $username, $email);
                mysqli_stmt_execute($checkStmt);
                mysqli_stmt_store_result($checkStmt);

                // Any existing row means user details already exist.
                if (mysqli_stmt_num_rows($checkStmt) > 0) {
                    $formErr = 'Username or email already exists. Please use another one.';
                }

                mysqli_stmt_close($checkStmt);
            }

            // Insert the new user only when no earlier database error occurred.
            if ($formErr === '') {
                $insertSql = 'INSERT INTO users (first_name, last_name, username, email, password_hash) VALUES (?, ?, ?, ?, ?)';
                $insertStmt = mysqli_prepare($conn, $insertSql);

                if (!$insertStmt) {
                    $formErr = 'Unable to prepare registration insert: ' . mysqli_error($conn);
                } else {
                    // Hash password securely before storing it.
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($insertStmt, 'sssss', $firstName, $lastName, $username, $email, $passwordHash);

                    // Execute insert and set final UI message.
                    if (mysqli_stmt_execute($insertStmt)) {
                        $successMsg = 'Account created successfully.';
                        $firstName = '';
                        $lastName = '';
                        $username = '';
                        $email = '';
                    } else {
                        $formErr = 'Registration failed: ' . mysqli_stmt_error($insertStmt);
                    }

                    mysqli_stmt_close($insertStmt);
                }
            }

            // Always close connection after database processing.
            mysqli_close($conn);
        }
    }
}

// Escape helper for safe output in HTML context.
function esc($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// Build an error paragraph when a field contains an error message.
function errBlock($value)
{
    if ($value === '') {
        return '';
    }

    return '<p class="text-danger small mt-2 mb-0">' . esc($value) . '</p>';
}

// Build alert blocks for form-level success and failure notifications.
function alertBlock($value, $type)
{
    if ($value === '') {
        return '';
    }

    $safeType = $type === 'success' ? 'success' : 'danger';
    return '<div class="alert alert-' . $safeType . ' mb-3" role="alert">' . esc($value) . '</div>';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>876JA Digital Online Teaching Resources | Register</title>
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
                <li class="nav-item"><a class="nav-login-btn" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Registration content -->
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
                            <h1 class="h3 mb-3">Create Account</h1>
                            <p class="text-muted mb-4">Register for an online account to access teaching resources.</p>
                            <?php echo alertBlock($formErr, 'danger'); ?>
                            <?php echo alertBlock($successMsg, 'success'); ?>

                            <!-- Form posts to this page and is validated using PHP above -->
                            <form method="post" action="registration.php" novalidate>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo esc($firstName); ?>" autocomplete="given-name">
                                        <?php echo errBlock($firstNameErr); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo esc($lastName); ?>" autocomplete="family-name">
                                        <?php echo errBlock($lastNameErr); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" value="<?php echo esc($username); ?>" autocomplete="username">
                                        <?php echo errBlock($usernameErr); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" value="<?php echo esc($email); ?>" autocomplete="email">
                                        <?php echo errBlock($emailErr); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                                        <span toggle="#password" class="zmdi-eye field-icon toggle-password"></span>
                                        <?php echo errBlock($passwordErr); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" autocomplete="new-password">
                                        <span toggle="#confirm_password" class="zmdi-eye field-icon toggle-password"></span>
                                        <?php echo errBlock($confirmPasswordErr); ?>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 mt-4">Create Account</button>
                            </form>

                            <p class="mt-4 mb-0 small">Already have an account? <a href="login.php">Login now</a>.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- Shared footer content -->
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

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
