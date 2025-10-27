<?php
/**
 * File Sync Script for Kaizen Karate
 * 
 * This script helps keep index.php and testing.php in sync for hardcoded changes.
 * Run this after making styling or structural changes to index.php
 */

// Only allow execution from command line or admin access
if (php_sapi_name() !== 'cli') {
    session_start();
    require_once 'admin/config.php';
    if (!is_logged_in()) {
        die('Access denied. Admin login required.');
    }
}

function syncHardcodedChanges() {
    $indexFile = __DIR__ . '/index.php';
    $testingFile = __DIR__ . '/testing.php';
    
    if (!file_exists($indexFile)) {
        echo "Error: index.php not found\n";
        return false;
    }
    
    if (!file_exists($testingFile)) {
        echo "Error: testing.php not found\n";
        return false;
    }
    
    // Read both files
    $indexContent = file_get_contents($indexFile);
    $testingContent = file_get_contents($testingFile);
    
    // Extract the CSS/JS sections from index.php (between <style> and </style>)
    if (preg_match('/<style[^>]*>(.*?)<\/style>/s', $indexContent, $indexMatches)) {
        $indexStyles = $indexMatches[1];
        
        // Replace the CSS section in testing.php
        $testingContent = preg_replace(
            '/<style[^>]*>.*?<\/style>/s',
            '<style>' . $indexStyles . '</style>',
            $testingContent
        );
        
        // Create backup
        $backupFile = $testingFile . '.backup.' . date('Y-m-d-H-i-s');
        copy($testingFile, $backupFile);
        
        // Write updated content
        if (file_put_contents($testingFile, $testingContent)) {
            echo "✅ Successfully synced hardcoded changes from index.php to testing.php\n";
            echo "📁 Backup created: " . basename($backupFile) . "\n";
            return true;
        } else {
            echo "❌ Error: Could not write to testing.php\n";
            return false;
        }
    } else {
        echo "⚠️  No <style> section found in index.php\n";
        return false;
    }
}

// Run the sync
echo "🔄 Syncing hardcoded changes between index.php and testing.php...\n\n";
$result = syncHardcodedChanges();

if (php_sapi_name() !== 'cli') {
    // Web interface response
    header('Content-Type: text/plain');
    if ($result) {
        echo "\n✅ Sync completed successfully!";
    } else {
        echo "\n❌ Sync failed. Check file permissions.";
    }
}
?>