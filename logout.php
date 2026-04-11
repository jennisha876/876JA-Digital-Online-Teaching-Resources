<?php
/*
Logout endpoint - 876JA Digital Online Teaching Resources
This ends the authenticated session and sends the user to the login page.
*/

session_start();

// Clear all session values.
$_SESSION = [];

// Remove the session cookie if one exists.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destroy session data and redirect user.
session_destroy();
header('Location: login.php');
exit;
