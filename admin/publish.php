<?php
/**
 * Publish All Changes Handler
 * 
 * Handles the publishing of all draft changes to live site
 */

define('KAIZEN_ADMIN', true);
session_start();
require_once __DIR__ . '/error-handling.php';
require_once 'config.php';
require_once __DIR__ . '/publish-actions.php';

// Require login
require_login();

// Check CSRF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    
    // Publish all changes and re-derive the chatbot corpus.
    $result     = publish_all_changes_and_project();
    $projection = $result['projection'];

    // Set session message
    if ($result['success']) {
        $published_count = count($result['published_files']);
        $topic_count     = count($projection['written']);
        $_SESSION['publish_success'] = "Successfully published {$published_count} file(s) to live site"
            . " and refreshed {$topic_count} chatbot topic file(s).";

        if (!empty($projection['errors'])) {
            $_SESSION['publish_error'] = 'Site published, but the chatbot corpus could not be'
                . ' refreshed: ' . implode('; ', $projection['errors']);
        }
        
        // Log the publish action
        error_log("Admin published changes: " . implode(', ', $result['published_files']));
    } else {
        $_SESSION['publish_error'] = "Failed to publish changes: " . implode(', ', $result['errors']);
    }
    
    // Redirect back to preview site
    header('Location: ../testing.php');
    exit;
} else {
    // Invalid request method
    header('Location: dashboard.php');
    exit;
}
?>