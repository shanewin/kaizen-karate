<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Type: application/json');

// Generate CSRF if missing
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method Not Allowed']);
  exit;
}

// Validate CSRF
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
  http_response_code(403);
  echo json_encode(['error' => 'Invalid CSRF token']);
  exit;
}

// Rate limiting
$dataDir = __DIR__ . '/data/';
$rateLimitFile = $dataDir . 'contact_rate_limits.txt';
$submissionFile = $dataDir . 'contact_submissions.txt';
$ip = $_SERVER['REMOTE_ADDR'];
$currentTime = time();
$rateLimitDuration = 300;

if (!is_dir($dataDir)) {
  mkdir($dataDir, 0750, true);
}

if (!file_exists($rateLimitFile)) {
  file_put_contents($rateLimitFile, '{}');
}

// $rateLimits = json_decode(file_get_contents($rateLimitFile), true) ?: [];

// if (isset($rateLimits[$ip]) && ($currentTime - $rateLimits[$ip] < $rateLimitDuration)) {
//   http_response_code(429);
//   echo json_encode(['error' => 'Please wait before submitting again.']);
//   exit;
// }

// Sanitize inputs
function clean($field) {
  return htmlspecialchars(trim($_POST[$field] ?? ''), ENT_QUOTES);
}

$firstName = clean('firstName');
$lastName = clean('lastName');
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$phone = clean('phone');
$hearAboutUs = clean('hearAboutUs');
$program = clean('program');
$message = clean('message');

if (!$firstName || !$lastName || !$email) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing required fields.']);
  exit;
}

// Log to file
$rateLimits[$ip] = $currentTime;
file_put_contents($rateLimitFile, json_encode($rateLimits));

$logEntry = implode('|', [
  date('Y-m-d H:i:s'),
  $ip,
  $firstName,
  $lastName,
  $email,
  $phone,
  $program,
  $hearAboutUs,
  $message
]) . PHP_EOL;

file_put_contents($submissionFile, $logEntry, FILE_APPEND);

// ✅ Send email using native PHP mail()
$to = 'coach.v@kaizenkarateusa.com';
$subject = 'New Contact Form Submission - Kaizen Karate';
$headers = "From: coach.v@kaizenkarateusa.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$body = <<<EOD
New Contact Form Submission from Kaizen Karate Website:

Name: $firstName $lastName
Email: $email
Phone: $phone
Program Interest: $program
How Did You Hear About Us: $hearAboutUs

Message:
$message

IP: $ip
Submitted At: ${currentTime}
EOD;

if (mail($to, $subject, $body, $headers)) {
  http_response_code(200);
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to send email.']);
}
