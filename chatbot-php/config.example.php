<?php
/**
 * Kaizen Karate Chatbot Configuration
 *
 * Copy to config.php. Secrets come from chatbot-php/.env or the environment;
 * config.php and .env are both gitignored.
 */

// OpenAI Configuration
// Load from environment file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $env = parse_ini_file(__DIR__ . '/.env');
    define('ANTHROPIC_API_KEY', $env['ANTHROPIC_API_KEY'] ?? 'your-athropic-api-key-here');
} else {
    // No .env present: fall back to a real environment variable.
    define('ANTHROPIC_API_KEY', getenv('ANTHROPIC_API_KEY') ?: '');
}
 define('ANTHROPIC_API_URL', 'https://api.anthropic.com/v1/messages');

// Data Configuration
define('DATA_FOLDER', __DIR__ . '/../data/content');
define('CACHE_FOLDER', __DIR__ . '/cache');
define('CACHE_DURATION', 3600); // 1 hour in seconds

// Chatbot Configuration
define('MAX_TOKENS', 1000);
define('TEMPERATURE', 0.7);
define('MODEL', 'claude-haiku-4-5');

// Rate Limiting (simple implementation)
define('RATE_LIMIT_REQUESTS', 50); // Max requests per hour per IP
define('RATE_LIMIT_WINDOW', 3600); // 1 hour

// CORS Configuration (adjust for your domain)
$allowed_origins = [
    // No trailing slashes: an Origin header never has one.
    'https://kaizenkarateusa.com',
    'https://www.kaizenkarateusa.com',
    'https://kaizenfitnessusa.com',
    'https://www.kaizenfitnessusa.com',
];

// Error Reporting (set to false in production)
define('DEBUG_MODE', filter_var(getenv('KAIZEN_DEBUG'), FILTER_VALIDATE_BOOLEAN));

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Create cache directory if it doesn't exist
if (!file_exists(CACHE_FOLDER)) {
    mkdir(CACHE_FOLDER, 0755, true);
}
?>
