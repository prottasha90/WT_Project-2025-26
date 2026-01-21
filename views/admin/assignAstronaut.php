<?php include '../views/common/header.php'; ?>

<div class="page-admin-assignment">
    <h2>Personnel Assignment</h2>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div class="auth-wrapper" style="min-height: 50vh;">
        <div class="auth-card" style="max-width: 600px;">
            <h3>Deploy Astronaut to Mission</h3>
        <form action="index.php?action=process_assignment" method="POST">
            <div class="form-group">
                <label>Select Mission Protocol</label>
                <select name="mission_id" class="form-control">
                    <?php foreach($allMissions as $mission): ?>
                        <option value="<?php echo $mission['id']; ?>">
                            <?php echo htmlspecialchars($mission['title']); ?> (<?php echo $mission['status']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select Astronaut</label>
                <select name="astronaut_id" class="form-control">
                    <?php foreach($allAstronauts as $astro): ?>
                        <option value="<?php echo $astro['id']; ?>">
                            <?php echo htmlspecialchars($astro['full_name']); ?> (<?php echo htmlspecialchars($astro['email']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn">Confirm Deployment</button>
        </form>
    </div>
</div>
</div>

<?php include '../views/common/footer.php'; ?>
