<?php $title = 'Create Post'; ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem;">Create Post</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">Share something with the community</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/post/create" method="POST" style="max-width: 700px;">
        <input type="hidden" name="csrf_token" value="<?= isset($csrf_token) ? $csrf_token : '' ?>">

        <div class="form-group">
            <label for="title">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Give your post a title"
                value="<?= isset($old['title']) ? htmlspecialchars($old['title']) : '' ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="body">Content</label>
            <textarea
                id="body"
                name="body"
                placeholder="Write your post here..."
                required
                style="
                    width: 100%;
                    min-height: 250px;
                    padding: 0.7rem 1rem;
                    background: var(--surface-2);
                    border: 1px solid var(--border);
                    border-radius: var(--radius);
                    color: var(--text);
                    font-size: 0.95rem;
                    font-family: inherit;
                    resize: vertical;
                    outline: none;
                    line-height: 1.6;
                "
            ><?= isset($old['body']) ? htmlspecialchars($old['body']) : '' ?></textarea>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.7rem 2rem;">
                Publish Post
            </button>
            <a href="/home" style="color: var(--text-muted); font-size: 0.9rem;">Cancel</a>
        </div>

    </form>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
