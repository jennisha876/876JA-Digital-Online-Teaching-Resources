<?php
/*
SMTP configuration for password reset emails.

How to use in local XAMPP:
1) Copy this file as-is and replace placeholder values with your SMTP credentials.
2) For Gmail, use an App Password (not your normal Gmail password).
3) Keep this file private and do not commit real passwords to public repositories.
*/

return [
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
