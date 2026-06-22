<?php
// ── Bootstrap ────────────────────────────────────
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/Post.php';
require_once __DIR__ . '/../src/Admin.php';

// ── Get the URL ──────────────────────────────────
$url = $_GET['url'] ?? '';
$url = trim($url, '/');
$url = strtolower($url);

// ── Get the request method ───────────────────────
$method = $_SERVER['REQUEST_METHOD'];

// ── Split URL into parts ─────────────────────────
$parts = explode('/', $url);

// ── Router ───────────────────────────────────────

// HOME
if ($url === '' || $url === 'home') {
    requireLogin();
    $posts = Post::getAll();
    require __DIR__ . '/views/home.php';

// REGISTER
} elseif ($url === 'register') {
    redirectIfLoggedIn();
    if ($method === 'POST') {
        Auth::register();
    } else {
        $csrf_token = generateCsrfToken();
        require __DIR__ . '/views/register.php';
    }

// LOGIN
} elseif ($url === 'login') {
    redirectIfLoggedIn();
    if ($method === 'POST') {
        Auth::login();
    } else {
        $csrf_token = generateCsrfToken();
        require __DIR__ . '/views/login.php';
    }

// LOGOUT
} elseif ($url === 'logout') {
    Auth::logout();

// CREATE POST
} elseif ($url === 'post/create') {
    requireLogin();
    if ($method === 'POST') {
        Post::create();
    } else {
        $csrf_token = generateCsrfToken();
        require __DIR__ . '/views/post/create.php';
    }

// DELETE POST
} elseif ($parts[0] === 'post' && isset($parts[1]) && $parts[1] === 'delete' && isset($parts[2])) {
    $postId = (int)$parts[2];
    Post::delete($postId);

// ADD COMMENT
} elseif ($parts[0] === 'post' && isset($parts[2]) && $parts[2] === 'comment') {
    $postId = (int)$parts[1];
    if ($method === 'POST') {
        Post::addComment($postId);
    } else {
        redirect('/post/' . $postId);
    }

// SINGLE POST
} elseif ($parts[0] === 'post' && isset($parts[1]) && is_numeric($parts[1])) {
    $postId = (int)$parts[1];
    $post   = Post::getOne($postId);

    if (!$post) {
        http_response_code(404);
        require __DIR__ . '/views/404.php';
    } else {
        $comments   = Post::getComments($postId);
        $csrf_token = generateCsrfToken();
        require __DIR__ . '/views/post/single.php';
    }

// ── Admin Routes ─────────────────────────────────

// ADMIN DASHBOARD
} elseif ($url === 'admin') {
    requireAdmin();
    $stats = Admin::getStats();
    require __DIR__ . '/views/admin/dashboard.php';

// ADMIN USERS
} elseif ($url === 'admin/users') {
    requireAdmin();
    $csrf_token = generateCsrfToken();
    $users = Admin::getUsers();
    require __DIR__ . '/views/admin/users.php';

// ADMIN BAN USER
} elseif ($parts[0] === 'admin' && $parts[1] === 'users' && $parts[2] === 'ban' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::banUser((int)$parts[3]);

// ADMIN UNBAN USER
} elseif ($parts[0] === 'admin' && $parts[1] === 'users' && $parts[2] === 'unban' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::unbanUser((int)$parts[3]);

// ADMIN DELETE USER
} elseif ($parts[0] === 'admin' && $parts[1] === 'users' && $parts[2] === 'delete' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::deleteUser((int)$parts[3]);

// ADMIN MAKE ADMIN
} elseif ($parts[0] === 'admin' && $parts[1] === 'users' && $parts[2] === 'make-admin' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::makeAdmin((int)$parts[3]);

// ADMIN POSTS
} elseif ($url === 'admin/posts') {
    requireAdmin();
    $csrf_token = generateCsrfToken();
    $posts = Admin::getPosts();
    require __DIR__ . '/views/admin/posts.php';

// ADMIN REMOVE POST
} elseif ($parts[0] === 'admin' && $parts[1] === 'posts' && $parts[2] === 'remove' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::removePost((int)$parts[3]);

// ADMIN RESTORE POST
} elseif ($parts[0] === 'admin' && $parts[1] === 'posts' && $parts[2] === 'restore' && isset($parts[3])) {
    requireAdmin();
    verifyCsrfToken();
    Admin::restorePost((int)$parts[3]);

// 404
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
