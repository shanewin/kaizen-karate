<?php
/**
 * Kaizen Karate Admin Configuration
 * 
 * Simple admin panel for content management
 */

// Prevent direct access
if (!defined('KAIZEN_ADMIN')) {
    die('Access denied');
}

// Admin credentials (change these!)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'kaizen2024!'); // Change this password!

// Paths
define('ADMIN_ROOT', __DIR__);
define('SITE_ROOT', dirname(__DIR__));
define('DATA_ROOT', SITE_ROOT . '/data');
define('CONTENT_ROOT', DATA_ROOT . '/content');

// Security
define('SESSION_TIMEOUT', 3600); // 1 hour

// Create content directory if it doesn't exist
if (!is_dir(CONTENT_ROOT)) {
    mkdir(CONTENT_ROOT, 0755, true);
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['login_time'])) {
        return false;
    }
    
    // Check session timeout
    if (time() - $_SESSION['login_time'] > SESSION_TIMEOUT) {
        session_destroy();
        return false;
    }
    
    // Update last activity time
    $_SESSION['login_time'] = time();
    return true;
}

/**
 * Require login
 */
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Sanitize input
 */
function sanitize_input($input) {
    // First trim whitespace
    $input = trim($input);
    // Decode any existing HTML entities to prevent double-encoding
    $input = html_entity_decode($input, ENT_QUOTES, 'UTF-8');
    // Store as plain text - htmlspecialchars will be applied when displaying
    return $input;
}

/**
 * Load JSON data file
 */
function load_json_data($filename) {
    // Add .json extension if not present
    if (!str_ends_with($filename, '.json')) {
        $filename .= '.json';
    }
    $filepath = CONTENT_ROOT . '/' . $filename;
    if (file_exists($filepath)) {
        $content = file_get_contents($filepath);
        return json_decode($content, true);
    }
    return array();
}

/**
 * Save JSON data file
 */
function save_json_data($filename, $data) {
    // Add .json extension if not present
    if (!str_ends_with($filename, '.json')) {
        $filename .= '.json';
    }
    $filepath = CONTENT_ROOT . '/' . $filename;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($filepath, $json) !== false;
}

/**
 * Success message
 */
function success_message($message) {
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">' . 
           $message . 
           '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}

/**
 * Error message
 */
function error_message($message) {
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . 
           $message . 
           '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}

/**
 * Generate CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Handle file upload with validation
 */
function handle_file_upload($file_input_name, $upload_type = 'image', $custom_path = '') {
    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error occurred'];
    }
    
    $file = $_FILES[$file_input_name];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // File size limit (2MB)
    $max_size = 2 * 1024 * 1024;
    if ($file_size > $max_size) {
        return ['success' => false, 'error' => 'File size too large. Maximum 2MB allowed.'];
    }
    
    // File type validation
    $allowed_types = [];
    $upload_dir = '';
    
    switch ($upload_type) {
        case 'image':
            $allowed_types = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            $upload_dir = $custom_path ?: '../assets/images/uploads/';
            break;
        case 'logo':
            $allowed_types = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            $upload_dir = '../assets/images/logos/';
            break;
        case 'video':
            $allowed_types = ['mp4', 'webm', 'ogg'];
            $upload_dir = $custom_path ?: '../assets/videos/uploads/';
            break;
        default:
            return ['success' => false, 'error' => 'Invalid upload type'];
    }
    
    if (!in_array($file_ext, $allowed_types)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: ' . implode(', ', $allowed_types)];
    }
    
    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
    $upload_path = $upload_dir . $new_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $upload_path)) {
        // Return relative path from website root
        $relative_path = str_replace('../', '', $upload_path);
        return [
            'success' => true, 
            'path' => $relative_path,
            'filename' => $new_filename,
            'original_name' => $file_name
        ];
    } else {
        return ['success' => false, 'error' => 'Failed to move uploaded file'];
    }
}

/**
 * Delete uploaded file
 */
function delete_uploaded_file($file_path) {
    if (file_exists('../' . $file_path)) {
        return unlink('../' . $file_path);
    }
    return false;
}

/**
 * Get file size in human readable format
 */
function format_file_size($bytes) {
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

/**
 * Validate image dimensions
 */
function validate_image_dimensions($file_path, $max_width = 2000, $max_height = 2000) {
    $image_info = getimagesize($file_path);
    if ($image_info) {
        $width = $image_info[0];
        $height = $image_info[1];
        
        if ($width > $max_width || $height > $max_height) {
            return [
                'valid' => false, 
                'error' => "Image dimensions too large. Maximum: {$max_width}x{$max_height}px, Got: {$width}x{$height}px"
            ];
        }
        return ['valid' => true, 'width' => $width, 'height' => $height];
    }
    return ['valid' => false, 'error' => 'Could not read image dimensions'];
}
?>