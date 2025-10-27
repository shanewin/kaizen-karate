<?php
/**
 * Simple API endpoint for chat widget
 * Minimal production-ready chatbot API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    require_once 'SimpleChatbotEngine.php';
    
    $question = $_POST['question'] ?? '';
    
    if (empty($question)) {
        echo json_encode(['success' => false, 'error' => 'No question provided']);
        exit;
    }
    
    $chatbot = new SimpleChatbotEngine(true); // Silent mode
    $response = $chatbot->getResponse($question);
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log('Chatbot Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'error' => 'Sorry, I\'m having trouble right now. Please call 301-938-2711.'
    ]);
}
?>