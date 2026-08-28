<?php
define('KAIZEN_ADMIN', true);
session_start();
require_once __DIR__ . '/error-handling.php';
require_once 'config.php';
require_once __DIR__ . '/publish-actions.php';

// Require login
require_login();

// Set content type for JSON response
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    // Get input data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['action']) || $input['action'] !== 'publish') {
        throw new Exception('Invalid action');
    }

    // These endpoints change live content, so they verify the CSRF token like
    // every other admin form does. The token travels in the JSON body since the
    // dashboard posts JSON.
    if (!verify_csrf_token($input['csrf_token'] ?? '')) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Invalid security token']);
        exit;
    }

    // Publish all pending changes, then re-derive the chatbot corpus.
    $result = publish_all_changes_and_project();
    
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Changes published successfully',
            'published_files' => $result['published_files'],
            'topics_refreshed' => count($result['projection']['written'])
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to publish some changes',
            'details' => $result['errors']
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>