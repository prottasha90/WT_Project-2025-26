<?php
require_once 'Database.php';

// --- Mission Functions ---

function getAllMissions($conn) {
    $sql = "SELECT * FROM missions ORDER BY launch_date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getMissionById($conn, $id) {
    $sql = "SELECT * FROM missions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function createMission($conn, $title, $description, $launchDate) {
    $sql = "INSERT INTO missions (title, description, launch_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $title, $description, $launchDate);
    return mysqli_stmt_execute($stmt);
}

function updateMission($conn, $id, $title, $description, $launchDate, $status) {
    $sql = "UPDATE missions SET title = ?, description = ?, launch_date = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $description, $launchDate, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function deleteMission($conn, $id) {
    $sql = "DELETE FROM missions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}

// --- Assignment Functions ---

function assignAstronautToMission($conn, $missionId, $astronautId) {
    $sql = "INSERT INTO assignments (mission_id, astronaut_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $missionId, $astronautId);
    return mysqli_stmt_execute($stmt);
}

function getAssignmentsByMission($conn, $missionId) {
    $sql = "SELECT a.*, u.full_name as astronaut_name, u.email 
            FROM assignments a 
            JOIN users u ON a.astronaut_id = u.id 
            WHERE a.mission_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $missionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Helper to get overall system stats for Dashboard
function getSystemStats($conn) {
    $stats = [];
    
    // Total Missions (Active: planned + in-progress)
    $res = mysqli_query($conn, "SELECT COUNT(*) as count FROM missions WHERE status IN ('planned', 'in-progress')");
    $stats['total_missions'] = mysqli_fetch_assoc($res)['count'];

    // Active Missions (in-progress)
    $res = mysqli_query($conn, "SELECT COUNT(*) as count FROM missions WHERE status = 'in-progress'");
    $stats['active_missions'] = mysqli_fetch_assoc($res)['count'];

    // Total Astronauts
    $res = mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role = 'astronaut'");
    $stats['total_astronauts'] = mysqli_fetch_assoc($res)['count'];

    // Pending Supply Requests
    $res = mysqli_query($conn, "SELECT COUNT(*) as count FROM supply_requests WHERE status = 'pending'");
    $stats['pending_requests'] = mysqli_fetch_assoc($res)['count'];

    return $stats;
}

?>
