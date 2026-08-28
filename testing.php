<?php
/**
 * Kaizen Karate preview site.
 *
 * Renders the homepage from draft content so staff can review unpublished
 * edits before they go live.
 *
 * This file used to be a 4,904 line copy of index.php, kept in step by hand and
 * by scripts/sync-files.php. It had drifted badly, so the preview no longer
 * resembled the live site. It is now a wrapper: it authenticates, points the
 * content layer at the draft files, and includes index.php. There is one
 * homepage template, rendered twice against different content.
 */

define('KAIZEN_ADMIN', true);
define('KAIZEN_TESTING', true);   // content-loader.php defers loading to us

session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure'   => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

// Preview shows unpublished content, so it is behind the admin login.
require_once __DIR__ . '/admin/config.php';
if (!is_logged_in()) {
    header('Location: admin/login.php');
    exit;
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/includes/content-loader.php';

// The globals the content helpers read. Because KAIZEN_TESTING is defined,
// content-loader.php left these for us to populate from the drafts.
// load_json_data() falls back to the live file when no draft exists.
$site_content     = load_json_data('site-content', 'draft');
$instructors_data = load_json_data('instructors', 'draft');
$media_data       = load_json_data('media', 'draft');

require __DIR__ . '/index.php';
