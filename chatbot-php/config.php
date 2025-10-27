<?php
/**
 * Kaizen Karate Chatbot Configuration
 */

// OpenAI Configuration
// Load from environment file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $env = parse_ini_file(__DIR__ . '/.env');
    define('OPENAI_API_KEY', $env['OPENAI_API_KEY'] ?? 'your-openai-api-key-here');
} else {
    // Fallback - add your key here for server deployment
    define('OPENAI_API_KEY', 'your-openai-api-key-here');
}
define('OPENAI_API_URL', 'https://api.openai.com/v1/chat/completions');

// Data Configuration
define('DATA_FOLDER', '../data/content');
define('CACHE_FOLDER', './cache');
define('CACHE_DURATION', 3600); // 1 hour in seconds

// Chatbot Configuration
define('MAX_TOKENS', 500);
define('TEMPERATURE', 0.7);
define('MODEL', 'gpt-3.5-turbo');

// Rate Limiting (simple implementation)
define('RATE_LIMIT_REQUESTS', 50); // Max requests per hour per IP
define('RATE_LIMIT_WINDOW', 3600); // 1 hour

// CORS Configuration (adjust for your domain)
$allowed_origins = [
    'https://yourdomain.com',
    'https://www.yourdomain.com',
    'http://localhost' // For testing
];

// Error Reporting (set to false in production)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Create cache directory if it doesn't exist
if (!file_exists(CACHE_FOLDER)) {
    mkdir(CACHE_FOLDER, 0755, true);
}
?>