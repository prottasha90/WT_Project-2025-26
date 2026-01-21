<?php include '../views/common/header.php'; ?>

<div class="page-login-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Mission Control Access</h2>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login_post" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="email">Identity Link (Email)</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="astronaut@beyondorbit.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Security Clearance (Password)</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="form-group" style="display:flex; align-items:center;">
                    <input type="checkbox" name="remember_me" id="remember_me" style="width:auto; margin-right:10px;">
                    <label for="remember_me" style="margin:0; cursor:pointer;">Keep Session Active (Remember Me)</label>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
