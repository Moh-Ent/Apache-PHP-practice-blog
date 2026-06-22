<?php

class Post {

    // ── Create Post ───────────────────────────────

    public static function create() {
        requireLogin();
        verifyCsrfToken();

        $title = post('title');
        $body  = post('body');

        $old = [
            'title' => $title,
            'body'  => $body
        ];

        // ── Validation ───────────────────────────

        if (empty($title) || empty($body)) {
            $error = 'All fields are required.';
            $csrf_token = generateCsrfToken();
            require __DIR__ . '/../public/views/post/create.php';
            return;
        }

        if (strlen($title) < 3 || strlen($title) > 200) {
            $error = 'Title must be between 3 and 200 characters.';
            $csrf_token = generateCsrfToken();
            require __DIR__ . '/../public/views/post/create.php';
            return;
        }

        if (strlen($body) < 10) {
            $error = 'Post body must be at least 10 characters.';
            $csrf_token = generateCsrfToken();
            require __DIR__ . '/../public/views/post/create.php';
            return;
        }

        // ── Insert ───────────────────────────────

        $pdo  = getDB();
        $stmt = $pdo->prepare('
            INSERT INTO posts (user_id, title, body)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([
            $_SESSION['user_id'],
            $title,
            $body
        ]);

        $postId = $pdo->lastInsertId();

        redirect('/post/' . $postId);
    }

    // ── Get All Posts ─────────────────────────────

    public static function getAll() {
        $pdo  = getDB();
        $stmt = $pdo->prepare('
            SELECT
                posts.id,
                posts.title,
                posts.body,
                posts.created_at,
                users.username
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.status = "published"
            ORDER BY posts.created_at DESC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // ── Get Single Post ───────────────────────────

    public static function getOne($id) {
        $pdo  = getDB();
        $stmt = $pdo->prepare('
            SELECT
                posts.id,
                posts.title,
                posts.body,
                posts.created_at,
                posts.user_id,
                users.username
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = ?
            AND posts.status = "published"
        ');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ── Get Comments For a Post ───────────────────

    public static function getComments($postId) {
        $pdo  = getDB();
        $stmt = $pdo->prepare('
            SELECT
                comments.id,
                comments.body,
                comments.created_at,
                users.username
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = ?
            ORDER BY comments.created_at ASC
        ');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    // ── Add Comment ───────────────────────────────

    public static function addComment($postId) {
        requireLogin();
        verifyCsrfToken();

        $body = post('body');

        if (empty($body)) {
            redirect('/post/' . $postId);
            return;
        }

        if (strlen($body) < 2) {
            redirect('/post/' . $postId);
            return;
        }

        $pdo  = getDB();
        $stmt = $pdo->prepare('
            INSERT INTO comments (post_id, user_id, body)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([
            $postId,
            $_SESSION['user_id'],
            $body
        ]);

        redirect('/post/' . $postId);
    }

    // ── Delete Post ───────────────────────────────

    public static function delete($postId) {
        requireLogin();

        $pdo  = getDB();

        // make sure the post belongs to this user
        // unless they are admin
        $stmt = $pdo->prepare('SELECT user_id FROM posts WHERE id = ?');
        $stmt->execute([$postId]);
        $post = $stmt->fetch();

        if (!$post) {
            redirect('/home');
            return;
        }

        if ($post['user_id'] !== $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            require __DIR__ . '/../public/views/404.php';
            return;
        }

        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$postId]);

        redirect('/home');
    }
}
