<?php

require_once '../models/Mission.php';
require_once '../models/User.php'; // For getting astronauts

$conn = dbConnect();

// Handle Post Requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create_mission') {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $date = $_POST['launch_date'];
        
        if (createMission($conn, $title, $desc, $date)) {
            header("Location: index.php?action=manage_missions&success=Mission Launched");
        } else {
            header("Location: index.php?action=manage_missions&error=Launch Failed");
        }
        exit();

    } elseif ($action === 'delete_mission') {
        $id = $_POST['mission_id'];
        deleteMission($conn, $id);
        header("Location: index.php?action=manage_missions&success=Mission Aborted");
        exit();

    } elseif ($action === 'process_assignment') {
        $missionId = $_POST['mission_id'];
        $astronautId = $_POST['astronaut_id'];
        
        if (assignAstronautToMission($conn, $missionId, $astronautId)) {
            header("Location: index.php?action=assign_astronaut&success=Astronaut Assigned");
        } else {
            header("Location: index.php?action=assign_astronaut&error=Assignment Failed");
        }
        exit();

    } elseif ($action === 'update_supply_status') {
        require_once '../models/AstronautModel.php';
        $requestId = $_POST['request_id'];
        $status = $_POST['status'];
        
        if (updateSupplyRequestStatus($conn, $requestId, $status)) {
            header("Location: index.php?action=manage_supplies&success=Request Updated");
        } else {
            header("Location: index.php?action=manage_supplies&error=Update Failed");
        }
        exit();
    }
}


// Helpers for Views
function getAllAstronauts($conn) {
    $sql = "SELECT * FROM users WHERE role = 'astronaut'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


// View Routing (from index.php)
if ($action === 'admin_dashboard') {
    $stats = getSystemStats($conn);
    // Also get recent logs (simple query here for dashboard)
    $logsRes = mysqli_query($conn, "SELECT ml.*, m.title as mission_title, u.full_name as astronaut_name 
                                    FROM mission_logs ml 
                                    JOIN missions m ON ml.mission_id = m.id 
                                    JOIN users u ON ml.astronaut_id = u.id 
                                    ORDER BY ml.log_date DESC LIMIT 5");
    $recentLogs = mysqli_fetch_all($logsRes, MYSQLI_ASSOC);
    
    include '../views/admin/dashboard.php';


} elseif ($action === 'api_get_recent_logs') {
    // Ajax Endpoint
    header('Content-Type: application/json');
    $logsRes = mysqli_query($conn, "SELECT ml.*, m.title as mission_title, u.full_name as astronaut_name 
                                    FROM mission_logs ml 
                                    JOIN missions m ON ml.mission_id = m.id 
                                    JOIN users u ON ml.astronaut_id = u.id 
                                    ORDER BY ml.log_date DESC LIMIT 5");
    $recentLogs = mysqli_fetch_all($logsRes, MYSQLI_ASSOC);
    echo json_encode($recentLogs);
    exit();

} elseif ($action === 'manage_missions') {
    $allMissions = getAllMissions($conn);
    include '../views/admin/missions.php';

} elseif ($action === 'assign_astronaut') {
    $allMissions = getAllMissions($conn);
    $allAstronauts = getAllAstronauts($conn);
    include '../views/admin/assignAstronaut.php';

} elseif ($action === 'manage_supplies') {
    require_once '../models/AstronautModel.php';
    $supplyRequests = getAllSupplyRequests($conn);
    include '../views/admin/supplies.php';
}
?>
