<?php
define('KAIZEN_ADMIN', true);
session_start();

// Destroy session
session_destroy();

// Redirect to login
header('Location: login.php');
exit;
?>