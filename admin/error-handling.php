<?php
/**
 * Error display policy for the admin panel.
 *
 * Loaded first by every admin screen. Errors are written to the server log
 * rather than printed into the page: a PHP notice rendered mid-markup can sit
 * inside a form field and be saved back as content, which is exactly how the
 * summer camp features editor corrupted its own data.
 *
 * Set KAIZEN_DEBUG=1 in the environment to see them while developing.
 */

$kaizenDebug = filter_var(getenv('KAIZEN_DEBUG'), FILTER_VALIDATE_BOOLEAN);
error_reporting($kaizenDebug ? E_ALL : 0);
ini_set('display_errors', $kaizenDebug ? '1' : '0');
ini_set('log_errors', '1');
