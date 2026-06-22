<?php $title = 'Manage Posts'; ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <!-- Header -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.5rem;">Manage Posts</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">
                <?= count($posts) ?> total posts
            </p>
        </div>
        <a href="/admin" style="color: var(--text-muted); font-size: 0.9rem;">← Back to Dashboard</a>
    </div>

    <!-- Posts Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>

                    <td><?= $post['id'] ?></td>

                    <td>
                        <a href="/post/<?= $post['id'] ?>" style="color: var(--text);">
                            <?= htmlspecialchars(substr($post['title'], 0, 60)) ?>
                            <?= strlen($post['title']) > 60 ? '...' : '' ?>
                        </a>
                    </td>

                    <td style="color: var(--text-muted);">
                        <?= htmlspecialchars($post['username']) ?>
                    </td>

                    <td>
                        <?php if ($post['status'] === 'published'): ?>
                            <span class="badge badge-user" style="background: rgba(62,207,142,0.15); color: var(--success);">
                                Published
                            </span>
                        <?php elseif ($post['status'] === 'removed'): ?>
                            <span class="badge badge-banned">Removed</span>
                        <?php else: ?>
                            <span class="badge badge-user">Draft</span>
                        <?php endif; ?>
                    </td>

                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        <?= date('M j, Y', strtotime($post['created_at'])) ?>
                    </td>

                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <?php if ($post['status'] === 'published'): ?>
                                <form action="/admin/posts/remove/<?= $post['id'] ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Remove this post from public view?')">
                                        Remove
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="/admin/posts/restore/<?= $post['id'] ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-sm" style="background: var(--success); color: #fff;">
                                        Restore
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
