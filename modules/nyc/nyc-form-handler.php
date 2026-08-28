<?php
// Errors are logged, never printed. Displaying them on a public endpoint
// leaks absolute paths and internals to whoever triggers them. Set
// KAIZEN_DEBUG=1 in the environment to surface them while developing.
$kaizenDebug = filter_var(getenv('KAIZEN_DEBUG'), FILTER_VALIDATE_BOOLEAN);
error_reporting($kaizenDebug ? E_ALL : 0);
ini_set('display_errors', $kaizenDebug ? '1' : '0');
ini_set('log_errors', '1');
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

// Generate CSRF if missing
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if request is AJAX/JSON or regular form submission
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    } else {
        http_response_code(405);
        echo 'Method Not Allowed';
    }
    exit;
}

// Validate CSRF
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
    } else {
        http_response_code(403);
        echo 'Invalid CSRF token';
    }
    exit;
}

// Rate limiting
$dataDir = __DIR__ . '/../../data/';
$rateLimitFile = $dataDir . 'nyc_contact_rate_limits.txt';
$submissionFile = $dataDir . 'nyc_contact_submissions.txt';
$ip = $_SERVER['REMOTE_ADDR'];
$currentTime = time();
$rateLimitDuration = 300; // 5 minutes

// Create data directory if it doesn't exist
if (!is_dir($dataDir)) {
    if (!mkdir($dataDir, 0750, true)) {
        $error = 'Could not create data directory. Check permissions.';
        if ($isAjax) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => $error]);
        } else {
            http_response_code(500);
            echo $error;
        }
        exit;
    }
}

// Initialize rate limits
$rateLimits = [];
if (file_exists($rateLimitFile)) {
    $content = file_get_contents($rateLimitFile);
    if ($content !== false) {
        $rateLimits = json_decode($content, true) ?: [];
    }
}

// Check rate limit
if (isset($rateLimits[$ip]) && ($currentTime - $rateLimits[$ip] < $rateLimitDuration)) {
    $error = 'Please wait 5 minutes before submitting again.';
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(429);
        echo json_encode(['error' => $error]);
    } else {
        http_response_code(429);
        echo $error;
    }
    exit;
}

// Sanitize inputs
function clean($field, $default = '') {
    return isset($_POST[$field]) ? htmlspecialchars(trim($_POST[$field]), ENT_QUOTES) : $default;
}

$firstName = clean('firstName');
$lastName = clean('lastName');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone = clean('phone');
$role = clean('role'); // Admin or Parent
$borough = clean('borough');
$schoolName = clean('schoolName');
$message = clean('message');

// Validation
if (!$firstName || !$lastName) {
    $error = 'First name and last name are required.';
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $error]);
    } else {
        http_response_code(400);
        echo $error;
    }
    exit;
}

if (!$email) {
    $error = 'A valid email address is required.';
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['error' => $error]);
    } else {
        http_response_code(400);
        echo $error;
    }
    exit;
}

// Update rate limit
$rateLimits[$ip] = $currentTime;
file_put_contents($rateLimitFile, json_encode($rateLimits));

// Log to file
$logEntry = implode('|', [
    date('Y-m-d H:i:s'),
    $ip,
    $firstName,
    $lastName,
    $email,
    $phone,
    $role,
    $borough,
    $schoolName,
    $message
]) . PHP_EOL;

file_put_contents($submissionFile, $logEntry, FILE_APPEND | LOCK_EX);

// Send email using PHPMailer with SMTP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Loading the dependencies and the mail config used to sit outside the try
// block, so a missing or broken email_config.php produced an uncaught fatal:
// the enquiry was saved, the visitor got a 500 with no message, and nothing was
// logged. Both are inside the guard now, so any failure here is reported the
// same way an SMTP failure is.
$mail = null;

try {
    $autoload = __DIR__ . '/../../vendor/autoload.php';
    if (!is_file($autoload)) {
        throw new Exception('Composer dependencies are missing (vendor/autoload.php)');
    }
    require_once $autoload;

    $configPath = __DIR__ . '/../../../email_config.php';
    if (!is_file($configPath)) {
        throw new Exception('Email configuration not found above the web root');
    }
    $emailConfig = require $configPath;

    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = $emailConfig['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['smtp_user'];
    $mail->Password = $emailConfig['smtp_pass'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $emailConfig['smtp_port'];
    
    // Recipients
    $mail->setFrom($emailConfig['smtp_user'], 'Kaizen Karate NYC');
    $mail->addAddress('info@kaizenkaratenyc.com'); // NYC specific email
    $mail->addReplyTo($email, "$firstName $lastName"); // User's email for replies
    
    // Content
    $mail->isHTML(false);
    $mail->Subject = "NYC Inquiry: $role - $schoolName";
    
    $body = "NEW NYC INTEREST FORM\n";
    $body .= "=====================\n\n";
    $body .= "Role: $role\n";
    $body .= "School: $schoolName ($borough)\n";
    $body .= "Name: $firstName $lastName\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n\n";
    $body .= "Message:\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= wordwrap($message, 70) . "\n\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= "Technical Details:\n";
    $body .= "IP: $ip\n";
    $body .= "Date: " . date('Y-m-d H:i:s') . "\n";
    
    $mail->Body = $body;
    
    $mail->send();
    $mailSent = true;
    
} catch (Throwable $e) {
    $reason = ($mail !== null && $mail->ErrorInfo !== '') ? $mail->ErrorInfo : $e->getMessage();
    error_log("NYC Contact form email failed: {$reason} from IP: {$ip}");
    $mailSent = false;

    // The enquiry is already saved above, but a failed notification is
    // otherwise invisible: the visitor is thanked either way and nobody reads
    // the PHP error log. Record it where the admin can surface it.
    @file_put_contents(
        $dataDir . 'mail_failures.log',
        date('Y-m-d H:i:s') . '|nyc|' . $email . '|' . str_replace(["\n", '|'], ' ', $reason) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
}

// Response based on request type
if ($isAjax) {
    header('Content-Type: application/json');
    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Thank you! Your inquiry has been sent to our NYC team.']);
    } else {
        // The enquiry is stored, so this is not a failure from the visitor's
        // side, but do not tell them it reached the team when it did not.
        echo json_encode([
            'success' => true,
            'message' => 'Thank you! Your inquiry has been received. If you do not hear '
                       . 'back within two business days, please email info@kaizenkaratenyc.com.'
        ]);
    }
} else {
    header('Location: /nyc.php?status=success');
    exit;
}