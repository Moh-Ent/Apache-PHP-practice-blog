<?php

// ── CSRF ─────────────────────────────────────────

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken() {
    if (
        empty($_SESSION['csrf_token']) ||
        empty($_POST['csrf_token'])  ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        http_response_code(403);
        die('Invalid CSRF token.');
    }
    // regenerate after use so each form submission needs a fresh token
    unset($_SESSION['csrf_token']);
}

// ── Redirects ─────────────────────────────────────

function redirect($path) {
    header('Location: ' . $path);
    exit;
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        redirect('/login');
    }
}

function redirectIfLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        redirect('/home');
    }
}

function requireAdmin() {
    requireLogin();
    if ($_SESSION['role'] !== 'admin') {
        http_response_code(403);
        require __DIR__ . '/../public/views/404.php';
        exit;
    }
}

// ── Input ─────────────────────────────────────────

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function post($key, $default = '') {
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}
