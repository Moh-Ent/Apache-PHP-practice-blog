<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' — MyApp' : 'MyApp' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <a href="/" class="logo">⚡ MyApp</a>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/home">Home</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/admin">Admin Panel</a>
            <?php endif; ?>
            <a href="/logout">Logout</a>
        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>
    </nav>
</nav>
