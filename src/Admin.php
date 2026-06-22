<?php

class Admin {

    // ── Dashboard Stats ───────────────────────────

    public static function getStats() {
        $pdo = getDB();

        $stats = [];

        $stmt = $pdo->query('SELECT COUNT(*) as total FROM users');
        $stats['total_users'] = $stmt->fetch()['total'];

        $stmt = $pdo->query('SELECT COUNT(*) as total FROM posts');
        $stats['total_posts'] = $stmt->fetch()['total'];

        $stmt = $pdo->query('SELECT COUNT(*) as total FROM comments');
        $stats['total_comments'] = $stmt->fetch()['total'];

        $stmt = $pdo->query('SELECT COUNT(*) as total FROM users WHERE is_banned = 1');
        $stats['banned_users'] = $stmt->fetch()['total'];

        $stmt = $pdo->query('SELECT COUNT(*) as total FROM posts WHERE status = "removed"');
        $stats['removed_posts'] = $stmt->fetch()['total'];

        return $stats;
    }

    // ── Get All Users ─────────────────────────────

    public static function getUsers() {
        $pdo  = getDB();
        $stmt = $pdo->query('
            SELECT
                id,
                username,
                email,
                role,
                is_banned,
                created_at
            FROM users
            ORDER BY created_at DESC
        ');
        return $stmt->fetchAll();
    }

    // ── Get All Posts ─────────────────────────────

    public static function getPosts() {
        $pdo  = getDB();
        $stmt = $pdo->query('
            SELECT
                posts.id,
                posts.title,
                posts.status,
                posts.created_at,
                users.username
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
        ');
        return $stmt->fetchAll();
    }

    // ── Ban User ──────────────────────────────────

    public static function banUser($userId) {
        // never ban yourself
        if ($userId == $_SESSION['user_id']) {
            redirect('/admin/users');
            return;
        }

        $pdo  = getDB();
        $stmt = $pdo->prepare('UPDATE users SET is_banned = 1 WHERE id = ?');
        $stmt->execute([$userId]);

        redirect('/admin/users');
    }

    // ── Unban User ────────────────────────────────

    public static function unbanUser($userId) {
        $pdo  = getDB();
        $stmt = $pdo->prepare('UPDATE users SET is_banned = 0 WHERE id = ?');
        $stmt->execute([$userId]);

        redirect('/admin/users');
    }

    // ── Delete User ───────────────────────────────

    public static function deleteUser($userId) {
        // never delete yourself
        if ($userId == $_SESSION['user_id']) {
            redirect('/admin/users');
            return;
        }

        // never delete another admin
        $pdo  = getDB();
        $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user || $user['role'] === 'admin') {
            redirect('/admin/users');
            return;
        }

        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        redirect('/admin/users');
    }

    // ── Remove Post ───────────────────────────────

    public static function removePost($postId) {
        $pdo  = getDB();
        $stmt = $pdo->prepare('UPDATE posts SET status = "removed" WHERE id = ?');
        $stmt->execute([$postId]);

        redirect('/admin/posts');
    }

    // ── Restore Post ──────────────────────────────

    public static function restorePost($postId) {
        $pdo  = getDB();
        $stmt = $pdo->prepare('UPDATE posts SET status = "published" WHERE id = ?');
        $stmt->execute([$postId]);

        redirect('/admin/posts');
    }

    // ── Make Admin ────────────────────────────────

    public static function makeAdmin($userId) {
        // don't demote yourself
        if ($userId == $_SESSION['user_id']) {
            redirect('/admin/users');
            return;
        }

        $pdo  = getDB();
        $stmt = $pdo->prepare('UPDATE users SET role = "admin" WHERE id = ?');
        $stmt->execute([$userId]);

        redirect('/admin/users');
    }
}
