<?php
/**
 * Chat API endpoint for the site's assistant widget.
 *
 * Accepts a question plus optional conversation history, routes it through
 * SimpleChatbotEngine (which loads the relevant slices of the knowledge base),
 * and returns the model's reply as JSON.
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

/**
 * Every request here costs money, so the endpoint is restricted to the sites
 * that are meant to embed the widget. $allowed_origins comes from config.php
 * and was previously declared but never enforced -- the endpoint answered
 * 'Access-Control-Allow-Origin: *', so any site could embed the assistant and
 * bill this account.
 *
 * A rejected origin is refused before the model is called, not merely blocked
 * in the browser afterwards, so a disallowed embed costs nothing.
 */
$allowed = array_map(
    static function ($origin) { return rtrim(trim($origin), '/'); },
    isset($allowed_origins) && is_array($allowed_origins) ? $allowed_origins : []
);

$origin = isset($_SERVER['HTTP_ORIGIN']) ? rtrim(trim($_SERVER['HTTP_ORIGIN']), '/') : '';

if ($origin !== '') {
    // Any localhost port counts as local development.
    $isLocal = (bool) preg_match('#^https?://(localhost|127\\.0\\.0\\.1)(:\\d+)?$#', $origin);

    if (!in_array($origin, $allowed, true) && !$isLocal) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Origin not allowed']);
        exit;
    }

    header('Access-Control-Allow-Origin: ' . $origin);
    header('Vary: Origin'); // the response body varies per origin; keep caches honest
}
// No Origin header means a same-origin or non-browser request; CORS headers are
// not needed and adding them would weaken, not strengthen, the check.

header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

/**
 * Per-caller rate limit. The origin check above stops other sites embedding the
 * widget, but it cannot stop a script posting here directly -- such a request
 * carries no Origin header at all. This is the limit that actually caps spend.
 *
 * RATE_LIMIT_REQUESTS and RATE_LIMIT_WINDOW have been defined in config.php all
 * along without anything reading them.
 */
require_once __DIR__ . '/RateLimiter.php';

$limiter = new RateLimiter(
    __DIR__ . '/../data/chat_rate_limits.txt',
    RATE_LIMIT_REQUESTS,
    RATE_LIMIT_WINDOW
);

$caller = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
$quota  = $limiter->hit($caller);

header('X-RateLimit-Limit: ' . RATE_LIMIT_REQUESTS);
header('X-RateLimit-Remaining: ' . $quota['remaining']);

if (!$quota['allowed']) {
    http_response_code(429);
    header('Retry-After: ' . $quota['retryAfter']);
    echo json_encode([
        'success' => false,
        'error'   => "You've reached the message limit for now. Please try again shortly, "
                   . 'or call us on 301-938-2711.',
    ]);
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