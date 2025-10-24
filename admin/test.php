<?php
// Simple test file to check admin system
echo "Admin test file loaded successfully!<br>";
echo "PHP version: " . phpversion() . "<br>";
echo "Current directory: " . __DIR__ . "<br>";

// Test config loading
define('KAIZEN_ADMIN', true);
echo "KAIZEN_ADMIN defined<br>";

// Test session
session_start();
echo "Session started<br>";

// Test config file
if (file_exists('config.php')) {
    echo "config.php exists<br>";
    require_once 'config.php';
    echo "config.php loaded successfully<br>";
    
    // Test functions
    if (function_exists('is_logged_in')) {
        echo "is_logged_in function exists<br>";
        echo "Logged in status: " . (is_logged_in() ? 'YES' : 'NO') . "<br>";
    } else {
        echo "is_logged_in function NOT found<br>";
    }
} else {
    echo "config.php NOT found<br>";
}

// Test content file
$content_file = '../data/content/site-content.json';
if (file_exists($content_file)) {
    echo "site-content.json exists<br>";
} else {
    echo "site-content.json NOT found at: " . $content_file . "<br>";
}
?>