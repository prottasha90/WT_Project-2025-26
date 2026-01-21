<?php 
include '../views/common/header.php'; 
require_once '../helpers/profile_helper.php';
$profileImg = getProfileImage($_SESSION['user_id']);
?>

<div class="page-astronaut-dashboard">
    <div style="display: flex; align-items: center; margin-bottom: 2rem;">
        <img src="<?php echo htmlspecialchars($profileImg); ?>" alt="Astronaut" class="profile-pic-small" 
             style="width: 80px; height: 80px; border-radius: 50%; margin-right: 20px; border: 3px solid #d946ef; box-shadow: 0 0 15px rgba(217, 70, 239, 0.4);">
        <h2 style="margin: 0; color: #fff;">Mission Status: <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card stat-card-missions">
            <h3>Assigned Missions</h3>
            <div class="value"><?php echo count($myMissions); ?></div>
        </div>
        <div class="stat-card stat-card-logs">
            <h3>Transmissions Sent</h3>
            <div class="value"><?php echo count($myLogs); ?></div>
        </div>
        <div class="stat-card stat-card-supplies">
            <h3>Pending Supplies</h3>
            <div class="value">
                <?php 
                    $pending = 0;
                    foreach($myRequests as $r) if($r['status'] == 'pending') $pending++;
                    echo $pending;
                ?>
            </div>
        </div>
    </div>

    <h3 style="margin-top: 3rem;">Recent Activity</h3>
    <div class="table-container timeline-container">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Time</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($myLogs as $log): ?>
                    <tr>
                        <td><span class="badge" style="background: rgba(0, 212, 255, 0.2); color: #ccf6ff; padding: 2px 6px; border-radius: 4px;">LOG</span></td>
                        <td><?php echo $log['log_date']; ?></td>
                        <td><?php echo htmlspecialchars(substr($log['log_content'], 0, 50)) . '...'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../views/common/footer.php'; ?>
