<?php $title = 'Admin Dashboard'; ?>
<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container">

    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem;">Admin Dashboard</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.3rem;">
            Welcome back, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </p>
    </div>

    <!-- Stats Grid -->
    <div style="
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2.5rem;
    ">

        <div class="post-card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary);">
                <?= $stats['total_users'] ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.3rem;">
                Total Users
            </div>
        </div>

        <div class="post-card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--success);">
                <?= $stats['total_posts'] ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.3rem;">
                Total Posts
            </div>
        </div>

        <div class="post-card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--text);">
                <?= $stats['total_comments'] ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.3rem;">
                Total Comments
            </div>
        </div>

        <div class="post-card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--danger);">
                <?= $stats['banned_users'] ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.3rem;">
                Banned Users
            </div>
        </div>

        <div class="post-card" style="text-align: center; padding: 1.5rem;">
            <div style="font-size: 2.5rem; font-weight: 700; color: var(--danger);">
                <?= $stats['removed_posts'] ?>
            </div>
            <div style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.3rem;">
                Removed Posts
            </div>
        </div>

    </div>

    <!-- Quick Links -->
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.1rem; margin-bottom: 1rem;">Manage</h2>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="/admin/users" class="btn btn-primary" style="width: auto;">
                Manage Users
            </a>
            <a href="/admin/posts" class="btn btn-primary" style="width: auto;">
                Manage Posts
            </a>
            <a href="/home" class="btn" style="width: auto; background: var(--surface-2); color: var(--text);">
                Back to Site
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
