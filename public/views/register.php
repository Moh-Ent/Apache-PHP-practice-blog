<?php $title = 'Register'; ?>
<?php require_once __DIR__ . '/layout/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">

        <h1>Create Account</h1>
        <p class="subtitle">Join the community today</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="/register" method="POST">
            <input type="hidden" name="csrf_token" value="<?= isset($csrf_token) ? $csrf_token : '' ?>">

            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username"
                    name="username" 
                    placeholder="your username"
                    value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : '' ?>"
                    required
                >
            </div>

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
                    placeholder="minimum 8 characters"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirm"
                    name="password_confirm" 
                    placeholder="repeat your password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/login">Login here</a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
