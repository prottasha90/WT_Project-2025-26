<?php include '../views/common/header.php'; ?>

<div class="page-register-container">
    <div class="auth-wrapper">
        <div class="auth-card register-card-wide">
            <h2>New Personnel Registration</h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=register_post" method="POST" id="registerForm">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="role">Role Designation</label>
                    <select name="role" id="role" class="form-control">
                        <option value="astronaut">Astronaut</option>
                        <option value="director">Director</option>
                    </select>
                </div>

                <button type="submit" class="btn">Submit Credential Request</button>
                <a href="index.php?action=login" class="btn btn-secondary">Return to Login</a>
            </form>
        </div>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
