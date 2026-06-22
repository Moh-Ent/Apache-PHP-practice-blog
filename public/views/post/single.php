<?php $title = htmlspecialchars($post['title']); ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container" style="max-width: 750px;">

    <!-- Post -->
    <div class="post-card" style="margin-bottom: 2rem; padding: 2rem;">

        <h1 style="font-size: 1.6rem; margin-bottom: 0.5rem;">
            <?= htmlspecialchars($post['title']) ?>
        </h1>

        <div class="meta" style="margin-bottom: 1.5rem;">
            Posted by <strong><?= htmlspecialchars($post['username']) ?></strong>
            &mdash; <?= date('M j, Y \a\t g:i a', strtotime($post['created_at'])) ?>
        </div>

        <div style="line-height: 1.8; color: var(--text);">
            <?= nl2br(htmlspecialchars($post['body'])) ?>
        </div>

        <!-- Delete button — only show to post owner or admin -->
        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['role'] === 'admin')): ?>
            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                <a href="/post/delete/<?= $post['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Are you sure you want to delete this post?')">
                    Delete Post
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- Comments -->
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--text-muted);">
            <?= count($comments) ?> Comment<?= count($comments) !== 1 ? 's' : '' ?>
        </h2>

        <?php if (count($comments) > 0): ?>
            <?php foreach ($comments as $comment): ?>
                <div style="
                    background: var(--surface);
                    border: 1px solid var(--border);
                    border-radius: var(--radius);
                    padding: 1rem 1.2rem;
                    margin-bottom: 0.8rem;
                ">
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                        <strong style="color: var(--text);"><?= htmlspecialchars($comment['username']) ?></strong>
                        &mdash; <?= date('M j, Y \a\t g:i a', strtotime($comment['created_at'])) ?>
                    </div>
                    <p style="font-size: 0.95rem; line-height: 1.6;">
                        <?= nl2br(htmlspecialchars($comment['body'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: var(--radius);
                padding: 2rem;
                text-align: center;
                color: var(--text-muted);
                font-size: 0.9rem;
            ">
                No comments yet. Be the first to comment.
            </div>
        <?php endif; ?>
    </div>

    <!-- Add Comment Form -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div style="
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
        ">
            <h3 style="font-size: 1rem; margin-bottom: 1rem;">Leave a Comment</h3>

            <form action="/post/<?= $post['id'] ?>/comment" method="POST">
                <input type="hidden" name="csrf_token" value="<?= isset($csrf_token) ? $csrf_token : '' ?>">

                <div class="form-group">
                    <textarea
                        name="body"
                        placeholder="Write your comment..."
                        required
                        style="
                            width: 100%;
                            min-height: 100px;
                            padding: 0.7rem 1rem;
                            background: var(--surface-2);
                            border: 1px solid var(--border);
                            border-radius: var(--radius);
                            color: var(--text);
                            font-size: 0.9rem;
                            font-family: inherit;
                            resize: vertical;
                            outline: none;
                            line-height: 1.6;
                        "
                    ></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.6rem 1.5rem;">
                    Post Comment
                </button>
            </form>
        </div>
    <?php else: ?>
        <div style="
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            color: var(--text-muted);
        ">
            <a href="/login">Login</a> to leave a comment.
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
