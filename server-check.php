<?php
/**
 * Kaizen Karate Server Requirements Checker
 * Upload this file to your server and run it to check compatibility
 */

echo "<h1>🥋 Kaizen Karate Server Check</h1>";

// PHP Version Check
echo "<h2>PHP Version</h2>";
$phpVersion = phpversion();
$minVersion = '7.4.0';
$versionOK = version_compare($phpVersion, $minVersion, '>=');
echo "<p>Current: <strong>$phpVersion</strong></p>";
echo "<p>Required: <strong>$minVersion+</strong></p>";
echo "<p>Status: " . ($versionOK ? "✅ OK" : "❌ UPGRADE NEEDED") . "</p>";

// PHP Extensions Check
echo "<h2>PHP Extensions</h2>";
$requiredExtensions = ['json', 'session', 'filter', 'hash'];
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "<p><strong>$ext:</strong> " . ($loaded ? "✅ Loaded" : "❌ Missing") . "</p>";
}

// Directory Permissions Check
echo "<h2>Directory Permissions</h2>";
$dataDir = __DIR__ . '/data/';
$contentDir = $dataDir . 'content/';

// Check if we can create directories
if (!is_dir($dataDir)) {
    $created = @mkdir($dataDir, 0750, true);
    echo "<p><strong>/data/ directory:</strong> " . ($created ? "✅ Created successfully" : "❌ Cannot create") . "</p>";
} else {
    echo "<p><strong>/data/ directory:</strong> ✅ Exists</p>";
}

// Check write permissions
$testFile = $dataDir . 'test.txt';
$canWrite = @file_put_contents($testFile, 'test');
if ($canWrite) {
    @unlink($testFile);
    echo "<p><strong>Write permissions:</strong> ✅ OK</p>";
} else {
    echo "<p><strong>Write permissions:</strong> ❌ Cannot write to /data/</p>";
}

// Apache mod_rewrite check
echo "<h2>Apache Configuration</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    $rewriteEnabled = in_array('mod_rewrite', $modules);
    echo "<p><strong>mod_rewrite:</strong> " . ($rewriteEnabled ? "✅ Enabled" : "❌ Disabled") . "</p>";
} else {
    echo "<p><strong>mod_rewrite:</strong> ⚠️ Cannot detect (may still work)</p>";
}

// .htaccess test
$htaccessExists = file_exists(__DIR__ . '/.htaccess');
echo "<p><strong>.htaccess file:</strong> " . ($htaccessExists ? "✅ Found" : "❌ Missing") . "</p>";

// Session functionality test
echo "<h2>Session Test</h2>";
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p><strong>Sessions:</strong> ✅ Working</p>";
    $_SESSION['test'] = 'OK';
} else {
    echo "<p><strong>Sessions:</strong> ❌ Not working</p>";
}

// CSRF token generation test
echo "<h2>Security Features</h2>";
try {
    $token = bin2hex(random_bytes(32));
    echo "<p><strong>CSRF tokens:</strong> ✅ Can generate</p>";
} catch (Exception $e) {
    echo "<p><strong>CSRF tokens:</strong> ❌ Error: " . $e->getMessage() . "</p>";
}

// File includes test
echo "<h2>File System</h2>";
$contentLoader = __DIR__ . '/includes/content-loader.php';
if (file_exists($contentLoader)) {
    echo "<p><strong>Content loader:</strong> ✅ Found</p>";
    try {
        require_once $contentLoader;
        echo "<p><strong>Content loader:</strong> ✅ Loads successfully</p>";
    } catch (Exception $e) {
        echo "<p><strong>Content loader:</strong> ❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p><strong>Content loader:</strong> ❌ Missing /includes/content-loader.php</p>";
}

echo "<h2>Summary</h2>";
echo "<p>If you see any ❌ errors above, contact your hosting provider to fix them.</p>";
echo "<p>Upload this file as <code>server-check.php</code> to your server root and visit it in your browser.</p>";
?>

<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
h1 { color: #d32f2f; }
h2 { color: #333; border-bottom: 2px solid #d32f2f; padding-bottom: 5px; }
p { margin: 5px 0; }
code { background: #f5f5f5; padding: 2px 4px; border-radius: 3px; }
</style> 