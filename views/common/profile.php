<?php include '../views/common/header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Manage Profile</h2>
        
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <!-- Profile Picture Section -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <?php $profileImg = getProfileImage($_SESSION['user_id']); ?>
            <img src="<?php echo htmlspecialchars($profileImg); ?>" alt="Profile Picture" 
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-color); margin-bottom: 1rem; box-shadow: 0 0 15px rgba(0,0,0,0.5);">
            
            <form action="index.php?action=upload_profile_pic" method="POST" enctype="multipart/form-data" style="max-width: 300px; margin: 0 auto;">
                <div class="form-group" style="margin-bottom: 0.5rem;">
                    <input type="file" name="profile_pic" class="form-control" style="padding: 5px;" required>
                </div>
                <button type="submit" class="btn" style="padding: 8px 16px; font-size: 0.9rem;">Update Photo</button>
            </form>
        </div>

        <div style="margin-bottom: 2rem; text-align: left;">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst($_SESSION['user_role']); ?></p>
        </div>

        <form action="index.php?action=update_password_post" method="POST">
            <h3>Change Security Clearance</h3>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required minlength="6">
            </div>
            
            <button type="submit" class="btn">Update Password</button>
        </form>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
