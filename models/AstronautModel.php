<?php
require_once 'Database.php';

// --- Mission Logs ---

function createMissionLog($conn, $missionId, $astronautId, $content) {
    $sql = "INSERT INTO mission_logs (mission_id, astronaut_id, log_content) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $missionId, $astronautId, $content);
    return mysqli_stmt_execute($stmt);
}

function getLogsByAstronaut($conn, $astronautId) {
    $sql = "SELECT ml.*, m.title as mission_title 
            FROM mission_logs ml 
            JOIN missions m ON ml.mission_id = m.id 
            WHERE ml.astronaut_id = ? 
            ORDER BY ml.log_date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $astronautId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// --- Supply Requests ---

function createSupplyRequest($conn, $missionId, $astronautId, $itemName, $quantity) {
    $sql = "INSERT INTO supply_requests (mission_id, astronaut_id, item_name, quantity) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisi", $missionId, $astronautId, $itemName, $quantity);
    return mysqli_stmt_execute($stmt);
}

function getSupplyRequestsByAstronaut($conn, $astronautId) {
    $sql = "SELECT sr.*, m.title as mission_title 
            FROM supply_requests sr 
            JOIN missions m ON sr.mission_id = m.id 
            WHERE sr.astronaut_id = ? 
            ORDER BY sr.request_date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $astronautId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllSupplyRequests($conn) {
    $sql = "SELECT sr.*, m.title as mission_title, u.full_name as astronaut_name 
            FROM supply_requests sr 
            JOIN missions m ON sr.mission_id = m.id 
            JOIN users u ON sr.astronaut_id = u.id 
            ORDER BY sr.request_date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function updateSupplyRequestStatus($conn, $requestId, $status) {
    $sql = "UPDATE supply_requests SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $requestId);
    return mysqli_stmt_execute($stmt);
}

// --- Assigned Missions ---

function getAssignedMissionsForAstronaut($conn, $astronautId) {
    $sql = "SELECT m.*, a.assigned_at 
            FROM missions m 
            JOIN assignments a ON m.id = a.mission_id 
            WHERE a.astronaut_id = ? 
            ORDER BY m.launch_date ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $astronautId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>
