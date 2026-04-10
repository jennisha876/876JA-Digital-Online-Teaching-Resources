<?php
/*
SMTP configuration for password reset emails.

Design notes:
1) This file keeps safe defaults only.
2) Real credentials should be stored in mail-config.local.php (gitignored).
3) For Gmail, use an App Password (not your normal Gmail password).
*/

// Safe defaults for local development.
$config = [
    // Enable SMTP sending only after credentials are filled in.
    'enabled' => false,

    // SMTP server details.
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'tls', // Use 'tls' for port 587 or 'ssl' for port 465.

    // SMTP authentication credentials.
    'username' => 'your_email@gmail.com',
    'password' => 'your_app_password',

    // From identity shown to users.
    'from_email' => 'your_email@gmail.com',
    'from_name' => '876JA Digital Resources',
];

// Optional private override file for production SMTP credentials.
$localOverrideFile = __DIR__ . '/mail-config.local.php';
if (is_file($localOverrideFile)) {
    $overrideConfig = require $localOverrideFile;

    if (is_array($overrideConfig)) {
        $config = array_merge($config, $overrideConfig);
    }
}

return $config;
