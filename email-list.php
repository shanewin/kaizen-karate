<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start([
    'cookie_secure'   => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

// Force no caching
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Type: application/json');

// Initialize CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        die(json_encode(['error' => 'Invalid CSRF token']));
    }
}

// File Paths
$dataDir = __DIR__ . '/data/';
$subscriberFile = $dataDir . 'subscribers.txt';

// Create data directory if missing
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0750, true);
}

try {
    // Validate email
    if (!isset($_POST['email'])) {
        http_response_code(400);
        die(json_encode(['error' => 'Email is required']));
    }

    $email = strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    if (!$email) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid email address']));
    }

    // Save submission
    $entry = sprintf(
        "%s|%s|%s%s",
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'],
        $email,
        PHP_EOL
    );

    file_put_contents($subscriberFile, $entry, FILE_APPEND | LOCK_EX);

    // Send email
    $to = 'thegarrison@doorway.nyc';
    $subject = 'New Email List Signup';
    $headers = [
        'From: info@thegarrison.nyc',
        'Reply-To: ' . $email,
        'Content-Type: text/plain; charset=UTF-8',
        'X-Mailer: PHP/' . phpversion()
    ];

    $body = "New email list signup:\n\nEmail: $email\nIP: {$_SERVER['REMOTE_ADDR']}\nTime: " . date('Y-m-d H:i:s');

    if (mail($to, $subject, $body, implode("\r\n", $headers))) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to send email');
    }

} catch (Exception $e) {
    error_log('Email List Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred. Please try again.']);
}