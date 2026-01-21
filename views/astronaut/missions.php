<?php include '../views/common/header.php'; ?>

<div class="page-astronaut-missions">
    <h2>My Mission Directives</h2>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <div class="dashboard-grid cards-layout">
        <?php foreach($myMissions as $mission): ?>
            <div class="auth-card mission-card-detail" style="margin: 0; text-align: left; width: auto; max-width: none;">
                <div class="mission-header">
                    <h3><?php echo htmlspecialchars($mission['title']); ?></h3>
                    <span class="badge status-<?php echo $mission['status']; ?>"><?php echo strtoupper($mission['status']); ?></span>
                </div>
                
                <p class="mission-desc"><?php echo htmlspecialchars($mission['description']); ?></p>
                
                <div class="mission-meta">
                    <small>Launch: <?php echo $mission['launch_date']; ?></small>
                </div>

                <hr style="border-color: var(--glass-border); opacity: 0.3; margin: 1.5rem 0;">

                <h4>Transmit Log</h4>
                <form action="index.php?action=submit_log" method="POST">
                    <input type="hidden" name="mission_id" value="<?php echo $mission['id']; ?>">
                    <div class="form-group">
                        <textarea name="log_content" class="form-control" rows="2" placeholder="Enter mission status report..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary action-btn">Transmit Data</button>
                </form>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($myMissions)): ?>
            <div class="alert alert-error">No missions assigned. Contact Director for assignment.</div>
        <?php endif; ?>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
