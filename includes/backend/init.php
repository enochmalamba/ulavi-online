<?php
// Session configuration - MUST be called before any output
ini_set('session.cookie_secure', 1);       // Only send over HTTPS
ini_set('session.cookie_httponly', 1);     // Prevent JavaScript access
ini_set('session.cookie_samesite', 'Strict'); // Prevent CSRF
ini_set('session.use_strict_mode', 1);     // Prevent session fixation

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Include config after session setup
require_once('config.php');
require_once('functions.php');