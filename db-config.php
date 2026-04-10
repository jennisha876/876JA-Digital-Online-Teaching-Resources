<?php
/*
Database configuration used by authentication and password reset flows.

Design notes:
1) Safe defaults are provided for local XAMPP development.
2) Production credentials should live in db-config.local.php, which is gitignored.
3) This file never stores real production secrets in source control.
*/

// Local development defaults.
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'teaching',
];

// Optional private override file for production credentials.
$localOverrideFile = __DIR__ . '/db-config.local.php';
if (is_file($localOverrideFile)) {
    $overrideConfig = require $localOverrideFile;

    if (is_array($overrideConfig)) {
        $config = array_merge($config, $overrideConfig);
    }
}

return $config;
