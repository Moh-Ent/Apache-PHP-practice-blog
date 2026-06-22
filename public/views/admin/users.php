<?php $title = 'Manage Users'; ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <!-- Header -->
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.5rem;">Manage Users</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">
                <?= count($users) ?> total users
            </p>
        </div>
        <a href="/admin" style="color: var(--text-muted); font-size: 0.9rem;">← Back to Dashboard</a>
    </div>

    <!-- Users Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>

                    <td><?= htmlspecialchars($user['username']) ?></td>

                    <td style="color: var(--text-muted);">
                        <?= htmlspecialchars($user['email']) ?>
                    </td>

                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge badge-admin">Admin</span>
                        <?php else: ?>
                            <span class="badge badge-user">User</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($user['is_banned']): ?>
                            <span class="badge badge-banned">Banned</span>
                        <?php else: ?>
                            <span class="badge badge-user">Active</span>
                        <?php endif; ?>
                    </td>

                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        <?= date('M j, Y', strtotime($user['created_at'])) ?>
                    </td>

                    <!-- Actions — never show on yourself -->
                    <td>
                        <?php if ($user['id'] != $_SESSION['user_id'] && $user['role'] !== 'admin'): ?>
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">

                                <?php if ($user['is_banned']): ?>
                                    <form action="/admin/users/unban/<?= $user['id'] ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <button type="submit" class="btn btn-sm" style="background: var(--success); color: #fff;">
                                            Unban
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="/admin/users/ban/<?= $user['id'] ?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <button type="submit" class="btn btn-sm" style="background: var(--surface-2); color: var(--text);">
                                            Ban
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <form action="/admin/users/make-admin/<?= $user['id'] ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-sm" style="background: var(--primary); color: #fff;"
                                        onclick="return confirm('Make <?= htmlspecialchars($user['username']) ?> an admin?')">
                                        Make Admin
                                    </button>
                                </form>

                                <form action="/admin/users/delete/<?= $user['id'] ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete <?= htmlspecialchars($user['username']) ?>? This cannot be undone.')">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        <?php elseif ($user['id'] == $_SESSION['user_id']): ?>
                            <span style="color: var(--text-muted); font-size: 0.8rem;">You</span>
                        <?php elseif ($user['role'] === 'admin'): ?>
                            <span style="color: var(--text-muted); font-size: 0.8rem;">Admin</span>
                        <?php endif; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
