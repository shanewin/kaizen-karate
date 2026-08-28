<?php
// Errors are logged, never printed. Displaying them on a public endpoint
// leaks absolute paths and internals to whoever triggers them. Set
// KAIZEN_DEBUG=1 in the environment to surface them while developing.
$kaizenDebug = filter_var(getenv('KAIZEN_DEBUG'), FILTER_VALIDATE_BOOLEAN);
error_reporting($kaizenDebug ? E_ALL : 0);
ini_set('display_errors', $kaizenDebug ? '1' : '0');
ini_set('log_errors', '1');

if ($kaizenDebug) {
    file_put_contents(__DIR__ . '/form_debug.log', date('Y-m-d H:i:s') . " - Form handler started\n", FILE_APPEND);
}
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
$dataDir = __DIR__ . '/data/';
$rateLimitFile = $dataDir . 'contact_rate_limits.txt';
$submissionFile = $dataDir . 'contact_submissions.txt';
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

// Initialize rate limits.
// Held open under an exclusive lock for the read-modify-write below, so two
// overlapping submissions cannot lose each other's entry.
$rateLimits = [];
$rateLimitHandle = @fopen($rateLimitFile, 'c+');
if ($rateLimitHandle !== false && flock($rateLimitHandle, LOCK_EX)) {
    $content = stream_get_contents($rateLimitHandle);
    if ($content !== false && $content !== '') {
        $rateLimits = json_decode($content, true) ?: [];
    }
} else {
    if ($rateLimitHandle !== false) {
        fclose($rateLimitHandle);
    }
    $rateLimitHandle = false;
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
$age = clean('age');
$experience = clean('experience');
$hearAboutUs = clean('hearAboutUs');
$program = clean('program');
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

// Update rate limit, still inside the lock taken above.
$rateLimits[$ip] = $currentTime;
if ($rateLimitHandle !== false) {
    ftruncate($rateLimitHandle, 0);
    rewind($rateLimitHandle);
    fwrite($rateLimitHandle, json_encode($rateLimits));
    fflush($rateLimitHandle);
    flock($rateLimitHandle, LOCK_UN);
    fclose($rateLimitHandle);
    $rateLimitHandle = false;
} else {
    file_put_contents($rateLimitFile, json_encode($rateLimits), LOCK_EX);
}

// Log to file
$logEntry = implode('|', [
    date('Y-m-d H:i:s'),
    $ip,
    $firstName,
    $lastName,
    $email,
    $phone,
    $age,
    $experience,
    $program,
    $hearAboutUs,
    $message
]) . PHP_EOL;

file_put_contents($submissionFile, $logEntry, FILE_APPEND | LOCK_EX);

// Send email using PHPMailer with SMTP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
if ($kaizenDebug) { file_put_contents(__DIR__ . '/form_debug.log', date('Y-m-d H:i:s') . " - Autoload loaded\n", FILE_APPEND); }

// Load email config from secure location
$emailConfig = require __DIR__ . '/../email_config.php';
if ($kaizenDebug) { file_put_contents(__DIR__ . '/form_debug.log', date('Y-m-d H:i:s') . " - Config loaded successfully\n", FILE_APPEND); }

$mail = new PHPMailer(true);

if ($kaizenDebug) { file_put_contents(__DIR__ . '/form_debug.log', date('Y-m-d H:i:s') . " - About to try sending email\n", FILE_APPEND); }
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = $emailConfig['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['smtp_user'];
    $mail->Password = $emailConfig['smtp_pass'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $emailConfig['smtp_port'];
    
    // Recipients
    $mail->setFrom($emailConfig['smtp_user'], 'Kaizen Karate Website');
    $mail->addAddress('info@kaizenkaratenyc.com'); // Receive submissions here
    $mail->addReplyTo($email, "$firstName $lastName"); // User's email for replies
    
    // Content
    $mail->isHTML(false);
    $mail->Subject = 'New Contact Form Submission - Kaizen Karate';
    
    $body = "NEW CONTACT FORM SUBMISSION\n";
    $body .= "==========================\n\n";
    $body .= "Name: $firstName $lastName\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Age: $age\n";
    $body .= "Experience Level: $experience\n";
    $body .= "Program Interest: $program\n";
    $body .= "How They Heard About Us: $hearAboutUs\n\n";
    $body .= "Message:\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= wordwrap($message, 70) . "\n\n";
    $body .= str_repeat('-', 40) . "\n";
    $body .= "Technical Details:\n";
    $body .= "IP Address: $ip\n";
    $body .= "Submission Time: " . date('Y-m-d H:i:s') . "\n";
    $body .= "User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Not provided') . "\n";
    
    $mail->Body = $body;
    
    $mail->send();
    $mailSent = true;
    
} catch (Exception $e) {
    // Log detailed error info
    $errorMsg = "PHPMAILER ERROR: " . $e->getMessage() . "\n";
    $errorMsg .= "SMTP ErrorInfo: " . $mail->ErrorInfo . "\n";
    $errorMsg .= "Config user: " . $emailConfig['smtp_user'] . "\n";
    $errorMsg .= "Config host: " . $emailConfig['smtp_host'] . "\n";
    
    error_log($errorMsg);
    file_put_contents(__DIR__ . '/mail_error.log', date('Y-m-d H:i:s') . " - " . $errorMsg . "\n", FILE_APPEND);
    
    $mailSent = false;
}

// Response based on request type
if ($isAjax) {
    header('Content-Type: application/json');
    if ($mailSent) {
        echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
    } else {
        error_log('Contact form email failed to send from IP: ' . $ip);
        echo json_encode([
            'success' => true, 
            'message' => 'Thank you! Your message has been received (email notification failed but form was logged).'
        ]);
    }
} else {
    if ($mailSent) {
        header('Location: contact-thank-you.html');
        exit;
    } else {
        echo '<h1>Thank You!</h1>';
        echo '<p>Your message has been received. (Note: Email notification failed to send.)</p>';
        echo '<p><a href="/">Return to Home</a></p>';
    }
}
