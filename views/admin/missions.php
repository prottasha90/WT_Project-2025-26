<?php include '../views/common/header.php'; ?>

<div class="page-admin-missions">
    <h2>Mission Protocols</h2>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div class="dashboard-grid layout-missions-split">
        <!-- Content unchanged -->
        <div class="auth-card" style="margin: 0; max-width: 100%;">
            <h3>Initiate New Protocol</h3>
            <form action="index.php?action=create_mission" method="POST">
                <div class="form-group">
                    <label>Operation Codename (Title)</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Mission Directive (Description)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Launch Window</label>
                    <input type="date" name="launch_date" class="form-control" required>
                </div>

                <button type="submit" class="btn">Authorize Launch</button>
            </form>
        </div>

        <!-- Mission List -->
        <div class="mission-list-container">
            <h3>Active Protocols</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codename</th>
                            <th>Launch Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allMissions as $mission): ?>
                            <tr>
                                <td>#<?php echo $mission['id']; ?></td>
                                <td><?php echo htmlspecialchars($mission['title']); ?></td>
                                <td><?php echo $mission['launch_date']; ?></td>
                                <td>
                                    <span class="badge status-<?php echo $mission['status']; ?>">
                                        <?php echo strtoupper($mission['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="index.php?action=delete_mission" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to abort this mission? This action cannot be undone.');">
                                        <input type="hidden" name="mission_id" value="<?php echo $mission['id']; ?>">
                                        <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 0.8rem; border-color: var(--accent-color); color: var(--accent-color);">ABORT</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
