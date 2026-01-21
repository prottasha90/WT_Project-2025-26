<?php

require_once '../models/AstronautModel.php';

$conn = dbConnect();
$userId = $_SESSION['user_id'];

// Handle POST Requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'submit_log') {
        $missionId = $_POST['mission_id'];
        $content = $_POST['log_content'];
        
        if (createMissionLog($conn, $missionId, $userId, $content)) {
            header("Location: index.php?action=my_missions&success=Log Transmitted");
        } else {
            header("Location: index.php?action=my_missions&error=Transmission Failed");
        }
        exit();

    } elseif ($action === 'request_supply') {
        $missionId = $_POST['mission_id'];
        $item = $_POST['item_name'];
        $qty = $_POST['quantity'];
        
        if (createSupplyRequest($conn, $missionId, $userId, $item, $qty)) {
            header("Location: index.php?action=request_supply&success=Request Queued");
        } else {
            header("Location: index.php?action=request_supply&error=Request Failed");
        }
        exit();
    }
}

// View Routing
if ($action === 'astronaut_dashboard') {
    $myMissions = getAssignedMissionsForAstronaut($conn, $userId);
    $myLogs = getLogsByAstronaut($conn, $userId);
    $myRequests = getSupplyRequestsByAstronaut($conn, $userId);
    
    include '../views/astronaut/dashboard.php';

} elseif ($action === 'my_missions') {
    $myMissions = getAssignedMissionsForAstronaut($conn, $userId);
    include '../views/astronaut/missions.php';

} elseif ($action === 'request_supply') {
    $myMissions = getAssignedMissionsForAstronaut($conn, $userId);
    $myRequests = getSupplyRequestsByAstronaut($conn, $userId);
    include '../views/astronaut/requestSupply.php';
}
?>
