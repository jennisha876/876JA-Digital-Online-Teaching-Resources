<?php
/*
Download Handler - 876JA Digital Online Teaching Resources
Serves resource files only to logged-in users.
*/

session_start();

// Redirect to login if not logged in.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Validate resource ID.
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    exit('Invalid request.');
}

// Load database config.
$dbConfig = require __DIR__ . '/database/db-config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8mb4',
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed.');
}

// Fetch the resource record.
$stmt = $pdo->prepare('SELECT title, file_path FROM resources WHERE id = ?');
$stmt->execute([$id]);
$resource = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resource) {
    http_response_code(404);
    exit('Resource not found.');
}

// Build absolute file path and verify it exists inside the uploads folder.
$uploadsBase = realpath(__DIR__ . '/uploads/resources');
$filePath    = realpath(__DIR__ . '/' . $resource['file_path']);

// Security check: make sure the file is inside the uploads folder (no path traversal).
if (!$filePath || strpos($filePath, $uploadsBase) !== 0 || !is_file($filePath)) {
    http_response_code(404);
    exit('File not available.');
}

// Determine MIME type.
$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($filePath);

// Sanitise filename for download.
$filename = basename($filePath);

// Send file to browser as a download.
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-cache, must-revalidate');
readfile($filePath);
exit;