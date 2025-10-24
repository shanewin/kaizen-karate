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
 * Load JSON data file with draft/live mode support
 */
function load_json_data($filename, $mode = 'live') {
    // Add .json extension if not present
    if (!str_ends_with($filename, '.json')) {
        $filename .= '.json';
    }
    
    // Add mode suffix for draft files
    $suffix = ($mode === 'draft') ? '-draft' : '';
    $base_filename = str_replace('.json', '', $filename);
    $full_filename = $base_filename . $suffix . '.json';
    
    $filepath = CONTENT_ROOT . '/' . $full_filename;
    
    if (file_exists($filepath)) {
        $content = file_get_contents($filepath);
        return json_decode($content, true);
    }
    
    // If draft doesn't exist but live does, copy live to draft
    if ($mode === 'draft') {
        $live_data = load_json_data($filename, 'live');
        if (!empty($live_data)) {
            save_json_data($filename, $live_data, 'draft');
            return $live_data;
        }
    }
    
    return array();
}

/**
 * Save JSON data file with draft/live mode support
 */
function save_json_data($filename, $data, $mode = 'draft', $change_details = []) {
    // Add .json extension if not present
    if (!str_ends_with($filename, '.json')) {
        $filename .= '.json';
    }
    
    // Add mode suffix for draft files
    $suffix = ($mode === 'live') ? '' : '-draft';
    $base_filename = str_replace('.json', '', $filename);
    $full_filename = $base_filename . $suffix . '.json';
    
    $filepath = CONTENT_ROOT . '/' . $full_filename;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    $result = file_put_contents($filepath, $json) !== false;
    
    // Track changes when saving to draft mode
    if ($result && $mode === 'draft') {
        track_file_change($base_filename, $change_details);
    }
    
    return $result;
}

/**
 * Track file changes for staging system
 */
function track_file_change($filename, $details = []) {
    $change_log = load_change_log();
    $base_filename = str_replace('.json', '', $filename);
    
    // Add to pending files if not already there
    if (!in_array($base_filename, $change_log['pending_files'])) {
        $change_log['pending_files'][] = $base_filename;
    }
    
    // Add change entry with optional details
    $change_entry = [
        'id' => 'change_' . time() . '_' . rand(100, 999),
        'file' => $base_filename,
        'timestamp' => date('c'), // ISO 8601 format
        'admin' => $_SESSION['admin_user'] ?? 'admin',
        'status' => 'draft'
    ];
    
    // Add detailed change information if provided
    if (!empty($details)) {
        $change_entry['details'] = $details;
    }
    
    $change_log['changes'][] = $change_entry;
    
    // Keep only last 100 changes to prevent log bloat
    if (count($change_log['changes']) > 100) {
        $change_log['changes'] = array_slice($change_log['changes'], -100);
    }
    
    save_change_log($change_log);
}

/**
 * Load change log
 */
function load_change_log() {
    $filepath = CONTENT_ROOT . '/change-log.json';
    if (file_exists($filepath)) {
        $content = file_get_contents($filepath);
        return json_decode($content, true);
    }
    
    // Return default structure
    return [
        'pending_files' => [],
        'changes' => []
    ];
}

/**
 * Save change log
 */
function save_change_log($data) {
    $filepath = CONTENT_ROOT . '/change-log.json';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($filepath, $json) !== false;
}

/**
 * Publish all draft changes to live
 */
function publish_all_changes() {
    $change_log = load_change_log();
    $published_files = [];
    $errors = [];
    
    foreach ($change_log['pending_files'] as $filename) {
        try {
            // Create backup of current live version
            $live_data = load_json_data($filename, 'live');
            if (!empty($live_data)) {
                save_json_data($filename . '-backup', $live_data, 'live');
            }
            
            // Publish draft to live
            $draft_data = load_json_data($filename, 'draft');
            if (!empty($draft_data)) {
                save_json_data($filename, $draft_data, 'live');
                $published_files[] = $filename;
            }
        } catch (Exception $e) {
            $errors[] = "Failed to publish {$filename}: " . $e->getMessage();
        }
    }
    
    // Update change log
    if (!empty($published_files)) {
        // Mark changes as published
        foreach ($change_log['changes'] as &$change) {
            if (in_array($change['file'], $published_files) && $change['status'] === 'draft') {
                $change['status'] = 'published';
                $change['published_at'] = date('c');
            }
        }
        
        // Clear pending files
        $change_log['pending_files'] = array_diff($change_log['pending_files'], $published_files);
        $change_log['pending_files'] = array_values($change_log['pending_files']); // Re-index
        
        save_change_log($change_log);
    }
    
    return [
        'success' => empty($errors),
        'published_files' => $published_files,
        'errors' => $errors
    ];
}

/**
 * Get pending changes summary
 */
function get_pending_changes() {
    $change_log = load_change_log();
    
    // Group changes by file to count per-file changes
    $file_change_counts = [];
    foreach ($change_log['changes'] as $change) {
        if ($change['status'] === 'draft') {
            $file = $change['file'];
            $file_change_counts[$file] = ($file_change_counts[$file] ?? 0) + 1;
        }
    }
    
    // Collect detailed changes for display
    $detailed_changes = [];
    foreach ($change_log['changes'] as $change) {
        if ($change['status'] === 'draft' && isset($change['details']['changes'])) {
            foreach ($change['details']['changes'] as $change_text) {
                $detailed_changes[] = $change_text;
            }
        }
    }
    
    // Build detailed file info
    $detailed_files = [];
    foreach ($change_log['pending_files'] as $file) {
        $detailed_files[] = [
            'name' => $file,
            'display_name' => $file . '.json',
            'change_count' => $file_change_counts[$file] ?? 0
        ];
    }
    
    return [
        'file_count' => count($change_log['pending_files']),
        'pending_files' => $change_log['pending_files'],
        'detailed_files' => $detailed_files,
        'detailed_changes' => $detailed_changes,
        'total_changes' => count(array_filter($change_log['changes'], function($change) {
            return $change['status'] === 'draft';
        })),
        'last_change' => !empty($change_log['changes']) ? end($change_log['changes']) : null
    ];
}

/**
 * Check if draft files exist for a given filename
 */
function has_draft_changes($filename) {
    $base_filename = str_replace('.json', '', $filename);
    $draft_filepath = CONTENT_ROOT . '/' . $base_filename . '-draft.json';
    return file_exists($draft_filepath);
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