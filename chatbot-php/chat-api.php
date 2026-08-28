<?php
/**
 * Chat API endpoint for the site's assistant widget.
 *
 * Accepts a question plus optional conversation history, routes it through
 * SimpleChatbotEngine (which loads the relevant slices of the knowledge base),
 * and returns the model's reply as JSON.
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
    require_once __DIR__ . '/SimpleChatbotEngine.php';
    
    $question = $_POST['question'] ?? '';
    $conversationHistory = $_POST['conversation_history'] ?? '';
    
    if (empty($question)) {
        echo json_encode(['success' => false, 'error' => 'No question provided']);
        exit;
    }
    
    // Parse conversation history if provided
    $history = [];
    if (!empty($conversationHistory)) {
        $decodedHistory = json_decode($conversationHistory, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedHistory)) {
            $history = $decodedHistory;
        }
    }
    
    $chatbot = new SimpleChatbotEngine(true); // Silent mode
    $response = $chatbot->getResponse($question, $history);
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log('Chatbot Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'error' => 'Sorry, I\'m having trouble right now. Please call 301-938-2711.'
    ]);
}
?>