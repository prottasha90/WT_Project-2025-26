<?php 
include '../views/common/header.php'; 
require_once '../helpers/profile_helper.php';
$profileImg = getProfileImage($_SESSION['user_id']);
?>

<div class="page-admin-dashboard">
    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
        <img src="<?php echo htmlspecialchars($profileImg); ?>" alt="Director" class="profile-pic-small" 
             style="width: 60px; height: 60px; border-radius: 50%; margin-right: 15px; border: 2px solid var(--primary-color);">
        <div>
            <h2>Mission Control Dashboard</h2>
            <div style="font-size: 0.9rem; color: #a0a6cc;">Welcome, Director <?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Content unchanged -->
        <div class="stat-card">
            <h3>Total Missions</h3>
            <div class="value"><?php echo $stats['total_missions']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Active Astronauts</h3>
            <div class="value"><?php echo $stats['total_astronauts']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Pending Supply Requests</h3>
            <div class="value" style="color: <?php echo $stats['pending_requests'] > 0 ? 'var(--accent-color)' : ''; ?>;">
                <?php echo $stats['pending_requests']; ?>
            </div>
        </div>
    </div>

    <h3 style="margin-top: 3rem;">Incoming Transmissions (Recent Logs)</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Mission</th>
                    <th>Astronaut</th>
                    <th>Log Content</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recentLogs as $log): ?>
                    <tr>
                        <td><?php echo $log['log_date']; ?></td>
                        <td><?php echo htmlspecialchars($log['mission_title']); ?></td>
                        <td><?php echo htmlspecialchars($log['astronaut_name']); ?></td>
                        <td><?php echo htmlspecialchars($log['log_content']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($recentLogs)): ?>
                    <tr><td colspan="4">No recent transmissions received.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
