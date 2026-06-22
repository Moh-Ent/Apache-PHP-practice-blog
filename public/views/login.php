<?php $title = 'Login'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">

        <h1>Welcome Back</h1>
        <p class="subtitle">Login to your account</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= isset($csrf_token) ? $csrf_token : '' ?>">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="you@email.com"
                    value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="your password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="/register">Register here</a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
