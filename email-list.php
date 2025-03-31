<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
session_regenerate_id(true);
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Type: application/json');

// Initialize CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
}

// File Paths
$dataDir = __DIR__ . '/data/';
$rateLimitFile = $dataDir . 'rate_limits.txt';
$subscriberFile = $dataDir . 'subscribers.txt';

// Create data directory if missing
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0750, true);
}

// Rate Limiting (1 submission per 5 minutes per IP)
$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? $_SERVER['REMOTE_ADDR'] : 'invalid_ip';
$currentTime = time();
$rateLimitDuration = 300;

try {
    // Initialize rate limit file
    if (!file_exists($rateLimitFile)) {
        file_put_contents($rateLimitFile, '{}');
        chmod($rateLimitFile, 0640);
    }

    $rateLimits = json_decode(file_get_contents($rateLimitFile), true) ?: [];

    // Uncomment this block to re-enable rate limiting
    // if (isset($rateLimits[$ip]) && ($currentTime - $rateLimits[$ip] < $rateLimitDuration)) {
    //     http_response_code(429);
    //     echo json_encode(['error' => 'Please wait before submitting again']);
    //     exit;
    // }

    // Validate input
    if (!isset($_POST['email']) || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }

    $email = strtolower(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    if (!$email) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid email address']);
        exit;
    }

    // Process submission
    $rateLimits[$ip] = $currentTime;
    file_put_contents($rateLimitFile, json_encode($rateLimits));

    $data = sprintf(
        "%s|%s|%s%s",
        date('Y-m-d H:i:s'),
        $ip,
        $email,
        PHP_EOL
    );

    file_put_contents($subscriberFile, $data, FILE_APPEND);
    chmod($subscriberFile, 0640);

    // ✅ Send email using native PHP mail()
    $to = 'thegarrison@doorway.nyc';
    $subject = 'New Email List Signup';
    $headers = "From: info@thegarrison.nyc\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body = <<<EOD
A new user has subscribed to the email list:

Email: $email
IP Address: $ip
Submitted At: ${currentTime}
EOD;

    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to send email.']);
    }

} catch (Exception $e) {
    error_log('Subscription Error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Service unavailable']);
}
