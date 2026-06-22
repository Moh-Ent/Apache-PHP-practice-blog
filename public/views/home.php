<?php $title = 'Home'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="container">

    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.5rem;">Welcome back, <span style="color: var(--primary)"><?= htmlspecialchars($_SESSION['username']) ?></span></h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">Here's what's happening today</p>
        </div>
        <a href="/post/create" class="btn btn-primary" style="width: auto; padding: 0.6rem 1.2rem;">+ New Post</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Posts feed -->
    <div class="posts-feed">
        <?php if (isset($posts) && count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <h2>
                        <a href="/post/<?= $post['id'] ?>" style="color: var(--text);">
                            <?= htmlspecialchars($post['title']) ?>
                        </a>
                    </h2>
                    <div class="meta">
                        Posted by <strong><?= htmlspecialchars($post['username']) ?></strong>
                        &mdash; <?= date('M j, Y', strtotime($post['created_at'])) ?>
                    </div>
                    <p><?= htmlspecialchars(substr($post['body'], 0, 150)) ?>...</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="post-card" style="text-align: center; padding: 3rem;">
                <p style="color: var(--text-muted); margin-bottom: 1rem;">No posts yet. Be the first to post.</p>
                <a href="/post/create" class="btn btn-primary" style="width: auto;">+ Create First Post</a>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
