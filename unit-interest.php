<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Content-Type: application/json');

// Initialize CSRF Token if missing
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method Not Allowed']);
  exit;
}

// Validate CSRF Token
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
  http_response_code(403);
  echo json_encode(['error' => 'Invalid CSRF token']);
  exit;
}

// Rate limiting
$dataDir = __DIR__ . '/data/';
$rateLimitFile = $dataDir . 'unit_rate_limits.txt';
$submissionFile = $dataDir . 'unit_submissions.txt';
$ip = $_SERVER['REMOTE_ADDR'];
$currentTime = time();
$rateLimitDuration = 300;

if (!is_dir($dataDir)) {
  mkdir($dataDir, 0750, true);
}

if (!file_exists($rateLimitFile)) {
  file_put_contents($rateLimitFile, '{}');
}

$rateLimits = json_decode(file_get_contents($rateLimitFile), true) ?: [];

// if (isset($rateLimits[$ip]) && ($currentTime - $rateLimits[$ip] < $rateLimitDuration)) {
//   http_response_code(429);
//   echo json_encode(['error' => 'Please wait before submitting again.']);
//   exit;
// }

// Sanitize Input
function clean($field) {
  return htmlspecialchars(trim($_POST[$field] ?? ''), ENT_QUOTES);
}

$unit = clean('unit');
$firstName = clean('firstName');
$lastName = clean('lastName');
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$phone = clean('phone');
$moveInDate = clean('moveInDate');
$budget = clean('budget');
$hearAboutUs = clean('hearAboutUs');
$message = clean('message');

if (!$firstName || !$lastName || !$email || !$phone) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing required fields.']);
  exit;
}

// Save to file
$rateLimits[$ip] = $currentTime;
file_put_contents($rateLimitFile, json_encode($rateLimits));

$entry = implode('|', [
  date('Y-m-d H:i:s'),
  $ip,
  $unit,
  $firstName,
  $lastName,
  $email,
  $phone,
  $moveInDate,
  $budget,
  $hearAboutUs,
  $message
]) . PHP_EOL;

file_put_contents($submissionFile, $entry, FILE_APPEND);

// ✅ Send email using native PHP mail()
$to = 'thegarrison@doorway.nyc';
$subject = "New Inquiry for Unit: $unit";
$headers = "From: info@thegarrison.nyc\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$body = <<<EOD
New Unit Interest Submission:

Unit: $unit
Name: $firstName $lastName
Email: $email
Phone: $phone
Move-In Date: $moveInDate
Budget: $budget
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
